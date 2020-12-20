<div id="sidenav_dir" class="d-none d-sm-block sidenav_lados">
    <div class="list-group">

        @foreach(App\Problema::where('prioridade', '>', 0)->take(5)->get() as $problema)
            <a href="{{ route("problemas.ver", $problema->id) }}" class="list-group-item-dark list-group-item list-group-item-action">{{ $problema->nome }}</a>
        @endforeach
    </div>
</div>
