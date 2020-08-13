<?php

    // É nesta página que é submetido os trabalhos (processos)
    // a serem processados. Em formato JSON, para facilitar a
    // transferência e manipulação das informações


    require_once "Problema2.php";


    header('Content-Type: application/json');

    $resposta = Problema2::getTrabalhoLivre();
    echo "[[\"ok\"],[" . $resposta["id"] . "],[" . $resposta["valor_inicial_p"] . "],[" . $resposta["quantidade"] . "],[" . $resposta["k"] . "]]";

?>
