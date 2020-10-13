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
    Route::get("/", "ProblemasController@listar");
    Route::get("/{id}", "ProblemasController@ver")->name(".ver");

    Route::prefix('{id}/trabalhos')->name('.trabalhos')->group( function() {
        Route::get("/", "ProblemasController@verTrabalhos")->name(".ver");
        Route::get("/criar", "ProblemasController@addTrabalhosView")->name(".criar");
        Route::post("/criarSalvar", "ProblemasController@addTrabalhos")->name(".criar.salvar");
        Route::get("/requisitar", "ProblemasController@requisitarTrabalho")->name(".requisitar");
    });

});
