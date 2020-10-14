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

    public function requisitarTrabalho($id_problema) {
        $trabalho = Trabalho::requisitar_trabalho($id_problema);
        if($trabalho) {
            return view('problemas.requisitar', ['trabalho' => $trabalho]);
        }
        return "Erro, nenhum trabalho foi encontrado";
    }

    public function attStatusTrabalho($id_trabalho, $status) {
        $trabalho = Trabalho::attStatus($id_trabalho, $status);
        return view('problemas.requisitar', ['trabalho' => $trabalho]);
    }

    // public function enviarResposta(Request $req) {
    //     $resposta = new Resposta;
    //     // return var_dump($req);
    //     $resposta->conteudo = $req['conteudo'];
    //     $resposta->problema_id = $req['problema_id'];
    //     $resposta->trabalho_id = $req['trabalho_id'];
    //     $resposta->save();
    //     echo $resposta->id;
    // }

}
