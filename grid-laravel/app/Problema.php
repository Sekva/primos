<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Problema extends Model {

    public static function add_trabalhos($numero_trabalhos, $id_problema) {
        $nome_funcao = "add_trabalhos_problema_" . $id_problema;
        return Problema::$nome_funcao($numero_trabalhos);
    }


    private static function add_trabalhos_problema_1($numero_trabalhos) {}
    private static function add_trabalhos_problema_2($numero_trabalhos) {}
    private static function add_trabalhos_problema_3($numero_trabalhos) {}
    private static function add_trabalhos_problema_4($numero_trabalhos) {}
    private static function add_trabalhos_problema_5($numero_trabalhos) {}
    private static function add_trabalhos_problema_6($numero_trabalhos) {}
    private static function add_trabalhos_problema_7($numero_trabalhos) {}

}
