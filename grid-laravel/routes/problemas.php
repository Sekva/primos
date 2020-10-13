<?php

Route::get("/", "ProblemasController@listar");
Route::get("/{id}", "ProblemasController@ver")->name(".ver");

Route::prefix('{id}/trabalhos')->name('.trabalhos')->group( function() {
    Route::get("/", "ProblemasController@verTrabalhos")->name(".ver");
    Route::get("/criar", "ProblemasController@addTrabalhosView")->name(".criar");
    Route::post("/criarSalvar", "ProblemasController@addTrabalhos")->name(".criar.salvar");
    Route::get("/requisitar", "ProblemasController@requisitarTrabalho")->name(".requisitar");
});
