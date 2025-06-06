<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista de Productos</title>
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

  <h2>Productos Disponibles</h2>
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

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../../public/js/adm_productos.js"></script>


</body>
</html>
