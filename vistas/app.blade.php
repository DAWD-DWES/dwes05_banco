<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Banco  Mid@s</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    </head>
    <body class="d-flex flex-column vh-100">

        <!-- Cabecera con barra de navegación -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <img src="img/clover-7876940_1280.png" alt="Icono Banco" style="height: 30px;">
                    Banco Mid@s</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Clientes y Cuentas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?pettransferencia">Transferencias</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="divisa.php?petconsultadivisa">Consulta Cambio Divisa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="hipoteca.php?petconsultahipoteca">Hipoteca</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="flex-fill">
            <!-- Área de contenido central -->
            <div class="container mt-4">
                @section('contenido')  
                @component('componentes.buscador', ['actionUrl' => '/index.php', 'placeholder' => 'Buscar por DNI de Cliente', 'fieldName' => 'dnicliente', 'info' => 'infocliente'])
                @endcomponent
                @component('componentes.buscador', ['actionUrl' => '/index.php', 'placeholder' => 'Buscar por Id de Cuenta', 'fieldName' => 'idcuenta', 'info' => 'infocuenta'])
                @endcomponent
                @show
            </div>
        </main>
        @include('parciales.piepagina')
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        @stack('scripts')
    </body>
</html>

