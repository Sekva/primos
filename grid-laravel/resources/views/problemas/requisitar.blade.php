@php
    echo "{";
    echo "\"id\": " . $trabalho->id . ",";
    echo "\"id_problema\": " . $trabalho->problema_id . ",";
    echo "\"status\": " . $trabalho->status . ",";
    echo "\"conteudo\": " . $trabalho->conteudo;
    echo "}";
@endphp
