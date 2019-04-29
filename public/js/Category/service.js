(function () {
    const app = angular.module("servicesApp");

    app.factory("$categories", ["$http", function ($http) {
            var self = {
                AjaxList: AjaxList,
                AjaxSave: AjaxSave,
                AjaxUpdate: AjaxUpdate,
                AjaxRemove: AjaxRemove,
                list: [],
                selected: null
            };

            return self;

            function AjaxSave() {
                var promise =  new Promise(function (resolve) {
                    resolve(
                        $http.post("/api/Categories/AjaxSave", self.selected)
                            .then(function (response) {
                                self.AjaxList();
                                self.selected = null;
                            })
                    );
                });

                return promise;
            }

            function AjaxList() {
                var promise =  new Promise(function (resolve) {
                        resolve(
                            $http.get("/api/Categories/AjaxList")
                                .then(function (response) {
                                    self.list = response.data;
                                })
                        );
                });

                return promise;
            }

            function AjaxUpdate() {
                var promise =  new Promise(function (resolve) {
                    resolve(
                        $http.post("/api/Categories/AjaxUpdate", self.selected)
                            .then(function (response) {
                                self.AjaxList();
                            })
                    );
                });

                return promise;
            }

            function AjaxRemove(category) {
                var promise =  new Promise(function (resolve) {
                    resolve(
                        $http.delete("/api/Categories/AjaxRemove/" + category.id)
                            .then(function (response) {
                                self.AjaxList();
                            })
                    );
                });

                return promise;
            }

    }]);
})();
