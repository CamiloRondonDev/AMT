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
    <button id="btnExportarProductos">📥 Exportar a Excel</button>
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
      <input type="text" name="nombre_prod" placeholder="Nombre del producto" required>
      <input type="text" name="fabrica" placeholder="Fábrica" required>
      <input type="text" name="cobertura" placeholder="Covertura de venta" required>
      <input type="text" name="disponibilidad" placeholder="Disponibilidad" required>
      <input name="tipo" placeholder="Tipo de Producto" required>
      <input type="number" name="precio" placeholder="Precio" required>
      <textarea type="text" name="descripcion" placeholder="Descripción" required></textarea>
      <input type="text" name="categoria" placeholder="Categoria" required>
      <input type="text" name="proveedor" placeholder="Proveedor" required>
      <input type="text" name="img" placeholder="imagen" required>
      <textarea type="text" name="observacion" placeholder="Observación" required></textarea>

      <button type="submit">Guardar</button>
    </form>
  </div>
</div>
  
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../public/js/adm_productos.js"></script>

</body>
</html>
