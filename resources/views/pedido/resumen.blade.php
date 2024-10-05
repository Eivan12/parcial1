

@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Pedido Confirmado</h1>
    <div class="card border-success mt-4">
        <div class="card-header bg-success text-white">
            <h4>Distribuidor: {{ $distribuidor }}</h4>
        </div>
        <div class="card-body">
            <p class="card-text">{{ $cantidad }} unidades del tipo {{ $tipo }} {{ $medicamento }}</p>
            <p class="card-text">Para la sucursal situada en: 
                @foreach($direccion as $dir)
                    <br>{{ $dir }}
                @endforeach
            </p>
        </div>
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('pedido.index') }}" class="btn btn-primary">Realizar otro pedido</a>
    </div>
</div>
@endsection


