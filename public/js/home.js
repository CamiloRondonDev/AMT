$(document).ready(function () {
    let paginaActual = 1;
    const productosPorPagina = 20;

    function cargarProductos(pagina = 1) {
        $.ajax({
            url: `http://localhost/amt/app/models/obtenerProductos.php?pagina=${pagina}`,
            method: "GET",
            dataType: "json",
            success: function (data) {
                let container = $("#productos-container");
                container.empty();

                if (data.productos && data.productos.length > 0) {
                    const formatoCOP = new Intl.NumberFormat('es-CO', {
                        style: 'currency',
                        currency: 'COP'
                    });

                    data.productos.forEach(producto => {
                        let precioFormateado = formatoCOP.format(Number(producto.precio_prod));
                        let card = `
                            <div class="product-card">
                                <img class="product-image" src="${producto.img_prod}" alt="${producto.fabrica_prod}">
                                <div class="product-info">
                                    <h3>${producto.nom_prod}</h3>
                                    <p>${producto.desc_prod}</p>
                                    <p class="price">${precioFormateado}</p>
                                    <a href="products.php?id=${producto.id_prod}" class="button">Ver Producto</a>
                                </div>
                            </div>`;
                        container.append(card);
                    });

                    renderizarPaginacion(data.totalPaginas, pagina);
                } else {
                    container.html("<p>No hay productos disponibles.</p>");
                }
            },
            error: function (error) {
                console.error("Error al obtener productos:", error);
                $("#productos-container").html("<p>Error al cargar productos.</p>");
            }
        });
    }

   function renderizarPaginacion(totalPaginas, paginaActual) {
    const paginacionContainer = $("#paginacion");
    paginacionContainer.empty();

    const crearBoton = (texto, pagina, disabled = false, active = false) => {
        let btn = $(`<button class="pagina-btn">${texto}</button>`);
        if (active) btn.addClass("active");
        if (disabled) btn.prop("disabled", true);
        else btn.click(() => cargarProductos(pagina));
        return btn;
    };

    // Botón anterior
    if (paginaActual > 1) {
        paginacionContainer.append(crearBoton("<", paginaActual - 1));
    }

    // Siempre mostrar página 1
    paginacionContainer.append(crearBoton(1, 1, false, paginaActual === 1));

    // Elipsis después de la 1 si estamos lejos de ella
    if (paginaActual > 3) {
        paginacionContainer.append($("<span class='ellipsis'>...</span>"));
    }

    // Mostrar páginas cercanas al actual
    for (let i = paginaActual - 1; i <= paginaActual + 1; i++) {
        if (i > 1 && i < totalPaginas) {
            paginacionContainer.append(crearBoton(i, i, false, i === paginaActual));
        }
    }

    // Elipsis antes de la última
    if (paginaActual < totalPaginas - 2) {
        paginacionContainer.append($("<span class='ellipsis'>...</span>"));
    }

    // Siempre mostrar última página (si no es la misma que la primera)
    if (totalPaginas > 1) {
        paginacionContainer.append(crearBoton(totalPaginas, totalPaginas, false, paginaActual === totalPaginas));
    }

    // Botón siguiente
    if (paginaActual < totalPaginas) {
        paginacionContainer.append(crearBoton(">", paginaActual + 1));
    }
}


    // Agregar el contenedor de paginación si no existe
    if ($("#paginacion").length === 0) {
        $("#productos-container").after('<div id="paginacion" class="pagination"></div>');
    }

    cargarProductos(paginaActual);
});
