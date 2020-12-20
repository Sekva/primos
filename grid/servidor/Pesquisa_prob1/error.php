<?php

    // Apenas uma área para mostrar as mensagens de erro.


    if (isset($_GET['msg']) && $_GET['msg'] != "") {
        echo "<h3>" . $_GET['msg'] . "</h3>";
    } else {
        echo "Sem msg de erro";
    }
    echo "<br>";

?>

<button type="button" onclick="history.back();">Voltar</button>
