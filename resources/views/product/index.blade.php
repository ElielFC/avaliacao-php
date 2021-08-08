@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <v-product />
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12" style="margin-top: 20px">
            <a href="{{route('home')}}" class="btn btn-outline-dark">Voltar</a>
        </div>
    </div>
</div>
@endsection
