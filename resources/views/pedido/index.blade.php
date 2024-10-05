

@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Pedido de Medicamentos</h1>
    <form action="{{ route('pedido.confirmar') }}" method="POST" class="border p-4 shadow rounded">
        @csrf
        <div class="form-group">
            <label for="medicamento">Nombre del Medicamento:</label>
            <input type="text" class="form-control" name="medicamento" required>
        </div>

        <div class="form-group">
            <label for="tipo">Tipo de Medicamento:</label>
            <select name="tipo" class="form-control" required>
                <option value="analgesico">Analgesico</option>
                <option value="analeptico">Analeptico</option>
                <option value="anestesico">Anestesico</option>
                <option value="antiacido">Antiacido</option>
                <option value="antidepresivo">Antidepresivo</option>
                <option value="antibiotico">Antibiotico</option>
            </select>
        </div>

        <div class="form-group">
            <label for="cantidad">Cantidad:</label>
            <input type="number" class="form-control" name="cantidad" min="1" required>
        </div>

        <div class="form-group">
            <label>Distribuidor:</label><br>
            @foreach($distribuidores as $distribuidor)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="distribuidor" value="{{ $distribuidor }}" required>
                    <label class="form-check-label">{{ $distribuidor }}</label>
                </div>
            @endforeach
        </div>

        <div class="form-group">
            <label>Sucursal:</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="sucursal[]" value="principal"> Principal
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="sucursal[]" value="secundaria"> Secundaria
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success">Confirmar</button>
            <button type="reset" class="btn btn-danger">Cancelar</button>
        </div>
    </form>

    <h2 class="text-center mt-5">Pedidos Realizados</h2>
    <table class="table table-striped mt-3">
        <thead class="thead-dark">
            <tr>
                <th>Medicamento</th>
                <th>Tipo</th>
                <th>Cantidad</th>
                <th>Distribuidor</th>
                <th>Sucursal</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedidos as $pedido)
            <tr>
                <td>{{ $pedido->medicamento }}</td>
                <td>{{ $pedido->tipo }}</td>
                <td>{{ $pedido->cantidad }}</td>
                <td>{{ $pedido->distribuidor }}</td>
                <td>{{ implode(', ', json_decode($pedido->sucursal)) }}</td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalActualizar{{ $pedido->id }}">
                        Actualizar
                    </button>
                    <form action="{{ route('pedido.eliminar', $pedido->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>

            
            <div class="modal fade" id="modalActualizar{{ $pedido->id }}" tabindex="-1" role="dialog" aria-labelledby="modalActualizarLabel{{ $pedido->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalActualizarLabel{{ $pedido->id }}">Actualizar Pedido</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('pedido.actualizar', $pedido->id) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="medicamento">Nombre del Medicamento:</label>
                                    <input type="text" class="form-control" name="medicamento" value="{{ $pedido->medicamento }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="tipo">Tipo de Medicamento:</label>
                                    <select name="tipo" class="form-control" required>
                                        <option value="analgesico" {{ $pedido->tipo == 'analgesico' ? 'selected' : '' }}>Analgesico</option>
                                        <option value="analeptico" {{ $pedido->tipo == 'analeptico' ? 'selected' : '' }}>Analeptico</option>
                                        <option value="anestesico" {{ $pedido->tipo == 'anestesico' ? 'selected' : '' }}>Anestesico</option>
                                        <option value="antiacido" {{ $pedido->tipo == 'antiacido' ? 'selected' : '' }}>Antiacido</option>
                                        <option value="antidepresivo" {{ $pedido->tipo == 'antidepresivo' ? 'selected' : '' }}>Antidepresivo</option>
                                        <option value="antibiotico" {{ $pedido->tipo == 'antibiotico' ? 'selected' : '' }}>Antibiotico</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="cantidad">Cantidad:</label>
                                    <input type="number" class="form-control" name="cantidad" value="{{ $pedido->cantidad }}" min="1" required>
                                </div>
                                <div class="form-group">
                                    <label>Distribuidor:</label><br>
                                    @foreach($distribuidores as $distribuidor)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="distribuidor" value="{{ $distribuidor }}" {{ $pedido->distribuidor == $distribuidor ? 'checked' : '' }} required>
                                            <label class="form-check-label">{{ $distribuidor }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <label>Sucursal:</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="sucursal[]" value="principal" {{ in_array('principal', json_decode($pedido->sucursal)) ? 'checked' : '' }}> Principal
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="sucursal[]" value="secundaria" {{ in_array('secundaria', json_decode($pedido->sucursal)) ? 'checked' : '' }}> Secundaria
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-warning">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
