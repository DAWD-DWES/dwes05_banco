@extends('app')
@section('contenido')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        Realizar Transferencia
                    </div>
                    <div class="card-body">
                        <form method="post" action="index.php">
                            <div class="form-group">
                                <label for="dni_origen">DNI Cliente Origen</label>
                                <input type="text" class="form-control" id="dni_origen" name="dni_origen" required>
                            </div>

                            <div class="form-group">
                                <label for="cuenta_origen">Cuenta Cliente Origen</label>
                                <input type="text" class="form-control" id="cuenta_origen" name="cuenta_origen" required>
                            </div>

                            <div class="form-group">
                                <label for="dni_destino">DNI Cliente Destino</label>
                                <input type="text" class="form-control" id="dni_destino" name="dni_destino" required>
                            </div>

                            <div class="form-group">
                                <label for="cuenta_destino">Cuenta Cliente Destino</label>
                                <input type="text" class="form-control" id="cuenta_destino" name="cuenta_destino" required>
                            </div>

                            <div class="form-group">
                                <label for="cantidad">Cantidad (€)</label>
                                <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                            </div>

                            <div class="form-group">
                                <label for="asunto">Asunto</label>
                                <input type="text" class="form-control" id="asunto" name="asunto" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Realizar Transferencia</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
