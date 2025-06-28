  const sidebar = document.getElementById('sidebar');
  const btnToggleSidebar = document.getElementById('btnToggleSidebar');
  const content = document.getElementById('content');
  const btnSettings = document.getElementById('btnSettings');
  const modalChangePass = document.getElementById('modalChangePass');
  const closeModal = document.getElementById('closeModal');
  const formChangePass = document.getElementById('formChangePass');
  const panelContent = document.getElementById('panel-content');

  // Mostrar / ocultar sidebar
  btnToggleSidebar.addEventListener('click', () => {
    sidebar.classList.toggle('hidden');
    content.classList.toggle('full');
  });

  // Mostrar modal cambio contraseña
  btnSettings.addEventListener('click', () => {
    modalChangePass.classList.add('active');
  });

  // Cerrar modal
  closeModal.addEventListener('click', () => {
    modalChangePass.classList.remove('active');
  });

  // Envío de cambio de contraseña
  formChangePass.addEventListener('submit', (e) => {
    e.preventDefault();

    const currentPass = formChangePass.currentPass.value;
    const newPass = formChangePass.newPass.value;
    const confirmPass = formChangePass.confirmPass.value;

    if (newPass !== confirmPass) {
      alert("Las contraseñas nuevas no coinciden.");
      return;
    }

    alert("Aquí va la lógica para cambiar la contraseña.");
    modalChangePass.classList.remove('active');
    formChangePass.reset();
  });

    //cerrar sesion
    document.getElementById("btnClose").addEventListener("click", function () {
  const confirmar = confirm("¿Estás seguro de que deseas cerrar sesión?");
  
  if (confirmar) {
    // Redirige a la página de login o logout
    window.location.href = "/AMT/app/views/login.php";
  }
  });

// Cargar vistas dinámicamente en el panel
document.querySelectorAll('#sidebar a[data-url]').forEach(link => {
  link.addEventListener('click', function (e) {
    e.preventDefault();
    const url = this.getAttribute('data-url');

    fetch(url)
      .then(response => {
        if (!response.ok) throw new Error("Error al cargar la vista.");
        return response.text();
      })
      .then(html => {
        // Insertar el contenido en el panel
        panelContent.innerHTML = html;

        // Buscar y ejecutar los scripts incluidos
        const scripts = panelContent.querySelectorAll("script");
        scripts.forEach(script => {
          const newScript = document.createElement("script");
          if (script.src) {
            // Si es un script con src, lo volvemos a cargar
            newScript.src = script.src;
            newScript.async = false; // para mantener el orden de ejecución
          } else {
            // Si es un script inline, copiamos el contenido
            newScript.textContent = script.textContent;
          }
          document.body.appendChild(newScript);
          // Opcionalmente, puedes eliminar el script después de ejecutarlo:
          // document.body.removeChild(newScript);
        });
      })
      .catch(err => {
        panelContent.innerHTML = "<p>Error cargando el contenido.</p>";
        console.error(err);
      });
  });
});

