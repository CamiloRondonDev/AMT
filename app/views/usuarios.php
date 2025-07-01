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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/amt/public/css/adm_usuarios.css">
    <link rel="stylesheet" href="/amt/public/css/create_user.css">
    <title>Document</title>

</head>
<body>
    <h2>Lista de Usuarios</h2>
    <div class="acciones">
      <button id="btnExportarExcel">📥 Exportar a Excel</button>
      <button id="btnAbrirModal" style="background-color: green; color: white;">➕ Agregar Nuevo Usuario</button>
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
        <th>Estado</th>
        <th>Acciones</th>
        <!-- Agrega más columnas si tu tabla tiene más campos -->
      </tr>
    </thead>
    <tbody>
      <!-- Aquí se cargan los usuarios -->
    </tbody>
  </table>
</div>

<!-- Modal oculto -->
<!-- Modal oculto -->
<div id="modalRegistro" class="modal" style="display: none;">
  <div class="modal-contenido">
    <span class="cerrar" id="cerrarModal">&times;</span>
    <h2 id="modalTitulo">Registro Nuevo Proveedor</h2>

    <form id="registroForm">
      <div class="form-grid">
        <input type="text" name="nom_usu" placeholder="Nombre" required>
        <input type="text" name="apell_usus" placeholder="Apellido" required>

        <select name="tipoDoc_usu" required>
          <option value="">Tipo de documento</option>
          <option value="CC">C.C.</option>
          <option value="NIT">NIT</option>
        </select>

        <input type="text" name="id_usu" placeholder="Documento" required>
        <input type="email" name="correo_usu" placeholder="Correo" required>
        <input type="number" name="tel_usu" placeholder="Teléfono" required>
             
        <select name="tipo_usu" required>
          <option value="">Tipo de usuario</option>
          <option value="admin">Admin</option>
          <option value="proveedor">Proveedor</option>
        </select>

        <input type="text" name="red_social" placeholder="Red Social" required>
        <input type="password" name="pass_usu" placeholder="Contraseña" required>
        <input type="password" name="pass_usu_repeat" placeholder="Repita Contraseña" required>
      </div>

      <!-- Campos ocultos para acción y edición -->
      <input type="hidden" name="accion" id="accion" value="crear">
      <input type="hidden" name="id_original" id="id_original">

      <button type="submit" id="btnRegistroSubmit">Registrarse</button>
    </form>

    <div id="respuesta"></div>
  </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../public/js/usuarios.js"></script>
<!-- <script src="/amt/public/js/create_user.js"></script> -->
</body>
</html>