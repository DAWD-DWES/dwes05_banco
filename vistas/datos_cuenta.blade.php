@extends('app')

@section('contenido')

<div class=" my-3">
    <h1>Información de la Cuenta</h1>
    <p><strong>Id:</strong> {{ $cuenta->getId() }}</p>
    <p><strong>Tipo:</strong> {{ strtoupper ($cuenta->getTipo()->value) }}</p>
    <p><strong>Saldo:</strong> {{ $cuenta->getSaldo() }} €</p>
    <!-- Añade más campos de información del cliente según sea necesario -->
</div>

<div class="my-3">
    <h2>Movimientos de la cuenta</h2>
    @if(count($cuenta->getOperaciones()) > 0)
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tipo de Operacion</th>
                <th>Fecha</th>
                <th>Cantidad</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cuenta->getOperaciones() as $operacion)
            <tr>
                <td>{{ $operacion->getTipo()->value}}</td>
                <td>{{ $operacion->getFecha()->format('Y-M-d') }}</td>
                <td>{{ number_format($operacion->getCantidad(), 2) }} €</td>
                <td>{{ htmlspecialchars($operacion->getDescripcion()) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>Esta cuenta no tiene movimientos.</p>
    @endif
</div>
@endsection



