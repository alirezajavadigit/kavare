<?php 

use System\Router\Web\Route;

//Example
Route::get("home", "HomeController@index", "home");
Route::get("create", "HomeController@create", "create");
Route::post("store", "HomeController@store", "store");
Route::get("edit/{id}", "HomeController@edit", "edit");
Route::put("update/{id}", "HomeController@update", "update");
Route::delete("delete/{id}", "HomeController@destroy", "delete");