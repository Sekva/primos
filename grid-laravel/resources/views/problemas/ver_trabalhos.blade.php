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

<h1>Ver Trabalhos do prob_{{$problema->id}}</h1>
<h3>Quantidade de Trabalhos: {{$trabalhos->count()}}</h3>
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
