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

    // ✅ Abrir modal solo cuando se hace clic
    $('#btnAgregarProducto').click(function () {
        cargarProveedores()
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
      id_usu: id
    },
    success: function (response) {
      // Verifica si es string o JSON
      if (typeof response === 'string') {
        document.getElementById("respuesta").innerText = response;
      } else {
        if (response.success) {
         alert('ACTIVACION EXITOSA')
         location.reload(); // Recarga para reflejar el cambio
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
      id_usu: id
    },
    success: function (response) {
      // Verifica si es string o JSON
      if (typeof response === 'string') {
        document.getElementById("respuesta").innerText = response;
      } else {
        if (response.success) {
         alert('ACTIVACION EXITOSA')
         location.reload(); // Recarga para reflejar el cambio
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

});
