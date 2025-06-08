<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
      <style>
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: left;
    }
    th {
      background-color: #3da60d;
      color: white;
    }
    tr:hover {
      background-color: #f1f1f1;
    }
  </style>
</head>
<body>
    <h2>Lista de Usuarios</h2>
<div class="tabla-scroll">
  <table id="tablaUsuarios">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Correo</th>
        <th>tipo usuario</th>
        <!-- Agrega más columnas si tu tabla tiene más campos -->
      </tr>
    </thead>
    <tbody>
      <!-- Aquí se cargan los usuarios -->
    </tbody>
  </table>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../public/js/usuarios.js"></script>
</body>
</html>