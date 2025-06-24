document.getElementById("registroForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const form = e.target;
    const pass1 = form.querySelector('input[name="pass_usu"]').value;
  const pass2 = form.querySelector('input[name="pass_usu_repeat"]').value;

  if (pass1 !== pass2) {
    document.getElementById("respuesta").innerText = "Las contraseñas no coinciden.";
    return; // Detener envío
  }

  const data = new FormData(form);

  $.ajax({
    url: 'http://localhost/amt/app/models/createUser.php',  // Cambia si tu ruta varía
    type: 'POST',
    data: data,
    processData: false,  // Necesario para FormData
    contentType: false,  // Necesario para FormData
    success: function (response) {
      // Verifica si es string o JSON
      if (typeof response === 'string') {
        document.getElementById("respuesta").innerText = response;
      } else {
        if (response.success) {
          document.getElementById("respuesta").innerText = "Registro exitoso.";
          // window.location.href = 'login.php'; // Descomenta si quieres redirigir
        } else {
          document.getElementById("respuesta").innerText = "Error: " + response.message;
        }
      }

      form.reset(); // Limpia formulario
    },
    error: function (xhr, status, error) {
      document.getElementById("respuesta").innerText = "Error al registrar usuario.";
      console.error("Error AJAX:", error);
    }
  });
});
