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
    class Problema1 extends ConexaoDB {

        // Função definida para criação de um trabalho (processo)
        // Tendo k padrão = 99
        public static function criar($quant_ps_add, $k_atual = 99) {

            $connect = parent::dbConnect();

            $count_ps_add = 0; // quantidade de p's já adicionados
            $aux_p = 0;
            $aux_q = 0;
            while($count_ps_add < $quant_ps_add) {

                // Para evitar ficar requisitando ao banco de dados
                // o ultimo processo salvo toda vez que for add um;
                // -> Só vai requisitar na primeira iteração
                if($count_ps_add == 0) {

                    // Seleciona o ultimo processo adicionado
                    $sql = "SELECT *
                        FROM pesquisa.trabalhos_prob1
                        ORDER BY id DESC
                        LIMIT 1";

                    $resultado = $connect->query($sql);
                    $resultado = $resultado->fetch_assoc(); // Pega o primeiro

                    if($resultado != FALSE) {
                        // Caso em que no banco já tem algum dado
                        $ultimo_valor_p = intval($resultado['valor_inicial_p']);
                        $ultimo_valor_q = intval($resultado['valor_inicial_q']);
                        $ultimo_valor_k = intval($resultado['k']);
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
                $sql = "INSERT INTO pesquisa.trabalhos_prob1
                    (status, valor_inicial_p, valor_inicial_q, k,
                    tempo_ultima_vez_requisitado)
                    VALUES (0, " . $valor_inicial_p . ", " . $valor_inicial_q . "
                    , " . $k_atual . ", '0')";

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
            $sql = "SELECT id, valor_inicial_p, valor_inicial_q, k FROM pesquisa.trabalhos_prob1 WHERE status=0 ORDER BY tempo_ultima_vez_requisitado LIMIT " . Configurar::$quantProxProcParaRandomizar;

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

            // Att status
            if($status == 1) { // status = processando, logo, atualiza o tempo de requisicao
                $sql = "UPDATE pesquisa.trabalhos_prob1 SET status=" . $status . ", tempo_ultima_vez_requisitado=" . time() . " WHERE id=" . $id;
            } else if($status == 3) { // Quando terminar por completo o processamento do trabalho
                // Só atualiza pra concluído se o processo foi executado no tempo correto (antes do seu vencimento)
                $time = time();
                $tempo_maximo_aux = $time - Configurar::$tempoMaximoDeProcessamento;
                $tempo_minimo_aux = $time - Configurar::$tempoMinimoDeProcessamento;
                $sql = "UPDATE pesquisa.trabalhos_prob1 SET status=" . $status . " WHERE id=" . $id . " AND tempo_ultima_vez_requisitado >= " . $tempo_maximo_aux . "AND tempo_ultima_vez_requisitado <= " $tempo_minimo_aux;
            } else {
                $sql = "UPDATE pesquisa.trabalhos_prob1 SET status=" . $status . " WHERE id=" . $id;
            }

            $resultado = $connect->query($sql);

            if($resultado == FALSE) {
                require_once 'error.php';
                $msg = "Location: ./error.php?msg=";
                $msg = $msg . "Error: Ao atualizar status [error: 293872]";
                header($msg);
            } else {
                echo "ok";
            }

            parent::dbDisconect($connect);
        }

        // Adiciona uma resposta
        public static function addResposta($p, $q, $res_calc) {

            $connect = parent::dbConnect();

            // Add resposta
            $sql = "INSERT INTO pesquisa.resultados_prob1 (p, q, resultado_calculo) VALUES (" . $p . ", " . $q . ", " . $res_calc . ")";
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
            $sql = "SELECT * FROM pesquisa.resultados_prob1";
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
            $sql = "UPDATE pesquisa.trabalhos_prob1 SET status=0 WHERE status=1 AND tempo_ultima_vez_requisitado <= " . $tempoLimiteProcessoAdormecido;
            $resultado = $connect->query($sql);

            if($resultado == FALSE) {
                require_once 'error.php';
                $msg = "Location: ./error.php?msg=";
                $msg = $msg . "Error: Ao atualizar processos adormecidos [error: 382722]";
                header($msg);
            }

            parent::dbDisconect($connect);
        }


    }

?>
