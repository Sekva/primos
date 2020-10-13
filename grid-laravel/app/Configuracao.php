<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model {

    // Definição do intervalo de valor para ativação
    // do método 'varrerEAtualizarProcessos()'
    // probabilidade de 1/n, sendo n o valor definido.
    public static $randAttProcAdormecidos = 20;

    // Para evitar a entrega de processos iguais em
    // diferentes requisições, é coletado um numero n
    // de processos (os n mais antigos) e depois
    // escolhido randomicamente um dos n.
    // Aqui é definido o n;
    public static $quantProxProcParaRandomizar = 20;


    // Aqui é definido parametros de segurança para evitar
    // uma grande quantidade de requests em curtos periodos de
    // tempo. Sendo esse tempo definido em segundo.
    // Um tempo mínimo e um tempo máximo é definido para que seja
    // respeitado, e só assim a submissão será aceita.
    public static $tempoMinimoDeProcessamento = 5;
    public static $tempoMaximoDeProcessamento = (60 * 2);


    // Definição do tempo para considerar um processo como adormecido
    // (em segundos)
    public static $tempoProcessoAdormecido = (60 * 4);

}
