<?php

    // Arquivo para receber submissões realizadas pelo
    // programa do cliente. Aqui será feita a recepção
    // dos dados, onde será passado para o núcleo
    // daquele projeto, e essas informações serão utilizadas.


    require_once 'Problema2.php';
    // require_once 'User.php';


    if (isset($_POST["atualizarStatus"])){
        if (isset($_POST["id"]) && $_POST["id"] && is_numeric($_POST["id"]) && $_POST["id"] > 0 ){
            $id = $_POST["id"];

            // TODO: Verificar tipo de dado recebido
            $status = intval($_POST["status"]);


            require_once "Problema2.php";
            // Atualiza status
            Problema2::attStatusProcesso($id, $status);

            // Se achou uma solução
            $resposta = $_POST["resposta"];
            if($resposta == 'true') {
                $p = $_POST["p"];
                $q = $_POST["q"];
                $k = $_POST["k"];
                Problema2::addResposta($p, $q, $k);
            }

        } else {
            require_once 'error.php';
            $msg = "Location: ./error.php?msg=";
            $msg = $msg . "Erro ao atualizar o status do processo! ERROR:[793877]";
            header($msg);
        }

    } else {
        require_once 'error.php';
        $msg = "Location: ./error.php?msg=";
        $msg = $msg . "Erro ao enviar dados ao servidor: opção não citada! ERROR:[763247]";
        header($msg);
    }


?>
