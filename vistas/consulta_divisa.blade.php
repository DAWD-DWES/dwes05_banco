@extends('app')

@section('contenido')
    <div class="container">
        <h1>Consulta de Cambio de Divisas</h1>
        <form action="index.php" method="POST">
            <div class="form-group">
                <label for="divisa_origen">Divisa de Origen:</label>
                <select class="form-control" id="divisa_origen" name="divisa_origen">
                    <option value="USD">Dólar estadounidense (USD)</option>
                    <option value="EUR">Euro (EUR)</option>
                    <option value="GBP">Libra esterlina (GBP)</option>
                    <!-- Agrega más opciones de divisas según tu necesidad -->
                </select>
            </div>
            <div class="form-group">
                <label for="divisa_destino">Divisa de Destino:</label>
                <select class="form-control" id="divisa_destino" name="divisa_destino">
                    <option value="USD">Dólar estadounidense (USD)</option>
                    <option value="EUR">Euro (EUR)</option>
                    <option value="GBP">Libra esterlina (GBP)</option>
                    <!-- Agrega más opciones de divisas según tu necesidad -->
                </select>
            </div>
            <div class="form-group">
                <label for="num_dias">Número de Días:</label>
                <select class="form-control" id="num_dias" name="num_dias">
                    <option value="1">1 día</option>
                    <option value="2">2 días</option>
                    <option value="3">3 días</option>
                    <option value="4">4 días</option>
                    <option value="5">5 días</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Consultar</button>
        </form>
    </div>
@endsection

