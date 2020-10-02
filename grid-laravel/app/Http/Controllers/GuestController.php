<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller {

    public function baixar() {
        return view("baixar");
    }


    public function sobre() {
        return view("sobre");
    }
}
