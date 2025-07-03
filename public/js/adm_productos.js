$(document).ready(function() {
    // Cargar productos
    $.ajax({
        url: 'http://localhost/amt/app/models/obtenerProductos.php',
        type: 'GET',
        data: {accion : 'allProducts'},
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
                        <td>${producto.estado_prod == 1 ? 'ACTIVO': 'INACTIVO' }</td>
                        <td>
                            ${producto.estado_prod == 1 
                                ? `<span style="color: green;">Activo</span> 
                                <button class="btnInactivar" data-id="${producto.id_prod}" style="margin-left: 5px; font-size: 0.8rem;">Inactivar</button>`
                                : `<span style="color: red;">Inactivo</span> 
                                <button class="btnActivar" data-id="${producto.id_prod}" style="margin-left: 5px; font-size: 0.8rem;">Activar</button>`
                            }
                            <button class="btnEditar" data-id="${producto.id_prod}" style="margin-left: 5px; font-size: 0.8rem;">Editar</button>
                        </td>
                    </tr>
                `;
                tbody.append(fila);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error al obtener productos:', error);
        }
    });

    // ✅ Abrir modal solo cuando se hace clic crear
    $('#btnAgregarProducto').click(function () {
        cargarProveedores()
        $('#modalAgregarProducto').fadeIn();
        
    });

    // Cerrar modal crear
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

// ✅ Abrir modal de editar producto
$('#tablaProductos').on('click', '.btnEditar', function () {
    const id = $(this).data('id');

    // Aquí puedes cargar los datos del producto vía AJAX
$.ajax({
    url: 'http://localhost/amt/app/models/obtenerProductos.php',
    type: 'GET',
    data: { accion: 'getById', id_prod: id },
    dataType: 'json',
    success: function(producto) {
        // Rellenar el formulario con los datos
        $('#edit_id_prod').val(producto.id_prod);
        $('#edit_nombre_prod').val(producto.nom_prod);
        $('#edit_fabrica').val(producto.fabrica_prod);
        $('#edit_cobertura').val(producto.coverVenta_prod); // ← este nombre también estaba mal
        $('#edit_disponibilidad').val(producto.dispo_prod);
        $('#edit_tipo').val(producto.tipo_prod);
        $('#edit_precio').val(producto.precio_prod);
        $('#edit_descripcion').val(producto.desc_prod);
        $('#edit_categoria').val(producto.cat_prod); // ← nombre corregido
        $('#edit_observacion').val(producto.obser_prod); // ← nombre corregido

        cargarProveedoresEditar(producto.doc_proov); // ← campo correcto para proveedor

        // ✅ Cargar imágenes actuales desde producto.medios
        $('#galeriaActual').empty();
        if (Array.isArray(producto.medios)) {
            producto.medios.forEach((media, index) => {
                $('#galeriaActual').append(`
                    <div class="imagen-item">
                        <img src="${media.ruta}" width="100">
                        <button class="btnEliminarImagen" data-id="${media.id}" data-ruta="${media.ruta}">Eliminar</button>
                    </div>
                `);
            });
        }


        $('#modalEditarProducto').fadeIn();
    },
    error: function(xhr, status, error) {
        console.error('Error al cargar datos del producto', error);
        alert('Error al cargar los datos del producto.');
    }
});

});

// Eliminar imagen de la galería y del servidor
$('#galeriaActual').on('click', '.btnEliminarImagen', function (e) {
    e.preventDefault();

    const idMedia = $(this).data('id');      // id_media en BD
    const $item = $(this).closest('.imagen-item');

    if (!confirm("¿Seguro que deseas eliminar esta imagen?")) return;

    $.ajax({
        url: 'http://localhost/amt/app/models/obtenerProductos.php',
        method: 'POST',
        data: {
            accion: 'deleteMedia',
            id_media: idMedia
        },
        dataType: 'json',
        success: function (resp) {
            if (resp.success) {
                // Quitar del DOM
                $item.remove();
            } else {
                alert('Error al eliminar: ' + resp.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error AJAX al eliminar media:', error);
            alert('Error al eliminar la imagen.');
        }
    });
});


// Cerrar modal de editar producto
$('.cerrar-editar').click(function () {
    $('#modalEditarProducto').fadeOut();
});

// Cierre del modal al hacer clic fuera del contenido
$(document).on('click', function (event) {
    const $modal = $('#modalEditarProducto');
    const $contenido = $modal.find('.modal-contenido');

    // Si el modal está visible y se hace clic fuera del contenido
    if ($modal.is(':visible') && !$contenido.is(event.target) && $contenido.has(event.target).length === 0) {
        $modal.fadeOut();
    }
});

//enviar datos a actualizar producto
$('#formEditarProducto').on('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append('accion', 'updateProduct');

    $.ajax({
        url: 'http://localhost/amt/app/models/obtenerProductos.php',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (respuesta) {
            if (respuesta.success) {
                alert('Producto actualizado correctamente');
                  $('#formEditarProducto').find('input[type="file"]').val('');
                  $('#modalEditarProducto').fadeOut();
                // Recargar lista si es necesario
                // cargarProductos();
            } else {
                alert('Error: ' + (respuesta.message || 'No se pudo actualizar'));
            }
        },
        error: function (xhr, status, error) {
            console.error('Error en la solicitud:', error);
            alert('Error al actualizar el producto');
        }
    });
});


function cargarProveedoresEditar(idSeleccionado) {
    $.ajax({
        url: 'http://localhost/amt/app/models/usuarios.php',
        type: 'GET',
        dataType: 'json',
        success: function(usuarios) {
            const select = $('#edit_selectProveedores');
            select.empty().append('<option value="">Seleccione un proveedor</option>');

            usuarios.forEach(p => {
                const selected = (p.id_usu == idSeleccionado) ? 'selected' : '';
                select.append(`<option value="${p.id_usu}" ${selected}>${p.nom_usu}</option>`);
            });
        },
        error: function(xhr, status, error) {
            console.error("Error al cargar proveedores:", error);
        }
    });
}

  // Exportar a Excel
  document.getElementById('btnExportarProductos').addEventListener('click', function () {
    const tabla = document.getElementById('tablaProductos');
    const wb = XLSX.utils.table_to_book(tabla, { sheet: "Productos" });
    XLSX.writeFile(wb, 'productos.xlsx');
  });

  // Activar producto
$('#tablaProductos').on('click', '.btnActivar', function () {
  const id = $(this).data('id');
  if (!confirm("¿Deseas activar este producto?")) return;

  $.ajax({
    url: 'http://localhost/amt/app/models/obtenerProductos.php',  // Cambia si tu ruta varía
    type: 'POST',
   data: {
      accion: 'activate_edit',
      id_prod: id
    },
    success: function (response) {
      // Verifica si es string o JSON
      if (typeof response === 'string') {
        document.getElementById("respuesta").innerText = response;
      } else {
        if (response.success) {
         alert('ACTIVACION EXITOSA')
         recargarVistaAdmProductos()
        //  location.reload(); // Recarga para reflejar el cambio
          // window.location.href = 'login.php'; // Descomenta si quieres redirigir
        } else {
           alert('ACTIVACION ERRONEA' , response.success)
        }
      }
    },
    error: function (xhr, status, error) {
    //   document.getElementById("respuesta").innerText = "Error al registrar usuario.";
      console.error("Error AJAX:", error);
    }
  });

});
  // inactivar producto
$('#tablaProductos').on('click', '.btnInactivar', function () {
  const id = $(this).data('id');
  if (!confirm("¿Deseas desactivar este producto?")) return;

  $.ajax({
    url: 'http://localhost/amt/app/models/obtenerProductos.php',  // Cambia si tu ruta varía
    type: 'POST',
   data: {
      accion: 'inactivate_edit',
      id_prod: id
    },
    success: function (response) {
      // Verifica si es string o JSON
      if (typeof response === 'string') {
        document.getElementById("respuesta").innerText = response;
      } else {
        if (response.success) {
         alert('ACTIVACION EXITOSA')
         recargarVistaAdmProductos()
        //  location.reload(); // Recarga para reflejar el cambio
          // window.location.href = 'login.php'; // Descomenta si quieres redirigir
        } else {
           alert('ACTIVACION ERRONEA' , response.success)
        }
      }
    },
    error: function (xhr, status, error) {
    //   document.getElementById("respuesta").innerText = "Error al registrar usuario.";
      console.error("Error AJAX:", error);
    }
  });

});


  //obtener usuarios proveedores para el select al crear un producto
  function cargarProveedores() {
  $.ajax({
    url: 'http://localhost/amt/app/models/usuarios.php',  // Cambia si es necesario
    type: 'GET',
    dataType: 'json',
    success: function (usuarios_proveeodor) {
      const select = $('#selectProveedores');
      select.empty().append('<option value="">Seleccione un proveedor</option>');

      usuarios_proveeodor.forEach(p => {
        select.append(`<option value="${p.id_usu}">${p.nom_usu}</option>`);
      });
    },
    error: function (xhr, status, error) {
      console.error("Error al cargar usuarios_proveeodor:", error);
    }
  });
}

//validaciones carga de imagenes
document.getElementById("formNuevoProducto").addEventListener("submit", function (e) {
  const archivos = this.querySelector('input[type="file"]').files;
  if (archivos.length < 3) {
    alert("Debes seleccionar al menos 3 archivos (imágenes o videos).");
    e.preventDefault();
    return false;
  }
});


//recarga solo recargarVistaProductos
function recargarVistaAdmProductos() {
  $('#panel-content').load('/AMT/app/views/adm_productos.php');
}

});
