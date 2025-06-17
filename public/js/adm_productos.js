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

        const datos = $(this).serialize();

        $.post('/amt/app/models/agregarProducto.php', datos, function (respuesta) {
            alert('Producto agregado correctamente');
            $('#modalAgregarProducto').fadeOut();
            location.reload();
        }).fail(function () {
            alert('Error al agregar producto');
        });
    });

    // Exportar a Excel
    $('#btnExportarExcel').click(function () {
        window.location.href = '/amt/app/models/exportar_excel.php';
    });
});
