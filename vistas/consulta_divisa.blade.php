@extends('app')

@section('contenido')
<div>
    <h1>Consulta de Cambio de Divisas</h1>
    <form action="index.php" method="POST">
        <div class="row my-4">
            <div class="form-group col-md-3">
                <label for="divisa_origen">Divisa de Origen:</label>
                <select class="form-control" id="divisa_origen" name="divisaorigen">
                    @foreach($divisas as $divisa)
                    <option value="{{ $divisa->getMoneda() }}">{{ $divisa->getDescripcion() }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="divisa_destino">Divisa de Destino:</label>
                <select class="form-control" id="divisa_destino" name="divisadestino">
                    @foreach($divisas as $divisa)
                    <option value="{{ $divisa->getMoneda() }}">{{ $divisa->getDescripcion() }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="fecha_inicio">Fecha Inicio:</label>
                <input type="date" class="form-control" id="fecha_inicio" placeholder="Fecha inicio" name="fechainicial">
            </div>
            <div class="form-group col-md-3">
                <label for="fecha_final">Fecha Final:</label>
                <input type="date" class="form-control" id="fecha_final" placeholder="Fecha Final" name="fechafinal">
            </div>
        </div>
        <button type="submit" class="btn btn-primary" name="consultadivisa">Consultar</button>
    </form>
</div>
@endsection

