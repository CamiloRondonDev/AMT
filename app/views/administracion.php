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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Meta tags para evitar caché -->
  <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate" />
  <meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="Expires" content="0" />

  <link rel="stylesheet" href="/amt/public/css/administracion.css">
  <link rel="icon" href="/amt/public/img/IDENTIFICADOR SIN TEXTO-08.png" type="image/png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <title>Panel de Administración</title>
</head>
<body>
<a href="/amt/app/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>

<!-- Sidebar -->
<nav id="sidebar">
  <ul>
    <?php if ($_SESSION['rol'] === 'admin'): ?>
      <li><a class="links" href="#" data-url="/AMT/app/views/usuarios.php">USUARIOS</a></li>
    <?php endif; ?>
    <li><a class="links" href="#" data-url="/AMT/app/views/adm_productos.php">PRODUCTOS</a></li>
  </ul>
</nav>


<!-- Header -->
<header>
  <div class="header-left">
    <img src="/amt/public/img/para banner.jpg" alt="Logo" style="height: 45px;">
    <div id="btnToggleSidebar">&#9776;</div>
  </div>
  <div class="header-center">
    Panel de Administración
  </div>
  <div class="header-right">
    <div class="fas fa-gear" id="btnSettings" title="Cambiar contraseña"></div>
    <div style="margin-left: 15px; visibility: hidden;" class="fas fa-sign-out-alt" id="btnClose" title="Cerrar Sesión"></div>
    <a style="text-decoration: none; color: white;" href="/amt/app/logout.php">Cerrar sesión</a>
  </div>
</header>

<!-- Contenido principal -->
<main id="content">
  <div id="panel-content">
    <h1>Bienvenido al panel de administración</h1>
    <p>Selecciona una opción del menú.</p>
  </div>
</main>

<!-- Modal cambiar contraseña -->
<div id="modalChangePass">
  <div class="modal-content">
    <h2>Cambiar Contraseña</h2>
    <form id="formChangePass">
      <label for="currentPass">Contraseña actual:</label>
      <input type="password" id="currentPass" name="currentPass" required />
      <label for="newPass">Nueva contraseña:</label>
      <input type="password" id="newPass" name="newPass" required />
      <label for="confirmPass">Confirmar nueva contraseña:</label>
      <input type="password" id="confirmPass" name="confirmPass" required />
      <button type="submit">Guardar</button>
      <button type="button" id="closeModal" style="margin-top:10px; background:#ccc;">Cancelar</button>
    </form>
  </div>
  <div id="respuestaCambioPass" style="margin-top:10px; color:red;"></div>

</div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="/amt/public/js/administracion.js"></script>
</body>
</html>
