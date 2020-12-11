<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
}
th {
  text-align: left;
}
</style>

<h1>Trabalhos do Problema: {{$problema->nome}}</h1>
<h3>Quantidade Total de Trabalhos: {{$quant_trabalhos_total}}</h3>
<h3>Quantidade de Trabalhos Processados: {{$quant_trabalhos_processados}}</h3>

@php
    // Verifica se o parâmetro da páginação existe na url
    // Se não existir, ele redireciona para a primeira página
    if( !array_key_exists("page", $_GET) || !$_GET["page"] || !isset($_GET["page"]) ) {
        $num_pag_atual = 0;
    } else {
        $num_pag_atual = $_GET["page"];
    }
@endphp

<p>Página atual: {{ $num_pag_atual }}</p>
@if (is_numeric($num_pag_atual))
    @if (intval($num_pag_atual) > 0)
        <a href={{ '?page=' . strval($num_pag_atual - 1) }}>pag {{ $num_pag_atual - 1}}</a>
    @endif
    <a href={{ '?page=' . strval($num_pag_atual + 1) }}>pag {{ $num_pag_atual + 1}}</a>
@endif

<p>Máximo de {{ $numero_tralhos_por_pagina }} Trabalhos por página</p>
<table>
    <tr>
        <th>id</th>
        <th>status</th>
        <th>p</th>
        <th>q</th>
        <th>k</th>
    </tr>
@foreach($trabalhos as $t)
    @php
    $cont = json_decode($t->conteudo, true)
    @endphp
    <tr>
        <td> {{$t->id}} </td>
        <td> {{$t->status}} </td>
        <td> {{$cont['p']}} </td>
        <td> {{$cont['q']}} </td>
        <td> {{$cont['k']}} </td>
    </tr>
@endforeach
</table>
