<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Configuracao;

class Trabalho extends Model {

    protected $hidden = ['created_at', 'updated_at'];

    const Status_livre = 0;
    const Status_processando = 1;
    const Status_finalizado = 3;

    public function problema() {
        return $this->belongsTo("App\Problema");
    }

    public function trabalho() {
        return $this->belongsTo("App\Trabalho");
    }

    public static function attStatus($trabalho_id, $status) {
        $trabalho = Trabalho::find($trabalho_id);
        if(!$trabalho) {
            return false;
        }
        $trabalho->status = $status;
        if(intval($status) == Trabalho::Status_processando) {
            $trabalho->ultima_vez_requisitado = time();
        }
        $trabalho->save();
        return $trabalho;
    }

    private static function varrerEAtualizarProcessos() {
        $time = time();
        $tempoLimite = $time - Configuracao::$tempoProcessoAdormecido;

        # Coleta todos os trabalhos desatualizados
        $trabalhos_desatualizados = Trabalho::where(
            [
                ['status', '=', Trabalho::Status_processando],
                ['ultima_vez_requisitado', '<=', $tempoLimite],
            ]
        )->get(); // Sim, dei um \n pra verem que isso é um where

        # Atualiza o status dos trabalhos desatualizados
        foreach ($trabalhos_desatualizados  as $t) {
            self::attStatus($t->id, Trabalho::Status_livre);
        }
    }


    public static function requisitar_trabalho($id_problema) {
        $ran = rand(1, Configuracao::$randAttProcAdormecidos);
        if($ran == 1) {
            // Atualizar processos adormecidor (cliente parou antes de terminar)
            self::varrerEAtualizarProcessos();
        }

        // Pega os trabalhos e ordena para os mais antigos aparecerem primeiro
        $trabalhos = Trabalho::where('status', Trabalho::Status_livre)
        ->where('problema_id', $id_problema)
        ->limit(Configuracao::$quantProxProcParaRandomizar)
        ->orderBy('ultima_vez_requisitado', 'asc')
        ->select('id')
        ->get();

        if($trabalhos->count() == 0) {
            return;
        }
        $num_rand = rand(0, $trabalhos->count()-1);
        $trabalho_selecionado = Trabalho::find($trabalhos[$num_rand]);
        return $trabalho_selecionado;
    }

    // Esse método não recebe o número de tralhalhos a ser adicionado
    // Mas sim a quantidade de números p's
    public static function add_trabalhos_problema_1($quant_ps_add) {
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
                $resultado = Trabalho::where('problema_id', 1)->max('id');
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

            $conteudo_novo_trabalho = [
                'p' => $valor_inicial_p,
                'q' => $valor_inicial_q,
                'k' => $k_atual
            ];
            $novo_trabalho->conteudo = json_encode($conteudo_novo_trabalho);
            $novo_trabalho->status = Trabalho::Status_livre;
            $novo_trabalho->problema_id = 1;
            $novo_trabalho->ultima_vez_requisitado = time();

            $novo_trabalho->save();
        }
    }



    public static function add_trabalhos_problema_2($numero_trabalhos) {
        $quantidade_teste = 5000;
        $k = 4;

        $prox_p = 0;
        for($i = $numero_trabalhos; $i > 0; $i -= 1) {

            // Para evitar ficar requisitando ao banco de dados
            // -> Só vai requisitar na primeira iteração
            if($i == $numero_trabalhos) {

                // Seleciona o ultimo processo adicionado
                $resultado = Trabalho::where('problema_id', 2)
                    // Para trabalhar com qualquer k sem interferir um no outro
                    ->whereJsonContains('conteudo->k', $k)
                    ->max('id');
                $resultado = Trabalho::find($resultado);

                // Caso em que no banco já tem algum dado
                if($resultado) {
                    $conteudo = json_decode($resultado->conteudo);
                    $prox_p = intval($conteudo->valor_inicial_p);
                    $ultima_quant_teste = intval($conteudo->quantidade);;
                    $prox_p += $ultima_quant_teste;
                }
            } else {
                $prox_p += $quantidade_teste;
            }

            // Adiciona um novo processo
            $novo_trabalho = new Trabalho;

            $conteudo_novo_trabalho = [
                'valor_inicial_p' => $prox_p,
                'quantidade' => $quantidade_teste,
                'k' => $k,
            ];
            $novo_trabalho->conteudo = json_encode($conteudo_novo_trabalho);
            $novo_trabalho->status = Trabalho::Status_livre;
            $novo_trabalho->problema_id = 2;
            $novo_trabalho->ultima_vez_requisitado = time();

            $novo_trabalho->save();

        }
    }


    public static function add_trabalhos_problema_3($numero_trabalhos) {}
    public static function add_trabalhos_problema_4($numero_trabalhos) {}
    public static function add_trabalhos_problema_5($numero_trabalhos) {}
    public static function add_trabalhos_problema_6($numero_trabalhos) {}
    public static function add_trabalhos_problema_7($numero_trabalhos) {}

}
