<?php require_once 'header.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Usuario</title>
  <link rel="stylesheet" href="/amt/public/css/create_user.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<main class="registro-container">
  <h2>Pre-registro de proveedor</h2>
  <form id="registroForm">
    <input type="text" name="nom_usu" placeholder="Nombre" required>
    <input type="text" name="apell_usus" placeholder="Apellido" required>

    <select name="tipoDoc_usu" required>
        <option value="">Seleccione tipo de documento</option>
        <option value="CC">Cédula de Ciudadanía (CC)</option>
        <option value="NIT">Número de Identificación Tributaria (NIT)</option>
    </select>

    <input type="text" name="id_usu" placeholder="Documento" required>
    <input type="email" name="correo_usu" placeholder="Correo" required>
    <input type="number" name="tel_usu" placeholder="Teléfono" required>
    <input type="text" name="tipo_usu" placeholder="Tipo de usuario" required>
    <input type="text" name="red_social" placeholder="Red Social" required>
    <input type="password" name="pass_usu" placeholder="Contraseña" required>
    <input type="password" name="pass_usu_repeat" placeholder="Repita Contraseña" required>
    <button type="submit">Registrarse</button>
  </form>
  <div id="respuesta"></div>
</main>

<script src="/amt/public/js/create_user.js"></script>
</body>
</html>
<?php require_once 'footer.php'; ?>
