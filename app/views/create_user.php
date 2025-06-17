<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
    <link rel="stylesheet" href="/amt/public/css/create_user.css">
  <title>Registro de Usuario</title>
</head>
<body>
  <h2>Formulario de Registro</h2>
  <form id="registroForm">
  <input type="text" name="nom_usu" placeholder="Nombre" required>
  <input type="text" name="apell_usus" placeholder="Apellido" required>
  <input type="text" name="tipoDoc_usu" placeholder="Tipo de documento" required>
  <input type="email" name="correo_usu" placeholder="Correo" required>
  <input type="text" name="tel_usu" placeholder="Teléfono" required>
  <input type="password" name="pass_usu" placeholder="Contraseña" required>
  <input type="text" name="tipo_usu" placeholder="Tipo de usuario" required>
    <button type="submit">Registrarse</button>
  </form>

  <div id="respuesta"></div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../../public/js/create_user.js"></script>
</body>
</html>
