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

}
