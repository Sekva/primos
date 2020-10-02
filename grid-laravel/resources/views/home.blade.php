@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" style="width: 70%;">
        <div class="col-md">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
