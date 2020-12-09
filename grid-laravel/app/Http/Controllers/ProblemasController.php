<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Problema;
use App\Trabalho;
use App\Resposta;

class ProblemasController extends Controller {

    // TODO: fazer filtros e tratamentos para os dados que serão entregues e
    // recebidos pela api (ex: ver se estatus existe)
    // TODO: Documentar direito


    // Lista os Problemas
    public function listarProblemas() {
        $problemas = Problema::paginate(2);
        return view("problemas.lista_problemas", ["problemas" => $problemas]);
    }

    // Visualizar um Problema (infos em geral)
    public function verProblema($id_problema) {
        $problema = Problema::find($id_problema);
        return view('problemas.ver_problema', ['problema' => $problema]);
    }

}
