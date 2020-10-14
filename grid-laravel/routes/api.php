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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/requisitar/{id_problema}", "ProblemasController@requisitarTrabalho")->name(".requisitar");
Route::get("/att_status/{id_trabalho}/{status}", "ProblemasController@attStatusTrabalho")->name(".attStatus");

// Route::post("/enviar_resposta", "ProblemasController@enviarResposta")->name(".enviarResposta");
