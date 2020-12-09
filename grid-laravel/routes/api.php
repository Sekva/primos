<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get("/", function() {
    return 'Rota para a api. Veja documentação em: <a href="httpp://www.abc.com.br">site</a>';
});

Route::get("/requisitar/{id_problema}", "TrabalhosController@requisitarTrabalho")->name(".requisitar");
Route::put("/att_status", "TrabalhosController@attStatusTrabalho")->name(".attStatus");
Route::post("/enviar_resposta", "TrabalhosController@enviarResposta")->name(".enviarResposta");


//
