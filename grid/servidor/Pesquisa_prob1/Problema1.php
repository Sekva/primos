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

            $count_ps_add = 0;
            $aux_p = 0;
            $aux_q = 0;
            while($count_ps_add < $quant_ps_add) {

                // Para evitar ficar requisitando ao banco de dados
                // o ultimo processo salvo toda vez que for add um
                if($count_ps_add == 0) {

                    // Seleciona o ultimo processo adicionado
                    $sql = "SELECT *
                        FROM pesquisa.trabalhos_prob1
                        ORDER BY id DESC
                        LIMIT 1";
                    $resultado = $connect->query($sql);

                    if($resultado == FALSE) {
                        require_once 'error.php';
                        $msg = "Location: ./error.php?msg=";
                        $msg = $msg . "Error: Nenhum processo foi encontrado";
                        header($msg);
                    }

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
                        $ultimo_valor_k = $k_atual2;
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
                // ex: [p=200, q=200]
                } else if($ultimo_valor_p == $ultimo_valor_q) {
                    $valor_inicial_p = $ultimo_valor_p + $ultimo_valor_k + 1;
                    $valor_inicial_q = 0;
                // ex: [p=200, q=300]
                } else { // Isso não deveria acontecer em tese
                    echo "Erro, isso não deveria acontecer| p = " . $ultimo_valor_p . ", q = " . $ultimo_valor_q;
                    break;
                }

                $aux_p = $valor_inicial_p;
                $aux_q = $valor_inicial_q;

                // Adiciona um novo processo
                $sql = "INSERT INTO pesquisa.trabalhos_prob1
                    (status, valor_inicial_p, valor_inicial_q, k,
                    tempo_ultima_vez_requisitado)
                    VALUES (0, " . $valor_inicial_p . ", " . $valor_inicial_q . "
                    , " . $k_atual . ", '2020-01-01 00:00:00')";

                if ($connect->query($sql) === FALSE) {
                    require_once 'error.php';
                    $msg = "Location: ./error.php?msg=";
                    $msg = $msg . "Error: " . $sql . "<br>" . $connect->error;
                    header($msg);
                }

            }

            parent::dbDisconect($connect);

        }

    }

?>
