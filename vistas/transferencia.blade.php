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
                            <label for="dniclienteorigen">DNI Cliente Origen</label>
                            <input type="text" class="form-control" id="dniclienteorigen" name="dniclienteorigen" value="{{ ($dniClienteOrigen ?? '') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="idcuentaorigen">Cuenta Cliente Origen</label>
                            <input type="text" class="form-control" id="idcuentaorigen" name="idcuentaorigen" value="{{ ($idCuentaOrigen ?? '') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="dniclientedestino">DNI Cliente Destino</label>
                            <input type="text" class="form-control" id="dniclientedestino" name="dniclientedestino" value="{{ ($dniClienteDestino ?? '') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="idcuentadestino">Cuenta Cliente Destino</label>
                            <input type="text" class="form-control" id="idcuentadestino" name="idcuentadestino" value="{{ ($idCuentaDestino ?? '') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="cantidad">Cantidad (€)</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" value="{{ ($cantidad ?? '') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="asunto">Asunto</label>
                            <input type="text" class="form-control" id="asunto" name="asunto" value="{{ ($asunto ?? '') }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary m-5" name="transferencia">Realizar Transferencia</button>
                        <div>{{ $message ?? "" }}</div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
