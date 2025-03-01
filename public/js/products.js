$(document).ready(function() {
    const productoId = new URLSearchParams(window.location.search).get('id'); // Obtener el id desde la URL

    if (!productoId) {
        alert('ID del producto no especificado.');
        return;
    }

    $.ajax({
        url: '/amt/app/models/obtenerProdId.php', // Ajusta esta ruta a la correcta en tu servidor
        type: 'GET',
        data: { id: productoId },
        dataType: 'json',
        success: function(response) {
            if (response.error) {
                alert('Producto no encontrado');
            } else {
                // Actualizar los datos del producto en la página
                $('#productName').text(response.nom_prod);
                $('#productFactory').text(response.fabrica_prod);
                $('#productDescription').text(response.desc_prod);
                $('#productAvailability').text(response.dispo_prod);
                $('#productType').text(response.tipo_prod);
                $('#productCategory').text(response.cat_prod);
                $('#productSocial').attr('href', response.red_social_prod).text(response.red_social_prod);
                $('#productObservations').text(response.obser_prod);
                $('#productPrice').text('$' + response.precio_prod);
                $('#sellerName').text(response.vendedor_prod);
                $('#sellerContact').text(response.contacto_vendedor_prod);
                $('#sellerEmail').text(response.email_vendedor_prod);

                // Si existe una imagen del producto, se muestra
                if (response.img_prod) {
                    $('#productImage').attr('src', response.img_prod);
                } else {
                    $('#productImage').attr('src', 'default-image.jpg'); // Imagen por defecto si no hay imagen
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('Hubo un error en la solicitud: ', error);
        }
    });
});
