<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Problema;
use App\Trabalho;
use App\Resposta;

class ProblemasController extends Controller {

    /* Exemplo de uso:
     * Problema::add_trabalhos($numero_trabalhos, $id_problema)
     */

    public function listar() {
        $problemas = Problema::paginate(2);
        return view("problemas.lista_problemas", ["problemas" => $problemas]);
    }

    public function ver($id_problema) {
        $problema = Problema::find($id_problema);
        return view('problemas.ver_problema', ['problema' => $problema]);
    }

    public function verTrabalhos($id_problema) {
        $problema = Problema::find($id_problema);
        $trabalhos = Trabalho::where('problema_id', $id_problema)->get();
        return view('problemas.ver_trabalhos', ['problema' => $problema,
            'trabalhos' => $trabalhos]);
    }

    public function addTrabalhosView($id_problema) {
        $problema = Problema::find($id_problema);
        return view('problemas.adicionar_trabalhos', ['problema' => $problema]);
    }

    public function addTrabalhos(Request $request) {
        Problema::add_trabalhos($request->id, $request->quant);
        return $this->verTrabalhos($request->id);
    }

    // Método que retorna um trabalho de um dado problema (que segue uma
    // métrica de escolha).
    // Ou retorna um determinado trbalho (parametro opcional)
    public function requisitarTrabalho($id_problema, $id_trabalho = -1) {
        if($id_trabalho != -1) {
            $trabalho = Trabalho::find($id_trabalho);
        } else {
            $trabalho = Trabalho::requisitar_trabalho($id_problema);
        }
        if($trabalho) {
            return response()->json($trabalho, 201);
        }
        return "Erro, nenhum trabalho foi encontrado";
    }

    public function attStatusTrabalho(Request $request) {
        $id_trabalho = $request->trabalho_id;
        $status = $request->status;

        // TODO: fazer filtros e tratamentos para os dados que serão entregues e recebidos pela api (ex: ver se estatus existe)

        $trabalho = Trabalho::attStatus($trabalho_id, $status);
        return response()->json($trabalho, 201); //TODO: estudar e atualizar o numero do tipo de resposta do servidor
    }

    public function enviarResposta(Request $req) {
        $resposta = Resposta::novaResposta($req->trabalho_id, $req->conteudo);
        return response()->json($resposta, 201);
    }

}
