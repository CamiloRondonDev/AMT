$(document).ready(function () {
    $('#formLogin').on('submit', function (e) {
        e.preventDefault(); // Evita recargar la página

        const datos = {
            //username: $('#username').val(),
            //password: $('#password').val()
            username: 'camiloanla@gmail.com',
            password: 'camilo123*'
        };

        $.ajax({
            url: 'http://localhost/amt/app/models/login.php',
            type: 'POST',
            data: datos,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // Redirige o muestra mensaje
                    window.location.href = 'administracion.php';
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function () {
                alert('Hubo un error al conectar con el servidor.');
            }
        });
    });
});
