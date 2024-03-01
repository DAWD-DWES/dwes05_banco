@extends('app')

@section('contenido')
@parent

    <div class=" my-3">
        <h1>Información de la Cuneta</h1>
        <p><strong>Id:</strong> {{ $cuenta->getId() }}</p>
        <p><strong>Tipo:</strong> {{ $cuenta->getTipo()->value }}</p>
        <!-- Añade más campos de información del cliente según sea necesario -->
    </div>

    <div class="my-3">
        <h2>Movimientos de la cuenta</h2>
        @if(count($operaciones) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tipo de Operacion</th>
                        <th>Número de Cuenta</th>
                        <th>Fecha</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($operaciones as $operacion)
                        <tr>
                            <td>{{ $operacion->getTipo()->value}}</td>
                            <td>{{ $cuenta->numero }}</td>
                            <td>${{ number_format($cuenta->saldo, 2) }}</td>
                            <td><a href="{{ url('/cuentas/detalle/' . $cuenta->id) }}" class="btn btn-primary btn-sm">Ver Movimientos</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Este cliente no tiene cuentas registradas.</p>
        @endif
    </div>
@endsection



