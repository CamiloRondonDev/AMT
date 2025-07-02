<?php
session_start();

// Verificar sesión
if (!isset($_SESSION['id_usu'])) {
    header("Location: /amt/app/views/login.php");
    exit;
}

// Evitar caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");
?>
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

  <table  id="tablaProductos">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Fábrica</th>
        <th>Descripción</th>
        <th>Disponibilidad</th>
        <th>Precio</th>
        <th>Vendedor</th>
        <th>Contacto</th>
        <th>Estado</th>
        <th>Acciones</th>
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
<form id="formNuevoProducto" enctype="multipart/form-data">
      <input type="text" name="nombre_prod" placeholder="Nombre del producto" required>
      <input type="text" name="fabrica" placeholder="Fábrica" required>
      <input type="text" name="cobertura" placeholder="Covertura de venta" required>
      <input type="text" name="disponibilidad" placeholder="Disponibilidad" required>
      <input name="tipo" placeholder="Tipo de Producto" required>
      <input type="number" name="precio" placeholder="Precio" required>
      <textarea type="text" name="descripcion" placeholder="Descripción" required></textarea>
      <input type="text" name="categoria" placeholder="Categoria" required>
      <select name="proveedor" id="selectProveedores" required>
        <option value="">Seleccione un proveedor</option>
      </select>
      <input type="file" name="media[]" accept="image/*,video/*" multiple required>
        <small>Selecciona mínimo 3 imágenes o videos.</small>

      <textarea type="text" name="observacion" placeholder="Observación" required></textarea>

      <button type="submit">Guardar</button>
    </form>
  </div>
</div>
<!-- editar producto e imagenes -->

<!-- Modal para editar producto -->
<div style="display: none;" id="modalEditarProducto" class="modal">
  <div class="modal-contenido">
    <span class="cerrar-editar">&times;</span>
    <h3>Editar producto</h3>
    <form id="formEditarProducto" enctype="multipart/form-data">
      <input type="hidden" name="id_prod" id="edit_id_prod">

      <input type="text" name="nombre_prod" id="edit_nombre_prod" placeholder="Nombre del producto" required>
      <input type="text" name="fabrica" id="edit_fabrica" placeholder="Fábrica" required>
      <input type="text" name="cobertura" id="edit_cobertura" placeholder="Cobertura de venta" required>
      <input type="text" name="disponibilidad" id="edit_disponibilidad" placeholder="Disponibilidad" required>
      <input name="tipo" id="edit_tipo" placeholder="Tipo de Producto" required>
      <input type="number" name="precio" id="edit_precio" placeholder="Precio" required>
      <textarea name="descripcion" id="edit_descripcion" placeholder="Descripción" required></textarea>
      <input type="text" name="categoria" id="edit_categoria" placeholder="Categoría" required>
      <select name="proveedor" id="edit_selectProveedores" required>
        <option value="">Seleccione un proveedor</option>
      </select>

      <label>Imágenes/Vídeos actuales:</label>
      <div id="galeriaActual" class="galeria-container"></div>

      <label>Nuevas imágenes/videos (opcional):</label>
      <input type="file" name="media[]" accept="image/*,video/*" multiple>

      <textarea name="observacion" id="edit_observacion" placeholder="Observación" required></textarea>

      <button type="submit">Actualizar</button>
    </form>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../public/js/adm_productos.js"></script>

</body>
</html>
