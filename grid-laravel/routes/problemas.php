<?php

Route::get("/", "ProblemasController@listarProblemas");
Route::get("/{id}", "ProblemasController@verProblema")->name(".ver");

Route::prefix('{id}/trabalhos')->name('.trabalhos')->group( function() {
    Route::get("/", "TrabalhosController@verTrabalhos")->name(".ver");
    Route::get("/criar", "TrabalhosController@addTrabalhosView")->name(".criar");
    Route::post("/criarSalvar", "TrabalhosController@addTrabalhos")->name(".criar.salvar");
});
