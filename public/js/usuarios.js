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

});
