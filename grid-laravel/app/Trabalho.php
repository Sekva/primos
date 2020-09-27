<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabalho extends Model {

    public function problema() {
        return $this->belongsTo("App\Problema");
    }

    public function trabalho() {
        return $this->belongsTo("App\Trabalho");
    }

}
