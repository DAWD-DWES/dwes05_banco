@extends('app')

@section('contenido')
<div>
    <h1>Consulta de Cambio de Divisas</h1>
    <form action="divisa.php" method="POST">
        <div class="row my-4">
            <div class="form-group col-md-3">
                <label for="divisa_origen">Divisa de Origen:</label>
                <select class="form-control" id="divisa_origen" name="divisaorigen">
                    @foreach($divisas as $divisa)
                    <option value="{{ $divisa->getMoneda() }}"  
                            {{ (isset($divisaOrigen) && $divisa->getMoneda() == $divisaOrigen) ? 'selected' : '' }}>{{ $divisa->getDescripcion() }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="divisa_destino">Divisa de Destino:</label>
                <select class="form-control" id="divisa_destino" name="divisadestino">
                    @foreach($divisas as $divisa)
                    <option value="{{ $divisa->getMoneda() }}"
                            {{ (isset($divisaDestino) && $divisa->getMoneda() == $divisaDestino) ? 'selected' : '' }}>{{ $divisa->getDescripcion() }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="fecha_inicio">Fecha Inicio:</label>
                <input type="date" class="form-control" id="fecha_inicio" placeholder="Fecha inicio" name="fechainicial" required value="{{ ($fechaInicial ?? '') }}">
            </div>
            <div class="form-group col-md-3">
                <label for="fecha_final">Fecha Final:</label>
                <input type="date" class="form-control" id="fecha_final" placeholder="Fecha Final" name="fechafinal" required value="{{ ($fechaFinal ?? '') }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary" name="consultadivisa">Consultar</button>
    </form>
    @if (isset($consultaDivisa))
    <div class="container">
        <h2 class="text-center my-4">Cambio de divisa</h2>
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Fecha</th>
                            <th scope="col">Venta</th>
                            <th scope="col">Compra</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($cambios))
                        @foreach($cambios as $cambio)
                        <tr>
                            <td>{{ $cambio->getFecha() }}</td>
                            <td>{{ $cambio->getVenta() }}</td>
                            <td>{{ $cambio->getCompra() }}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr><td>No hay datos para esas fechas</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

