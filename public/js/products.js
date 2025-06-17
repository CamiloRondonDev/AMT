$(document).ready(function() {
    const productoId = new URLSearchParams(window.location.search).get('id');

    if (!productoId) {
        alert('ID del producto no especificado.');
        return;
    }

    $.ajax({
        url: '/amt/app/models/obtenerProdId.php',
        type: 'GET',
        data: { id: productoId },
        dataType: 'json',
        success: function(response) {
            if (response.error) {
                alert('Producto no encontrado');
            } else {
                $('#productName').text(response.nom_prod);
                $('#productFactory').text(response.fabrica_prod);
                $('#productDescription').text(response.desc_prod);
                $('#productAvailability').text(response.dispo_prod);
                $('#productType').text(response.tipo_prod);
                $('#productCategory').text(response.cat_prod);
                $('#productSocial').attr('href', response.red_social).attr('target', '_blank').text('Visitar perfil');
                $('#productObservations').text(response.obser_prod);
                $('#productPrice').text('$' + response.precio_prod);
                $('#sellerName').text(response.nom_usu);
                $('#sellerContact').text(response.tel_usu);
                $('#sellerEmail').text(response.correo_usu);

                // Imagen del producto
                if (response.img_prod) {
                    $('#productImage').attr('src', response.img_prod);
                } else {
                    $('#productImage').attr('src', 'default-image.jpg');
                }

                // Redirección a WhatsApp Web
                const telefonoVendedor = response.tel_usu.startsWith('57') ? response.tel_usu : '57' + response.tel_usu;
                const mensaje = encodeURIComponent(`Hola, estoy interesado en tu producto: ${response.nom_prod}`);
                const urlWhatsApp = `https://api.whatsapp.com/send?phone=${telefonoVendedor}&text=${mensaje}`;
                $('#buyButton').attr('href', urlWhatsApp).attr('target', '_blank');

            }
        },
        error: function(xhr, status, error) {
            console.error('Hubo un error en la solicitud: ', error);
        }
    });
});
