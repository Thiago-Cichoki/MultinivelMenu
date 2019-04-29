(function () {
        const app = angular.module("plenus-app");

        app.controller("CategoryController", function ($scope, $categories) {
                $scope.Categories = $categories;
                $scope.placeholder = "Livros, Música...";

                $scope.AddCategoryOrSubCategory = function(category = null){
                    $("#input-name").fadeIn();
                    if (category != null){
                        $scope.placeholder = "Adicionar subcategoria de " + category.name;
                        return;
                    }
                    $scope.placeholder = "Livros, Música...";
                    $scope.Categories.selected = null;
                };

                $scope.update = function(category){
                    $scope.idEditMode = category.id;
                    $scope.Categories.selected = category;
                };

                $scope.AjaxUpdate = function () {
                    $categories.AjaxUpdate().then(function () {
                        $scope.idEditMode = null;
                    });
                };
        });
})();
