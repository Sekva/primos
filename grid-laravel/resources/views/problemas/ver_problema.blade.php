<h1>Infos sobre o problema: {{$problema->nome}}</h1>

<a href={{route('problemas.trabalhos.ver', $problema->id)}}>Ver Trabalhos deste problema</a>
<a href={{route('problemas.trabalhos.criar', $problema->id)}}>Criar</a>
<a href={{route('api.requisitar', $problema->id)}}>Requisitar</a>

<p>{{var_dump($problema)}}</p>
