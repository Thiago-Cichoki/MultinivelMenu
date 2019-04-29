<html ng-app="plenus-app">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Plenus - Sitemas web</title>

        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <link rel="stylesheet" href="../css/style.css">

        <!-- Bootstrap Files        -->
        <link rel="stylesheet" href="../css/bootstrap/bootstrap.css">
        <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css">

        <!-- Fontawesome    -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

        <!-- jquery file -->
        <script src="../js/jquery/jquery-3.3.1.js"></script>
        <script src="../js/jquery/jquery-3.3.1.min.js"></script>

        <!-- Angular Files     -->
        <script src="../js/angular/angular.js"></script>
        <script src="../js/angular/angular.min.js"></script>
        <script src="../js/angular/angular.helpers.js"></script>

        <!-- App.js file-->
        <script src="../js/app.js"></script>

        <!-- Module and Service -->
        <script src="../js/Category/service.js"></script>
        <script src="../js/Category/module.js"></script>
    </head>
    <body>
        <div ng-controller="CategoryController" ng-init="Categories.AjaxList()">
            <div class="container">
                <h1>Menu multinível infinito</h1>
                <div class="menu-bar">
                    <div class="flex-box">
                        <div class="col-md-1">
                            <button class="btn btn-plenus" title="Adicionar categoria" ng-click="AddCategoryOrSubCategory()"><span class="glyphicon glyphicon-plus"></span></button>
                        </div>
                        <div class="col-md-4">
                            <input type="text"
                                   id="input-name"
                                   class="form-control"
                                   ng-model="Categories.selected.name"
                                   placeholder="{{ placeholder }}"
                                   style="display: none;"
                                   ng-enter="Categories.AjaxSave()">
                        </div>
                    </div>
                    <div id="lista-menu" ng-show="Categories.list.length > 0">
                        <!--  Template da lista recursiva  -->
                        <script type="text/ng-template" id="menu.html">
                            <div class="flex-box">
                                <div class="col-md-8">
                                    <span ng-show="menu.id != idEditMode" ng-click="update(menu)" ng-bind="menu.name"></span>
                                    <input type="text"
                                           class="barra-escrita"
                                           ng-model="menu.name"
                                           ng-show="menu.id == idEditMode"
                                           ng-enter="AjaxUpdate()">
                                </div>
                                <div class="col-md-4">
                                    <i class="fas fa-plus add-subcategoria"
                                       id="plus"
                                       title="Adicionar subcategoria à {{ menu.name }}"
                                       ng-click="AddCategoryOrSubCategory(menu);Categories.selected.idParentCategory = menu.id;"></i>
                                    <i  title="Excluir {{ menu.name }}"
                                        id="trash"
                                        class="fas fa-trash add-subcategoria"
                                        ng-click="Categories.AjaxRemove(menu)"></i>
                                </div>
                            </div>
                            <div ng-if="menu.childs.length > 0">
                                <ul>
                                    <li ng-repeat="menu in menu.childs" ng-include="'menu.html'"></li>
                                </ul>
                            </div>
                        </script><!--fim do template-->

                        <!-- Chamada inicial para construção do menu recursivamente -->
                        <ul class="mat-card">
                            <li ng-repeat="menu in Categories.list" ng-include="'menu.html'"></li>
                        </ul>
                    </div>
                </div>
                <div id="sem-categorias" ng-show="Categories.list.length == 0">
                    <h4>Clique no botão acima para adicionar sua primeira categoria.</h4>
                </div>
            </div>
        </div>
    </body>
</html>


