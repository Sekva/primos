<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", function () {
    return view("welcome");
});

Auth::routes();

Route::get("/home", "HomeController@index")->name("home");
Route::get("/teste/{id}", "ProblemasController@teste");

Route::get("/sobre", "GuestController@sobre")->name("sobre");
Route::get("/baixar", "GuestController@baixar")->name("baixar");

Route::get("/problemas", "ProblemasController@listar")->name("problemas");
Route::get("/problemas/{id}", "ProblemasController@ver")->name("problemas.ver");
