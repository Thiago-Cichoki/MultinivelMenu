<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::match(['get', 'post', 'delete'],"/{controller}/{action}/{id?}", function ($controller, $action, $id = null, Request $request){
        $classController = $controller . "Controller";

        $classController = "\\App\\Http\\Controllers\\" . $classController;

        if (!class_exists($classController))
        {
            return json_encode("Class not found");
        }

        $controllerInstance = new $classController();

        if (!method_exists($controllerInstance, $action))
        {
            return json_encode("This method does not exist in this classs");
        }

        $parameters = $request->all();

        if (isset($id) && $id !== null)
        {
            return $controllerInstance->$action(['id' => $id]);
        }
        return $controllerInstance->$action($parameters);
});
