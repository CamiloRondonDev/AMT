$(document).ready(function() {
    // Cargar productos
    $.ajax({
        url: 'http://localhost/amt/app/models/obtenerProductos.php',
        type: 'GET',
        dataType: 'json',
        success: function(productos) {
            const tbody = $('#tablaProductos tbody');
            tbody.empty();

            productos.forEach(producto => {
                const fila = `
                    <tr>
                        <td>${producto.nom_prod}</td>
                        <td>${producto.fabrica_prod}</td>
                        <td>${producto.desc_prod}</td>
                        <td>${producto.dispo_prod}</td>
                        <td>$${producto.precio_prod}</td>
                        <td>${producto.nom_usu}</td>
                        <td style="width: 140px;">${producto.tel_usu}</td>
                    </tr>
                `;
                tbody.append(fila);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error al obtener productos:', error);
        }
    });

    // ✅ Abrir modal solo cuando se hace clic
    $('#btnAgregarProducto').click(function () {
        $('#modalAgregarProducto').fadeIn();
    });

    // Cerrar modal
    $('.cerrar').click(function () {
        $('#modalAgregarProducto').fadeOut();
    });

    // Enviar formulario
    $('#formNuevoProducto').submit(function (e) {
        e.preventDefault();

        const form = e.target;
        const data = new FormData(form);

        $.ajax({
            url: 'http://localhost/amt/app/models/createProduct.php',  // Cambia si tu ruta varía
            type: 'POST',
            data: data,
            processData: false,  // Necesario para FormData
            contentType: false,  // Necesario para FormData
            success: function (response) {
            // Verifica si es string o JSON
            if (typeof response === 'string') {
                document.getElementById("respuesta").innerText = response;
            } else {
                if (response.success) {
                //document.getElementById("respuesta").innerText = "Registro exitoso.";
                 $('#modalAgregarProducto').fadeOut(); // ✅ Cierra el modal
                // window.location.href = 'login.php'; // Descomenta si quieres redirigir
                } else {
                //document.getElementById("respuesta").innerText = "Error: " + response.message;
                alert("error al crear el producto")
                }
            }

            form.reset(); // Limpia formulario
            },
            error: function (xhr, status, error) {
            document.getElementById("respuesta").innerText = "Error al registrar usuario.";
            console.error("Error AJAX:", error);
            }
        });
    });

    // Exportar a Excel
    $('#btnExportarExcel').click(function () {
        window.location.href = '/amt/app/models/exportar_excel.php';
    });
});
