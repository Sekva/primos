<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get("/", function () {
    return view("welcome");
});

Auth::routes();

Route::get("/home", "HomeController@index")->name("home");

Route::get("/sobre", "GuestController@sobre")->name("sobre");
Route::get("/baixar", "GuestController@baixar")->name("baixar");

Route::prefix('problemas')->name('problemas')->group( function() {
    require 'problemas.php';
});
Route::prefix('api')->name('api')->group( function() {
    require 'api.php';
});
