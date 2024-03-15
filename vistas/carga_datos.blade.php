@extends('app')
@section('encabezado', "Carga Datos")
@section('contenido')
<form name="Crea Datos" action="index.php" method="POST">
    <div class="text-center">
        <button class="btn btn-secondary"  name="creardatos"><i class="fa fa-database p-2" aria-hidden="true"></i>Instalar Datos de Ejemplo</button>
    </div>
</form>

@endsection
