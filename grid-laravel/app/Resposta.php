<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resposta extends Model {

    protected $hidden = ['created_at', 'updated_at'];

    public function problema() {
        return $this->belongsTo("App\Problema");
    }

    public static function novaResposta($trabalho_id, $conteudo) {
        $resposta = new Resposta();
        $resposta->trabalho_id = $trabalho_id;
        $resposta->conteudo = json_encode($conteudo);
        $trabalho = Trabalho::find($trabalho_id);
        if(!$trabalho) {
            return false;
        }
        $resposta->problema_id = $trabalho['problema_id'];
        $resposta->save();

        // Atualiza o status daquele trabalho para finalizado
        Trabalho::attStatus($trabalho_id, Trabalho::Status_finalizado);
        return $resposta;
    }

}
