<?php

    // Nesse arquivo pode será definido valores de parâmetros
    // globais. Para facilitar a manutenção do projeto.

    // Além da definição de métodos de configuração de
    // leitura do arquivo de configuração .env, para utilização
    // nos métodos de conexão do banco de dados.

    class Configurar {


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
        public static $tempoMinimoDeProcessamento = 20;
        public static $tempoMaximoDeProcessamento = (60 * 2);


        // Definição do tempo para considerar um processo como adormecido
        // (em segundos)
        public static $tempoProcessoAdormecido = (60 * 4);


        //public static $var = 0;

        // ==========================================


        // Método para leitura do arquivo de configuração .env
        public static function lerConfig() {
            $nome_arquivo = ".env";
            $arquivo = file_get_contents($nome_arquivo);
            if($arquivo === false) {
                echo "Erro ao tentar acessar o arquivo de configuração .env";
                die();
            }
            $json_aberto = json_decode($arquivo, true);
            return $json_aberto;
        }

        // Método para retono das confgigurações do banco
        // de dados principal
        public static function getConfigBancoPrincipal() {
            $res = self::lerConfig();
            return $res['BancoDeDados']['BancoPrincipal'];
        }

    }

 ?>
