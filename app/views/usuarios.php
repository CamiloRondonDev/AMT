<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/amt/public/css/adm_usuarios.css">
    <title>Document</title>

</head>
<body>
    <h2>Lista de Usuarios</h2>
    <div class="acciones">
      <button id="btnExportarExcel">📥 Exportar a Excel</button>
      <button id="btnAgregarProducto">➕ Agregar Producto</button>
    </div>
<div class="tabla-scroll">
  <table id="tablaUsuarios">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Correo</th>
        <th>tipo usuario</th>
        <!-- Agrega más columnas si tu tabla tiene más campos -->
      </tr>
    </thead>
    <tbody>
      <!-- Aquí se cargan los usuarios -->
    </tbody>
  </table>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../public/js/usuarios.js"></script>
</body>
</html>