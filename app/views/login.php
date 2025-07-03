<?php require_once 'header.php'; ?>
<link rel="stylesheet" href="/amt/public/css/login.css?v=3">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<main class="login-pagina">
  <div class="login-fondo">
    <div class="login-container">
    <form id="formLogin" class="login-form" action="#" method="POST">
   <div class="login-header">
  <img src="/amt/public/img/VECTORIZADO VERTICAL.png" alt="Logo" class="login-logo">
  <h2 class="login-titulo">Iniciar sesión</h2>
</div>

<div class="input-group">
  <i class="fas fa-user"></i>
  <input type="text" id="username" name="username" placeholder="Usuario" required>
</div>

<div class="input-group">
  <i class="fas fa-lock"></i>
  <input type="password" id="password" name="password" placeholder="Contraseña" required>
</div>

        <button type="submit" class="btn-fancy-login">Iniciar sesión</button>
                
        <div class="login-options">
            <a href="create_user.php" class="btn-create-account">Crear cuenta nueva</a>
            <a href="contacto.php" class="btn-recover-password">¿Olvidaste tu contraseña?</a>
        </div>
    </form>

</div>

  </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../public/js/login.js"></script>
<?php require_once 'footer.php'; ?>
