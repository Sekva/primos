<?php

    // Este arquivo representa o 'coração LÓGICO' do dado projeto;
    // E aqui onde será desenvolvido a LÓGICA entre a conexão
    // do Nó Mestre (servidor) e Nós Escravos (clientes).

    // Nesse sentido, falando com outras palavras, neste arquivo
    // os dados serão coletados e tratados para com o armazenamento
    // ou coleta no banco de dados. Executando comandos SQL.

    // =============================================================

    // Inclusão dos arquivos de configuração do projeto e conexão
    // do banco de dados.
    require_once 'ConexaoDB.php';
    require_once 'Configurar.php';

    //

    // Construção da classe para o projeto
    class Problema2 extends ConexaoDB {

        // Função definida para criação de um trabalho (processo)
        // Tendo k padrão = 99
        public static function criar($quant_add, $quantidade_teste = 5000, $k = 2) {

            $connect = parent::dbConnect();

            $prox_p = 0;
            for($i = $quant_add; $i > 0; $i -= 1) {

                // Para evitar ficar requisitando ao banco de dados
                // -> Só vai requisitar na primeira iteração
                if($i == $quant_add) {

                    // Seleciona o ultimo processo adicionado
                    $sql = "SELECT *
                        FROM pesquisa.trabalhos_prob2
                        WHERE k = ".$k."
                        ORDER BY valor_inicial_p DESC
                        LIMIT 1";

                    $resultado = $connect->query($sql);
                    $resultado = $resultado->fetch_assoc(); // Pega o primeiro

                    // Caso em que no banco já tem algum dado
                    if($resultado != FALSE) {
                        $prox_p = intval($resultado['valor_inicial_p']);
                        $ultima_quant_teste = intval($resultado['quantidade']);
                        $prox_p += $ultima_quant_teste;
                    }
                } else {
                    $prox_p += $quantidade_teste;
                }

                // Adiciona um novo processo
                $sql = "INSERT INTO pesquisa.trabalhos_prob2
                    (status, valor_inicial_p, quantidade, k,
                    tempo_ultima_vez_requisitado)
                    VALUES (0, " . $prox_p . ", " . $quantidade_teste . "
                    , " . $k . ", '0')";

                if ($connect->query($sql) === FALSE) {
                    require_once 'error.php';
                    $msg = "Location: ./error.php?msg=";
                    $msg = $msg . "Error: " . $sql . "<br>" . $connect->error;
                    header($msg);
                }

            }

            parent::dbDisconect($connect);
        }


        public static function getTrabalhoLivre() {
            $connect = parent::dbConnect();

            $ran = rand(1, Configurar::$randAttProcAdormecidos);
            if($ran == 1) {
                // Atualizar processos adormecidor (cliente parou antes de terminar)
                self::varrerEAtualizarProcessos();
            }

            // Lista ordenada dos N processos mais antigos
            $sql = "SELECT id, valor_inicial_p, quantidade, k FROM pesquisa.trabalhos_prob2 WHERE status = 0 ORDER BY tempo_ultima_vez_requisitado LIMIT " . Configurar::$quantProxProcParaRandomizar;

            $resultado = $connect->query($sql);

            parent::dbDisconect($connect);

            if ($resultado->num_rows > 0) {
                // Randomização da escolha entre a lista de processos mais antigos
                // Para evitar (mesmo que bastante raro) o duplo processamento
                $escolhaRandomica = rand(1, $resultado->num_rows);
                $count = 1;
                while($count <= $resultado->num_rows) {
                    $row = $resultado->fetch_assoc();
                    if($count == $escolhaRandomica) {
                        $resultado = $row;
                        break;
                    }
                    $count = $count + 1;
                }

            } else {
                $msg = "Location: ./error.php?msg=";
                $msg = $msg . "Nao foi possivel requisitar uma nova configuração, não foi encontrado trabalho.";
                header($msg);
            }

            return $resultado;
        }


        // Atualiza o status do processo
        public static function attStatusProcesso($id, $status) {
            $connect = parent::dbConnect();
            $status = intval($status);
            // Att status
            if($status == 1) { // status = processando, logo, atualiza o tempo de requisicao
                $sql = "UPDATE pesquisa.trabalhos_prob2 SET status=" . $status . ", tempo_ultima_vez_requisitado=" . time() . " WHERE id=" . $id;
            } else if($status == 3) { // Quando terminar por completo o processamento do trabalho
                // Só atualiza pra concluído se o processo foi executado no tempo correto (antes do seu vencimento)
                $time = time();
                $tempo_maximo_aux = $time - Configurar::$tempoMaximoDeProcessamento;
                $tempo_minimo_aux = $time - Configurar::$tempoMinimoDeProcessamento;
                $sql = "UPDATE pesquisa.trabalhos_prob2 SET status=" . $status . " WHERE id=" . $id . " AND tempo_ultima_vez_requisitado >= " . $tempo_maximo_aux . " AND tempo_ultima_vez_requisitado <= " . $tempo_minimo_aux;
            } else {
                $sql = "UPDATE pesquisa.trabalhos_prob2 SET status=" . $status . " WHERE id=" . $id;
            }

            $resultado = $connect->query($sql);

            if($resultado == FALSE) {
                require_once 'error.php';
                $msg = "Location: ./error.php?msg=";
                $msg = $msg . "Error: Ao atualizar status [error: 293872] " . $sql;
                header($msg);
            } else {
                echo "ok";
            }

            parent::dbDisconect($connect);
        }

        // Adiciona uma resposta
        public static function addResposta($p, $q, $p_i, $q_i, $k) {

            $connect = parent::dbConnect();

            // Add resposta
            $sql = "INSERT INTO pesquisa.resultados_prob2 (primo_p, primo_q, indice_primo_p, indice_primo_q, k) VALUES (" . $p . ", " . $q . ", " . $p_i . ", " . $q_i . ", " . $k . ")";
            $resultado = $connect->query($sql);

            if($resultado == FALSE) {
                require_once 'error.php';
                $msg = "Location: ./error.php?msg=";
                $msg = $msg . "Error: Ao adicionar um novo resultado [error: 237623]";
                header($msg);
            }

            parent::dbDisconect($connect);
        }


        // Retorna todas as respostas
        public static function getResultados() {

            $connect = parent::dbConnect();

            // Coleta as respostas
            $sql = "SELECT * FROM pesquisa.resultados_prob2";
            $resultado = $connect->query($sql);

            if($resultado == FALSE) {
                require_once 'error.php';
                $msg = "Location: ./error.php?msg=";
                $msg = $msg . "Error: Ao adicionar um novo resultado [error: 237623]";
                header($msg);
            }

            parent::dbDisconect($connect);

            return $resultado;
        }

        // Atualiza os processos adormecidos
        public static function varrerEAtualizarProcessos() {
            $connect = parent::dbConnect();

            $time = time();
            $tempoLimiteProcessoAdormecido = $time - Configurar::$tempoProcessoAdormecido;
            // Atualiza processos adormecidos
            $sql = "UPDATE pesquisa.trabalhos_prob2 SET status=0 WHERE status=1 AND tempo_ultima_vez_requisitado <= " . $tempoLimiteProcessoAdormecido;
            $resultado = $connect->query($sql);

            if($resultado == FALSE) {
                require_once 'error.php';
                $msg = "Location: ./error.php?msg=";
                $msg = $msg . "Error: Ao atualizar processos adormecidos [error: 382722]";
                header($msg);
            }

            parent::dbDisconect($connect);
        }


        public function getQuantProcFinalizados() {
            $connect = parent::dbConnect();

            // Coleta a quantidade de processos ja finalizados
            $sql = "SELECT count(id) FROM pesquisa.trabalhos_prob2 WHERE status <> 0";
            $resultado = $connect->query($sql);

            if($resultado == FALSE) {
                require_once 'error.php';
                $msg = "Location: ./error.php?msg=";
                $msg = $msg . "Error: Ao adicionar um novo resultado [error: 276823]";
                header($msg);
            }

            parent::dbDisconect($connect);

            return $resultado;
        }


    }

?>
