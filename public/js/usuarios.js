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
  window.location.href = `edit_user.php?id=${id}`;
});

});
