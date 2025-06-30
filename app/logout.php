<?php
session_start();       // 1. Inicia la sesión (para poder destruirla)
session_unset();       // 2. Elimina todas las variables de sesión
session_destroy();     // 3. Destruye la sesión en el servidor
// 4. Opcional: asegurar que no quede nada de caché
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
// 5. Redirige al usuario al login (o la página que quieras)
header("Location: /amt/app/views/login.php"); 
exit;
