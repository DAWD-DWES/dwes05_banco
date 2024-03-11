@extends('app')

@section('contenido')

<h1>Consulta de Cambio de Divisas</h1>
<form action="index.php" method="POST">
    <div class="row my-4">
        <div class="form-group col-md-4">
            <label for="divisa_origen">Divisa de Origen:</label>
            <select class="form-control" id="divisa_origen" name="divisaorigen">
                @foreach($divisas as $divisa)
                <option value="{{ $divisa->getMoneda() }}">{{ $divisa->getDescripcion() }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="divisa_destino">Divisa de Destino:</label>
            <select class="form-control" id="divisa_destino" name="divisadestino">
                @foreach($divisas as $divisa)
                <option value="{{ $divisa->getMoneda() }}">{{ $divisa->getDescripcion() }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="num_dias">Número de Días:</label>
            <input type="number" class="{{ "form-control" }} id="num_dias" placeholder="Número de días" name="numdias" step="1"
                   min="1" max="10">
        </div>
    </div>
    <button type="submit" class="btn btn-primary" name="consultadivisa">Consultar</button>
</form>
@endsection

