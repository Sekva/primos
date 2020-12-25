<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Problema;
use App\Trabalho;
use App\Resposta;


class TrabalhosController extends Controller {

    /*
    * Tipos de respostas:
    * 200: OK
    * 201: Created
    * 204: No Content
    * 400: Bad Request
    * 401: Unauthorized
    * 404: Not Found
    * 405: Method Not Allowed
    * 409: Conflict
    * 422: Unprocessable Entity
    * 500: Internal Server Error
    */


    // Mostra todos os trabalhos
    public function verTrabalhos($id_problema) {
        $problema = Problema::find($id_problema);
        $quant_trabalhos_total = Trabalho::where('problema_id', $id_problema)->count();
        $quant_trabalhos_processados = Trabalho::where('problema_id', $id_problema)
            ->where('status', Trabalho::Status_finalizado)->count();

        $numero_tralhos_por_pagina = 50;
        $trabalhos = Trabalho::where('problema_id', $id_problema)->paginate(100);
        $arquivo = 'problemas.ver_trabalho_' . $id_problema;
        return view($arquivo,
                [
                    'problema' => $problema,
                    'trabalhos' => $trabalhos,
                    'numero_tralhos_por_pagina' => $numero_tralhos_por_pagina,
                    'quant_trabalhos_total' => $quant_trabalhos_total,
                    'quant_trabalhos_processados' => $quant_trabalhos_processados,
                ]
            );
    }

    // Método que retorna a view de adição de trabalhos para um problema
    public function addTrabalhosView($id_problema) {
        $problema = Problema::find($id_problema);
        return view('problemas.adicionar_trabalhos', ['problema' => $problema]);
    }

    // Método que chama a adição dos novos trabalhos
    public function addTrabalhos(Request $request) {
        Problema::add_trabalhos($request->id, $request->quant);
        return redirect(route("problemas.trabalhos.ver", $request->id));
    }

    // Método que retorna um trabalho de um dado problema (que segue uma
    // métrica de escolha).
    // Ou retorna um determinado trabalho (parametro opcional)
    public function requisitarTrabalho($problema_id, $trabalho_id = -1) {
        if($trabalho_id != -1) {
            $trabalho = Trabalho::find($trabalho_id);
        } else {
            $trabalho = Trabalho::requisitar_trabalho($problema_id);
        }
        if($trabalho) {
            return response()->json($trabalho, 200); //OK
        }
        return response()->json(["message" => "Erro, nenhum trabalho foi encontrado"], 200); // OK
    }

    public function attStatusTrabalho(Request $request) {
        $trabalho_id = $request->trabalho_id;
        $status = $request->status;
        $trabalho = Trabalho::attStatus($trabalho_id, $status);
        if(!$trabalho) {
            return response()->json(["message" => "Trabalho inexistente!"], 200); // OK
        }
        return response()->json($trabalho, 200); // OK
    }

    // Recebe a submissão de uma resposta
    public function enviarResposta(Request $request) {
        $resposta = Resposta::novaResposta($request->trabalho_id, $request->conteudo);
        if($resposta == false) {
            return response()->json($request, 406); // Erro
        }
        return response()->json($resposta, 201); // Created
    }

}
