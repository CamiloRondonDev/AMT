<?php require_once 'header.php'; ?>
<link rel="stylesheet" href="/amt/public/css/login.css">

<!-- Contenedor del Login -->
<div class="login-container">
<form id="formLogin" class="login-form" action="#" method="POST">
    <h2>Iniciar sesión</h2>
    <div class="input-group">
        <label for="username">Usuario</label>
        <input type="text" id="username" name="username" placeholder="Introduce tu usuario" required>
    </div>
    <div class="input-group">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Introduce tu contraseña" required>
    </div>
    <button type="submit" class="btn-login">Iniciar sesión</button>
    
    <div class="login-options">
        <a href="registerUser.html" class="btn-create-account">Crear cuenta nueva</a>
        <a href="#" class="btn-recover-password">¿Olvidaste tu contraseña?</a>
    </div>
</form>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../public/js/login.js"></script>
<?php require_once 'footer.php'; ?>