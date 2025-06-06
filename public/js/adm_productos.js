    $(document).ready(function() {
        $.ajax({
        url: 'http://localhost/amt/app/models/obtenerProductos.php', // Ruta al archivo PHP que retorna todos los productos
        type: 'GET',
        dataType: 'json',
        success: function(productos) {
            const tbody = $('#tablaProductos tbody');
            tbody.empty(); // Limpiar tabla

            
            productos.forEach(producto => {
            const fila = `
                <tr>
                <td>${producto.nom_prod}</td>
                <td>${producto.fabrica_prod}</td>
                <td>${producto.desc_prod}</td>
                <td>${producto.dispo_prod}</td>
                <td>$${producto.precio_prod}</td>
                <td>${producto.vendedor_prod}</td>
                <td>${producto.contacto_vendedor_prod}</td>
                </tr>
            `;
            tbody.append(fila);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error al obtener productos:', error);
        }
        });
    });