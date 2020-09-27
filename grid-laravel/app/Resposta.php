<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resposta extends Model {

    public function problema() {
        return $this->belongsTo("App\Problema");
    }

}
