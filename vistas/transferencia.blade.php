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
                                <input type="text" class="form-control" id="dniorigen" name="dniorigen" required>
                            </div>

                            <div class="form-group">
                                <label for="cuenta_origen">Cuenta Cliente Origen</label>
                                <input type="text" class="form-control" id="cuentaorigen" name="cuentaorigen" required>
                            </div>

                            <div class="form-group">
                                <label for="dni_destino">DNI Cliente Destino</label>
                                <input type="text" class="form-control" id="dnidestino" name="dnidestino" required>
                            </div>

                            <div class="form-group">
                                <label for="cuenta_destino">Cuenta Cliente Destino</label>
                                <input type="text" class="form-control" id="cuentadestino" name="cuentadestino" required>
                            </div>

                            <div class="form-group">
                                <label for="cantidad">Cantidad (€)</label>
                                <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                            </div>

                            <div class="form-group">
                                <label for="asunto">Asunto</label>
                                <input type="text" class="form-control" id="asunto" name="asunto" required>
                            </div>

                            <button type="submit" class="btn btn-primary" name="transferencia">Realizar Transferencia</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
