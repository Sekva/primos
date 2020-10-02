@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center text-center" style="width: 70%;">
            <div class="col-md">

                @foreach ($problemas as $problema)
                    <div class="card">
                        <div class="card-header">
                            <a class="card_link" href="{{ route('problemas.ver', $problema->id) }}">
                                {{ $problema->nome }}
                            </a>
                        </div>
                        <div class="card-body">
                            {{ json_decode($problema->descricao)[0] }}
                        </div>
                    </div>
                    <br>
                @endforeach

                <div id="paginator_controller_problemas">
                    {{ $problemas->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection
