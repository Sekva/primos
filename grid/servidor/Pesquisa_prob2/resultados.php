<!-- Página para listagem dos resultados dos trabalhos -->

<h2>Resultados do processamento do problema2:</h2>


<?php

    require_once "Problema2.php";
    $res_getResultados = Problema2::getResultados();
    $res_getQuantFinalizados = Problema2::getQuantProcFinalizados()->fetch_assoc()['count(id)'];
    echo "Quantidade de processos terminados: " . $res_getQuantFinalizados . "<br>";
    echo "Quantidade de resultados: " . $res_getResultados->num_rows . "<br><br>";


    if($res_getResultados->num_rows > 0) {
        echo"<style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 1px;
        }
        th, td{
            text-align: center;
        }
        </style>

        <table>
        <th>id</th>
        <th>p</th>
        <th>q</th>
        <th>p_i</th>
        <th>q_i</th>
        <th>k</th>";
        while($row = $res_getResultados->fetch_assoc()) {
            echo "<tr>
            <td>" . $row["id"] . "</td>
            <td>" . $row["primo_p"] . "</td>
            <td>" . $row["primo_q"] . "</td>
            <td>" . $row["indice_primo_p"] . "</td>
            <td>" . $row["indice_primo_q"] . "</td>
            <td>" . $row["k"] . "</td>";
        }
        echo "</table>";
    } else {
        echo "<h4>Não há processos;</h4>";
    }


 ?>
