(function () {
    var app = angular.module("angular.helpers", []);


    // alerts
    app.service("$messages", function ($rootScope) {
        return {
            success: function (text, time) {
                this.alert(text, "success", time || 2);
            },
            info: function (text, time) {
                this.alert(text, "info", time || 20);
            },
            error: function (text, time) {
                this.alert(text, "danger", time);
            },
            alert: function (message, type, time) {
                if ($.hasValue(message))
                    $.smkAlert({ text: message.nl2Br(), type: type, time: time || 5 });
            },
            confirm: function (message, success) {
                if (!$.hasValue(message))
                    return;

                $.smkConfirm({
                    text: message.nl2Br(),
                    accept: "Sim",
                    cancel: "Não"
                }, function (e) {
                    if (e) {
                        $rootScope.$applyAsync(success);
                    }
                });
            }
        }
    });

    var $login;
    app.service("$login", function () {
        return $login || ($login = {
            dialog: function () {
                throw "$login.dialog(pendingRequest) not implemented";
            }
        });
    });

    app.service("$request", function ($http, $messages, $login) {

        function parseData(data) {
            if (data == null)
                return null;

            if (typeof data == "string") {
                var date = new Regex(/\/Date\((-?\d+)\)/, data);
                if (date.match)
                    return new Date(date.groups[0].toInt());
            }

            if (typeof data == "object") {
                Object.eachPropertyIn(data, function (key) {
                    data[key] = parseData(data[key]);
                });
            }

            return data;
        }
        function request(options) {
            function makeRequest() {
                $http(options).then(function (r) {
                    validateResult(r.data);
                });
            }
            function validateResult(result) {
                if (!angular.isObject(result) || !("Status" in result)) {
                    $messages.success(result);
                    return;
                }

                var method = result.Status ? "success" : "error";

                if (result.Authenticated && options[method])
                    options[method](parseData(result.Data));

                if (result.Message) {
                    var time = (result.Status ? 2 : 3) + result.Message.length * 0.03;
                    $messages[method](result.Message, time);
                }

                if (!result.Authenticated)
                    $login.dialog(makeRequest);

                if (result.Data && result.Data.Exception)
                    console.error("$EXCEPTION", result.Data.Exception);
            }

            makeRequest();
        }
        function generateOptions(method, args) {
            var options = args[0];

            if (args.length > 1 || typeof (options) != "object") {
                options = {};
                var dataField = method === "GET" ? "params" : "data";

                for (var i in args) {
                    var arg = args[i];
                    if (arg == null) continue;

                    if (typeof arg == "string") {
                        if (!options.url)
                            options.url = arg;
                        else if (!options[dataField])
                            options[dataField] = arg;
                    }

                    if (typeof arg == "object") {
                        if (!options[dataField])
                            options[dataField] = arg;
                    }

                    if (typeof arg == "function") {
                        if (!options.success)
                            options.success = arg;
                        else if (!options.error)
                            options.error = arg;
                    }
                }
            }

            options.method = method;
            options.headers = $.extend(options.headers, { "X-Requested-With": "XMLHttpRequest" });

            if (!("showLoader" in options)) options.showLoader = true;
            if (!("blockScreen" in options)) options.blockScreen = options.method === "POST";

            return options;
        }
        function hasFiles(o) {
            for (var key in o) {
                if (o.hasOwnProperty(key) && !key.startsWith("$$")) {
                    if (o[key] instanceof File)
                        return true;

                    if (angular.isObject(o[key]) && hasFiles(o[key]))
                        return true;
                }
            }
            return false;
        }
        function generateFormData(o) {
            var d = new FormData();

            f(o);

            function f(o, k) {
                for (var key in o) {
                    if (o.hasOwnProperty(key) && !key.startsWith("$$")) {
                        if (k != null) {
                            if ($.isArray(o))
                                c(o, k + "[" + key + "]", o[key]);
                            else
                                c(o, k + "." + key, o[key]);
                        } else {
                            c(o, key, o[key]);
                        }
                    }
                }
            }
            function c(o, k, v) {
                if (v == null) return;

                if (angular.isObject(v) && !(v instanceof File)) {
                    f(v, k);
                    return;
                }

                if ($.isFunction(v)) {
                    if (v.name !== "value")
                        return;

                    v = v.apply(o);
                }

                if ($.isNumber(v)) {
                    // ReSharper disable once QualifiedExpressionMaybeNull
                    v = v.formatToBr();
                    v = v.replace(/\.|,0+$/g, "");
                }

                d.append(k, v);
            }

            return d;
        }

        return {
            get: function () {
                request(generateOptions("GET", arguments));
            },
            post: function () {
                var options = generateOptions("POST", arguments);

                if (hasFiles(options.data) || options.useFormData) {
                    options.data = generateFormData(options.data);
                    options.headers["Content-Type"] = undefined;
                    options.transformRequest = angular.identity;
                }

                request(options);
            },
            redirect: function (url, params) {
                if (params)
                    url += "?" + $.param(params);

                location.href = url;
            }
        }
    });
    app.service("$baseService", function ($request) {
        return function (config) {
            var service = $.extend({}, config);

            if (typeof config.all == "string") {
                service.all = function (success) {
                    $request.get(config.all, success);
                }
            }
            if (typeof config.list == "string") {
                service.list = function (filters, success) {
                    $request.get(config.list, filters, function (r) {
                        filters.totalItems = r.Total;
                        success(r.Result);
                    });
                }
            }
            if (typeof config.get == "string") {
                service.get = function (id, success) {
                    $request.get(config.get, { id }, success);
                };
            }
            if (typeof config.remove == "string") {
                service.remove = function (id, success) {
                    $request.post(config.remove, { id }, success);
                };
            }
            if (typeof config.save == "string") {
                service.save = function (data, success, error) {
                    $request.post(config.save, data, success, error);
                };
            }

            if (typeof config.update == "string") {
                service.update = function (data, success, error) {
                    $request.post(config.save, data, success, error);
                };
            }

            return service;
        }
    });

})();
