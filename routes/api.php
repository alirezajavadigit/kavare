<?php 

use System\Router\Api\Route;

//Example
Route::get("home", "HomeController@index", "home");
Route::get("create", "HomeController@create", "create");
Route::post("store", "HomeController@store", "store");