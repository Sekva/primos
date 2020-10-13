<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Problema;
use App\Trabalho;

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
        $trabalho = Problema::requisitar_trabalho($id_problema);
        return view('problemas.requisitar', ['trabalho_json' => $trabalho->conteudo]);
    }
}
