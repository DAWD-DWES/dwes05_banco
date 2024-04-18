$(document).ready(function () {
    $('form').on('submit', function (e) {
        e.preventDefault();  // Previene el envío normal del formulario

        // Recoge los datos del formulario
        var data = $(this).serialize();
        data += '&consultacuota=' + encodeURIComponent($('button[name="consultacuota"]').val());

        // Realiza la petición AJAX
        $.ajax({
            type: 'POST',
            url: 'hipoteca.php', // Asegúrate de que la URL es correcta
            data: data,
            dataType: 'json',
            success: function (response) {
                if (response.error) {
                    alert('Error: ' + response.error);
                } else {
                    
                    $('#cuota').val(response.cuota);  // Actualiza el campo de cuota mensual
                    $('#seccioncuota').removeClass('d-none');
                }
            },
            error: function () {
                alert('Error en la solicitud.');
            }
        });
    });
});



