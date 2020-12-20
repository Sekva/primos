<?php

namespace App;

use App\Trabalho;

use Illuminate\Database\Eloquent\Model;

class Problema extends Model {

    public static function add_trabalhos($id_problema, $numero_trabalhos) {
        $nome_funcao = "add_trabalhos_problema_" . $id_problema;
        return Trabalho::$nome_funcao($numero_trabalhos);
    }

}
