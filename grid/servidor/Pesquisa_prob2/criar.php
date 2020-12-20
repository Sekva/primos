<?php

    // Simples método de criação de novos processos.
    // A forma que está feita é apenas para demonstração
    // de como o projeto poderá funcionar. Essa parte
    // estaria restrita apenas ao administrador do sistema


    if (isset($_POST["criar"]) && $_POST["criar"] && $_POST["criar"] == "sim") {
        require_once 'Problema2.php';
        // quantidade de trabalhos para criar
        // intervalo de busca
        // k (espaço para verificar se é primo [3+(k=2)=5])
        Problema2::criar(30, 5000, 2);
        echo "Novo objeto criado!<br>";
    }

?>


<form action = "<?php $_PHP_SELF ?>" method = "POST" onsubmit="return confirm('Tem certeza que deseja adicionar novos trabalhos? Esse processo pode ser demorado...');">
    <input type = "text" name = "criar" value="sim" hidden/>
    <input type = "submit" class="enviar" value="Enviar" />
</form>
