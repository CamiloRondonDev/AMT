<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Panel de Administración</title>
<style>
  /* Reset y básicos */
  * {
    box-sizing: border-box;
  }
  body {
    margin: 0;
    font-family: Arial, sans-serif;
    display: flex;
    height: 100vh;
    overflow: hidden;
  }

  /* Sidebar */
  #sidebar {
    width: 250px;
    background-color: #2c3e50;
    color: #ecf0f1;
    transition: transform 0.3s ease;
    padding-top: 60px;
    position: fixed;
    height: 100%;
    overflow-y: auto;
  }
  #sidebar.hidden {
    transform: translateX(-100%);
  }

  #sidebar ul {
    list-style: none;
    padding: 0;
  }

  #sidebar ul li {
    padding: 15px 20px;
    cursor: pointer;
  }

  #sidebar ul li:hover {
    background-color: #008F00;
  }

  /* Header */
  header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 60px;
    background-color: #008F00;
    color: white;
    display: flex;
    align-items: center;
    padding: 0 15px;
    justify-content: space-between;
    z-index: 1000;
  }

  /* Botón hamburguesa */
  #btnToggleSidebar {
    font-size: 24px;
    cursor: pointer;
  }

  /* Icono tuerca */
  #btnSettings {
    font-size: 22px;
    cursor: pointer;
  }

  /* Contenido principal */
  #content {
    margin-left: 250px;
    padding: 70px 20px 20px 20px;
    flex-grow: 1;
    transition: margin-left 0.3s ease;
  }
  #content.full {
    margin-left: 0;
  }

  /* Modal para cambiar contraseña */
  #modalChangePass {
    position: fixed;
    top: 0;
    left: 0;
    right:0;
    bottom: 0;
    background-color: rgba(0,0,0,0.5);
    display: none;
    justify-content: center;
    align-items: center;
  }
  #modalChangePass.active {
    display: flex;
  }
  #modalChangePass .modal-content {
    background: white;
    padding: 20px;
    border-radius: 6px;
    width: 300px;
  }
  #modalChangePass label {
    display: block;
    margin: 10px 0 5px;
  }
  #modalChangePass input[type="password"] {
    width: 100%;
    padding: 8px;
  }
  #modalChangePass button {
    margin-top: 15px;
    padding: 10px;
    width: 100%;
    cursor: pointer;
  }
</style>
</head>
<body>

<!-- Sidebar -->
<nav id="sidebar">
  <ul>
    <li>Usuarios</li>
    <li>Productos</li>
    <li>Informes</li>
  </ul>
</nav>

<!-- Header -->
<header>
  <div id="btnToggleSidebar">&#9776;</div> <!-- ☰ -->
  <div>Panel de Administración</div>
  <div id="btnSettings" title="Cambiar contraseña">&#9881;</div> <!-- ⚙ -->
</header>

<!-- Contenido principal -->
<main id="content">
  <h1>Bienvenido al panel de administración</h1>
  <p>Selecciona una opción del menú.</p>
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

<script>
  const sidebar = document.getElementById('sidebar');
  const btnToggleSidebar = document.getElementById('btnToggleSidebar');
  const content = document.getElementById('content');
  const btnSettings = document.getElementById('btnSettings');
  const modalChangePass = document.getElementById('modalChangePass');
  const closeModal = document.getElementById('closeModal');
  const formChangePass = document.getElementById('formChangePass');

  // Mostrar / ocultar sidebar al hacer clic en hamburguesa
  btnToggleSidebar.addEventListener('click', () => {
    sidebar.classList.toggle('hidden');
    content.classList.toggle('full');
  });

  // Mostrar modal cambio de contraseña
  btnSettings.addEventListener('click', () => {
    modalChangePass.classList.add('active');
  });

  // Cerrar modal
  closeModal.addEventListener('click', () => {
    modalChangePass.classList.remove('active');
  });

  // Manejar envío de cambio de contraseña (aquí debes hacer el fetch o submit real)
  formChangePass.addEventListener('submit', (e) => {
    e.preventDefault();

    const currentPass = formChangePass.currentPass.value;
    const newPass = formChangePass.newPass.value;
    const confirmPass = formChangePass.confirmPass.value;

    if(newPass !== confirmPass) {
      alert("Las contraseñas nuevas no coinciden.");
      return;
    }

    // Aquí iría la llamada al backend para cambiar la contraseña
    alert("Aquí va la lógica para cambiar la contraseña.");

    // Cerrar modal
    modalChangePass.classList.remove('active');
    formChangePass.reset();
  });
</script>

</body>
</html>
