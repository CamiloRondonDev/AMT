<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/amt/public/css/adm_productos.css">
  <title>Lista de Productos</title>
</head>
<body>

  <h2>Todos los productos</h2>

  <div class="acciones">
    <button id="btnExportarExcel">📥 Exportar a Excel</button>
    <button id="btnAgregarProducto">➕ Agregar Producto</button>
  </div>

</div>

  <table id="tablaProductos">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Fábrica</th>
        <th>Descripción</th>
        <th>Disponibilidad</th>
        <th>Precio</th>
        <th>Vendedor</th>
        <th>Contacto</th>
      </tr>
    </thead>
    <tbody>
      <!-- Aquí se cargan los productos -->
    </tbody>
  </table>


<!-- Modal para agregar producto -->
<div style="display: none;" id="modalAgregarProducto" class="modal">
  <div class="modal-contenido">
    <span class="cerrar">&times;</span>
    <h3>Agregar nuevo producto</h3>
    <form id="formNuevoProducto">
      <input type="text" name="nombre" placeholder="Nombre del producto" required>
      <input type="text" name="fabrica" placeholder="Fábrica" required>
      <textarea name="descripcion" placeholder="Descripción" required></textarea>
      <input type="number" name="precio" placeholder="Precio" required>
      <input type="text" name="disponibilidad" placeholder="Disponibilidad" required>
      <button type="submit">Guardar</button>
    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../public/js/adm_productos.js"></script>

</body>
</html>
