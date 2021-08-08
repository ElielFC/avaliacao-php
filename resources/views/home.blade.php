@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{route('product-categories')}}" class="btn btn-outline-primary">Categorias de Produtos</a>
                    <a href="{{route('product')}}" class="btn btn-outline-secondary">Cadastro de Produtos</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
