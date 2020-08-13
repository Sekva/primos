<!-- Página para listagem dos resultados dos trabalhos -->

<h2>Resultados do processamento do problema2:</h2>


<?php

    require_once "Problema2.php";
    $res_getResultados = Problema2::getResultados();
    $res_getQuantFinalizados = Problema2::getQuantProcFinalizados()->fetch_assoc()['count(id)'];
    echo "Quantidade de processos terminados: " . $res_getQuantFinalizados . "<br>";
    echo "Quantidade de resultados: " . $res_getResultados->num_rows . "<br><br>";

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
        <th>Resultado</th>";

    if($res_getResultados->num_rows > 0) {
        while($row = $res_getResultados->fetch_assoc()) {
            echo "<tr>
            <td>" . $row["id"] . "</td>
            <td>" . $row["p"] . "</td>
            <td>" . $row["q"] . "</td>
            <td>" . $row["resultado_calculo"] . "</td>";
        }
        echo "</table>";
    } else {
        echo "<h4>Não há processos;</h4>";
    }


 ?>
