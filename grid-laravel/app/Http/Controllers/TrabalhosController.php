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
        $trabalhos = Trabalho::where('problema_id', $id_problema)->get();
        return view('problemas.ver_trabalhos', ['problema' => $problema,
            'trabalhos' => $trabalhos]);
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
    public function enviarResposta(Request $req) {
        $resposta = Resposta::novaResposta($req->trabalho_id, $req->conteudo);
        return response()->json($resposta, 201); // Created
    }

}
