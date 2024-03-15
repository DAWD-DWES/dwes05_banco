@extends('app')

@section('contenido')
@parent
<div class="my-3">
    <h1>Información del Cliente</h1>
    <p><strong>Nombre:</strong> {{ $cliente->getNombre() .  " " . $cliente->getApellido1() . " " . $cliente->getApellido2() }}</p>
    <p><strong>DNI:</strong> {{ $cliente->getDni() }}</p>
    <p><strong>Teléfono:</strong> {{ $cliente->getTelefono() }}</p>
    <!-- Añade más campos de información del cliente según sea necesario -->
</div>
<div class="cuentas-lista my-3">
    <h2>Cuentas del Cliente</h2>
    @if(count($cuentas) > 0)
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tipo de Cuenta</th>
                <th>Número de Cuenta</th>
                <th>Saldo Actual</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cuentas as $cuenta)
            <tr>
                <td>{{ $cuenta->getTipo()->value }}</td>
                <td>{{ $cuenta->getId() }}</td>
                <td>{{ number_format($cuenta->getSaldo(), 2) }} €</td>
                <td><a href="{{ 'index.php?movimientos&idCuenta=' . $cuenta->getId() }}" class="btn btn-primary btn-sm">Ver Movimientos</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>Este cliente no tiene cuentas registradas.</p>
    @endif
</div>
@endsection
