$(document).ready(function () {
    console.log("entro1")
    $.ajax({
        url: "http://localhost/amt/app/models/obtenerProductos.php", // Ruta al PHP
        method: "GET",
        dataType: "json",
        success: function (data) {
            let container = $("#productos-container");
            container.empty(); // Limpiar antes de agregar productos

            if (data.length > 0) {
                data.forEach(producto => {
                    let card = `
                  <div class="product-card">
                     <img class="product-image" src="${producto.img_prod}" alt="${producto.fabrica_prod}">
                     <div class="product-info">
                        <h3>${producto.nom_prod}</h3>
                         <p>${producto.desc_prod}</p>
                         <p class="price">$${producto.precio_prod}</p>
                         <a href="products.php?id=${producto.id_prod}" class="button">Ver Producto</a>
                      </div>
                    </div>
                    `;
                    container.append(card);
                });
            } else {
                container.html("<p>No hay productos disponibles.</p>");
            }
        },
        error: function (error) {
            console.error("Error al obtener productos:", error);
            $("#productos-container").html("<p>Error al cargar productos.</p>");
        }
    });
});
