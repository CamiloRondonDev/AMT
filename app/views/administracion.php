<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="/amt/public/css/administracion.css">
  <link rel="icon" href="/amt/public/img/IDENTIFICADOR SIN TEXTO-08.png" type="image/png">
  <title>Panel de Administración</title>
</head>
<body>

<!-- Sidebar -->
<nav id="sidebar">
  <ul>
    <li><a class="links" href="#" data-url="/AMT/app/views/usuarios.php">USUARIOS</a></li>
    <li><a class="links" href="#" data-url="/AMT/app/views/adm_productos.php">PRODUCTOS</a></li>
    <li><a class="links" href="#" data-url="/AMT/views/informes.php">INFORMES</a></li>
    <li><a class="links" href="#" data-url="/AMT/views/parametros.php">PARAMETROS</a></li>
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
    <div id="btnSettings" title="Cambiar contraseña">&#9881;</div>
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
</div>
  <script src="../../public/js/administracion.js"></script>
</body>
</html>
