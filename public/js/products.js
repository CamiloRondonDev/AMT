$(document).ready(function () {
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
        success: function (response) {
            if (response.error) {
                alert('Producto no encontrado');
                return;
            }

            // Datos principales
            $('#productName').text(response.nom_prod);
            $('#productFactory').text(response.fabrica_prod);
            $('#productDescription').text(response.desc_prod);
            $('#productAvailability').text(response.dispo_prod);
            $('#productType').text(response.tipo_prod);
            $('#productCategory').text(response.cat_prod);
            $('#productSocial').attr('href', response.red_social).attr('target', '_blank').text('Visitar perfil');
            $('#productObservations').text(response.obser_prod);

            const precio = Number(response.precio_prod);
            const formatoCOP = new Intl.NumberFormat('es-CO', {
                style: 'currency',
                currency: 'COP'
            });
            $('#productPrice').text(formatoCOP.format(precio));
            $('#sellerName').text(response.nom_usu);
            $('#sellerContact').text(response.tel_usu);
            $('#sellerEmail').text(response.correo_usu);

            // Mostrar todas las imágenes
            const galeria = $('#mediaGallery');
            galeria.empty();

            if (Array.isArray(response.medios)) {
                const soloImagenes = response.medios.filter(m => m.tipo === 'imagen');

                if (soloImagenes.length > 0) {
                    soloImagenes.forEach(imagen => {
                        galeria.append(`<img src="${imagen.ruta}" alt="imagen producto" style="width:120px; margin:5px; border-radius:8px;">`);
                    });
                } else {
                    galeria.append('<p>No hay imágenes disponibles.</p>');
                }
            } else {
                galeria.append('<p>Sin galería disponible.</p>');
            }

            // WhatsApp
            const telefonoVendedor = response.tel_usu.startsWith('57') ? response.tel_usu : '57' + response.tel_usu;
            const mensaje = encodeURIComponent(`Hola, estoy interesado en tu producto: ${response.nom_prod}`);
            const urlWhatsApp = `https://api.whatsapp.com/send?phone=${telefonoVendedor}&text=${mensaje}`;
            $('#buyButton').attr('href', urlWhatsApp).attr('target', '_blank');
        },
        error: function (xhr, status, error) {
            console.error('Hubo un error en la solicitud: ', error);
        }
    });
});
