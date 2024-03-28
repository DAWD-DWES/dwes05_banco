@extends('app')

@section('contenido')
<div>
    <h1>Consulta de Hipoteca</h1>
    <form action="hipoteca.php" method="POST">
        <div class="row my-4">
            <div class="form-group col-md-4">
                <label for="cantidad">Cantidad:</label>
                <input type="number" class="form-control" id="cantidad" placeholder="Cantidad" name="cantidad" required value="{{ ($cantidad ?? '') }}"
                       step="1000" min="0" max="10000000">
            </div>
            <div class="form-group col-md-4">
                <label for="anyos">Años:</label>
                <input type="number" class="form-control" id="anyos" placeholder="Años" name="anyos" required value="{{ ($anyos ?? '') }}"
                       step="1" min="10" max="30">
            </div>
            <div class="form-group col-md-4">
                <label for="tasainteres">Tasa de Interés:</label>
                <input type="number" class="form-control" id="tasainteres" placeholder="Tasa Interés" name="tasainteres" required value="{{ ($tasaInteres ?? '') }}"
                       step="0.01" min="0" max="10">
            </div>
        </div>
        <button type="submit" class="btn btn-primary" name="consultacuota">Consultar</button>
    </form>
    @if (isset($consultaCuota))
    <div class="container">
        <h2 class="text-center my-4">Cuota Mensual de la Hipoteca</h2>
        <div class="row">
            <div class="col-3">
                <label for="cuota">Cuota Mensual:</label>
                <input type="number" class="form-control" id="cuota" readonly value="{{ $cuota }}">
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

