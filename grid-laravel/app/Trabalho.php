<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Configuracao;

class Trabalho extends Model {

    public function problema() {
        return $this->belongsTo("App\Problema");
    }

    public function trabalho() {
        return $this->belongsTo("App\Trabalho");
    }

    private static function varrerEAtualizarProcessos() {
        $time = time();
        $tempoLimite = $time - Configuracao::$tempoProcessoAdormecido;

        # Coleta todos os trabalhos desatualizados
        $trabalhos_desatualizados = Trabalho::where([
            ['status', '=', 1],
            ['ultima_vez_requisitado', '<=', $tempoLimite
        ]])
        ->get();

        # Atualiza os trablhos desatualizados
        foreach ($trabalhos_desatualizados  as $t) {
            $t['status'] = 0;
            $t->save();
        }
    }

    // Esse método não recebe o número de tralhalhos a ser adicionado
    // Mas sim a quantidade de números p's
    private static function add_trabalhos_problema_1($quant_ps_add) {
        /*
        O campo 'conteudo' armazena os dados bo seguinte formato:
        {
            "p":x
            "q":y
            "k":z
        }
        */

        $k_atual = 19999;

        $count_ps_add = 0; // quantidade de p's já adicionados
        $aux_p = 0;
        $aux_q = 0;
        while($count_ps_add < $quant_ps_add) {

            // Para evitar ficar requisitando ao banco de dados
            // o ultimo processo salvo toda vez que for add um;
            // -> Só vai requisitar na primeira iteração
            if($count_ps_add == 0) {

                // Seleciona o ultimo processo adicionado
                $resultado = Trabalho::where('status', '!=', 2)->max('id');
                $resultado = Trabalho::find($resultado);
                if($resultado) {
                    // Caso em que no banco já tem algum dado
                    $conteudo = json_decode($resultado->conteudo);
                    $ultimo_valor_p = intval($conteudo->p);
                    $ultimo_valor_q = intval($conteudo->q);
                    $ultimo_valor_k = intval($conteudo->k);
                } else {
                    // Caso em que no banco não tem nenhum dado
                    $ultimo_valor_p = -1; // Aqui será somado 1 mais em baixo
                    $ultimo_valor_q = -1; // Esse valor será sobreposto mais em baixo
                    $ultimo_valor_k = $k_atual;
                }

            } else {
                $ultimo_valor_p = $aux_p;
                $ultimo_valor_q = $aux_q;
                $ultimo_valor_k = $k_atual;
            }

            // ex: [p=200, q=100, k=99]
            if($ultimo_valor_q < $ultimo_valor_p) {
                // Evitar problema de q ficar maior que p depois da soma.
                // ex: [p=2, q=0, k=3]
                if($ultimo_valor_q + $ultimo_valor_k > $ultimo_valor_p) {
                    $valor_inicial_p = $ultimo_valor_p;
                    $valor_inicial_q = $ultimo_valor_p;
                } else {
                    $valor_inicial_p = $ultimo_valor_p;
                    $valor_inicial_q = $ultimo_valor_q + $ultimo_valor_k + 1;
                }
                if($valor_inicial_p == $valor_inicial_q) {
                    $count_ps_add += 1; // Completou um ciclo do p
                }
            // ex: [p=200, q=200] | [p=-1, q=-1]
            } else if($ultimo_valor_p == $ultimo_valor_q) {
                if($ultimo_valor_p == -1) {
                    $valor_inicial_p = 0;
                } else {
                    $valor_inicial_p = $ultimo_valor_p + $ultimo_valor_k + 1;
                }
                $valor_inicial_q = 0;
            // ex: [p=200, q=300]
            } else { // Isso não deveria acontecer em tese
                echo "Erro, isso não deveria acontecer| p = " . $ultimo_valor_p . ", q = " . $ultimo_valor_q . "<br>";
                break;
            }

            $aux_p = $valor_inicial_p;
            $aux_q = $valor_inicial_q;

            // Adiciona um novo processo
            $novo_trabalho = new Trabalho;
            $novo_trabalho->status = 0;

            $conteudo_novo_trabalho = ['p' => $valor_inicial_p,
                'q' => $valor_inicial_q,
                'k' => $k_atual];
            $novo_trabalho->conteudo = json_encode($conteudo_novo_trabalho);

            $novo_trabalho->problema_id = 1;
            $novo_trabalho->ultima_vez_requisitado = time();

            // var_dump(json_encode(array($novo_trabalho)));
            $novo_trabalho->save();

        }
    }

    public static function requisitar_trabalho_problema_1() {
        $ran = rand(1, Configuracao::$randAttProcAdormecidos);
        if($ran == 1) {
            // Atualizar processos adormecidor (cliente parou antes de terminar)
            self::varrerEAtualizarProcessos();
        }

        // Pega os trabalhos e ordena para os mais antigos aparecerem primeiro
        $trabalhos = Trabalho::where('status', 0)
        ->limit(Configuracao::$quantProxProcParaRandomizar)
        ->orderBy('ultima_vez_requisitado', 'asc')
        ->get();

        $num_rand = rand(0, $trabalhos->count()-1);
        return $trabalhos[$num_rand];
    }


    private static function add_trabalhos_problema_2($numero_trabalhos) {}
    private static function add_trabalhos_problema_3($numero_trabalhos) {}
    private static function add_trabalhos_problema_4($numero_trabalhos) {}
    private static function add_trabalhos_problema_5($numero_trabalhos) {}
    private static function add_trabalhos_problema_6($numero_trabalhos) {}
    private static function add_trabalhos_problema_7($numero_trabalhos) {}

    private static function requisitar_trabalho_problema_2() {}
    private static function requisitar_trabalho_problema_3() {}
    private static function requisitar_trabalho_problema_4() {}
    private static function requisitar_trabalho_problema_5() {}
    private static function requisitar_trabalho_problema_6() {}
    private static function requisitar_trabalho_problema_7() {}
}
