$(document).ready(function() {
  $.ajax({
    url: 'http://localhost/amt/app/models/usuarios.php', // Ruta al modelo PHP
    type: 'GET',
    dataType: 'json',
    success: function(usuarios) {
      const tbody = $('#tablaUsuarios tbody');
      tbody.empty(); // Limpiar tabla

      usuarios.forEach(usuario => {
        const fila = `
          <tr>
            <td>${usuario.id_usu}</td>
            <td>${usuario.nom_usu}</td>
            <td>${usuario.apell_usu}</td>
            <td>${usuario.correo_usu}</td>
            <td>${usuario.tipo_usu}</td>
            <td>${usuario.estado_usu == 1 ? "Activo" : "inactivo" }</td>
          <td>
              ${usuario.estado_usu == 1 
                ? `<span style="color: green;">Activo</span> 
                  <button class="btnInactivar" data-id="${usuario.id_usu}" style="margin-left: 5px; font-size: 0.8rem;">Inactivar</button>`
                : `<span style="color: red;">Inactivo</span> 
                  <button class="btnActivar" data-id="${usuario.id_usu}" style="margin-left: 5px; font-size: 0.8rem;">Activar</button>`
              }
              <button class="btnEditar" data-id="${usuario.id_usu}" style="margin-left: 5px; font-size: 0.8rem;">Editar</button>
            </td>


          </tr>
        `;
        tbody.append(fila);
      });
    },
    error: function(xhr, status, error) {
      console.error('Error al obtener usuarios:', error);
    }
  });


  document.getElementById('btnExportarExcel').addEventListener('click', function () {
  // Selecciona la tabla
  const tabla = document.getElementById('tablaUsuarios');

  // Convierte la tabla a una hoja de Excel
  const wb = XLSX.utils.table_to_book(tabla, { sheet: "Usuarios" });

  // Exporta el archivo .xlsx
  XLSX.writeFile(wb, 'usuarios.xlsx');
});

// Activar usuario
$('#tablaUsuarios').on('click', '.btnActivar', function () {
  const id = $(this).data('id');
  if (!confirm("¿Deseas activar este usuario?")) return;

  $.ajax({
    url: 'http://localhost/amt/app/models/createUser.php',  // Cambia si tu ruta varía
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
           alert('ACTIVACION erronea')
        }
      }
    },
    error: function (xhr, status, error) {
      document.getElementById("respuesta").innerText = "Error al registrar usuario.";
      console.error("Error AJAX:", error);
    }
  });

});




// Inactivar usuario
$('#tablaUsuarios').on('click', '.btnInactivar', function () {
  const id = $(this).data('id');
  if (!confirm("¿Deseas activar este usuario?")) return;

  $.ajax({
    url: 'http://localhost/amt/app/models/createUser.php',  // Cambia si tu ruta varía
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
         alert('DESACTIVACIÓN  EXITOSA')
         location.reload(); // Recarga para reflejar el cambio
          // window.location.href = 'login.php'; // Descomenta si quieres redirigir
        } else {
           alert('DESACTIVACIÓN erronea')
        }
      }
    },
    error: function (xhr, status, error) {
      document.getElementById("respuesta").innerText = "Error al desactivar usuario.";
      console.error("Error AJAX:", error);
    }
  });

});



  // Abrir modal
  document.getElementById("btnAbrirModal").addEventListener("click", () => {
    document.getElementById("modalRegistro").style.display = "flex";
  });

  // Cerrar modal
  document.getElementById("cerrarModal").addEventListener("click", () => {
    document.getElementById("modalRegistro").style.display = "none";
  });

  // Cerrar al hacer clic fuera del contenido
  window.addEventListener("click", (e) => {
    const modal = document.getElementById("modalRegistro");
    if (e.target === modal) {
      modal.style.display = "none";
    }
  });



// Editar usuario
$('#tablaUsuarios').on('click', '.btnEditar', function () {
  const id = $(this).data('id');
   $.ajax({
    url: 'http://localhost/amt/app/models/createUser.php',
    type: 'POST',
    data: { accion: 'get_by_id', id_usu: id },
    dataType: 'json',
    success: function (usuario) {
      // Llenar los campos del formulario con los datos
      $('#registroForm [name="nom_usu"]').val(usuario.nom_usu);
      $('#registroForm [name="apell_usus"]').val(usuario.apell_usu);
      $('#registroForm [name="tipoDoc_usu"]').val(usuario.tipoDoc_usu);
      $('#registroForm [name="id_usu"]').val(usuario.id_usu);
      $('#registroForm [name="correo_usu"]').val(usuario.correo_usu);
      $('#registroForm [name="tel_usu"]').val(usuario.tel_usu);
      $('#registroForm [name="tipo_usu"]').val(usuario.tipo_usu);
      $('#registroForm [name="red_social"]').val(usuario.red_social);

      // Ocultar campos de contraseña si no quieres editarlos
      $('#registroForm [name="pass_usu"]').val('');
      $('#registroForm [name="pass_usu_repeat"]').val('');

      // Actualizar campos ocultos para modo edición
      $('#accion').val('update_user');
      $('#id_original').val(usuario.id_usu);

      // Cambiar título y texto del botón
      $('#modalTitulo').text('Editar Usuario');
      $('#btnRegistroSubmit').text('Guardar Cambios');

      // Mostrar el modal
      $('#modalRegistro').fadeIn();
    },
    error: function (xhr, status, error) {
      console.error('Error al obtener el usuario:', error);
      alert('Error al cargar los datos del usuario.');
    }
  });
});

// Botón de guardar (crear o actualizar usuario)
$('#registroForm').on('submit', function (e) {
  e.preventDefault();
  alert('camilo_llamdo_metodo')
  const formData = $(this).serialize(); // ✅ Definir la variable
  $.ajax({
    url: 'http://localhost/amt/app/models/createUser.php',
    type: 'POST',
    data: formData,
    dataType: 'json',
    success: function (response) {
      if (response.success) {
        alert(response.message);
        // Cerrar y resetear el modal
        $('#modalRegistro').fadeOut();
        $('#registroForm')[0].reset();
        $('#accion').val('crear'); // Restaurar a modo crear
        $('#id_original').val('');
        $('#modalTitulo').text('Registro Nuevo Proveedor');
        $('#btnRegistroSubmit').text('Registrarse');
        // Cerrar modal
        document.getElementById("modalRegistro").style.display = "none";
        location.reload();
      } else {
        alert(response.message);
        location.reload();
      }
    },
    error: function (xhr, status, error) {
      console.error(error);
      alert('Error al enviar los datos');
    }
  });
});


});


