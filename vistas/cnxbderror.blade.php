{{-- Usamos la vista app como plantilla --}}
@extends('app')
{{-- Sección muestra mensaje de error de conexión a la base de datos --}}
@section('contenido')
<div class="container justify-content-center">
    Error de conexión. Inténtelo más tarde
</div>
@endsection