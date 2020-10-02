<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Problema;

class ProblemasController extends Controller {

    /* Exemplo de uso:
     * Problema::add_trabalhos($numero_trabalhos, $id_problema)
     */

    public function teste($id) {
        var_dump(Problema::add_trabalhos(12, $id));
    }


    public function listar() {
        $problemas = Problema::paginate(2);
        return view("lista_problemas", ["problemas" => $problemas]);
    }

    public function ver($id_problema) {
        return "listar problemas $id_problema";
    }
}
