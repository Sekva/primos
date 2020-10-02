<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProblemaSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        /*TODO: pegar tanto o nome quanto a descrição dum txt inicialmente */
        $nomes = [
            "Quadrados Perfeitos",
            "Gemeos",
            "Mersenne",
            "Fermat",
            "Goldbath",
        ];

        for($i = 0; $i < sizeof($nomes); $i++) {
            DB::table('problemas')->insert([
                'prioridade' => 1,
                'nome' => $nomes[$i],
                'descricao' => json_encode(array(Str::random(80))),
                'links' => json_encode(array()),
            ]);
        }

    }
}
