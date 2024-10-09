<?php
// Inicia la sesión
session_start();

//Esto destruirá los cookies de sesión.
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


// Vacía todas las variables de sesión
$_SESSION = array();

// Esto destruirá la sesión, y no solo los datos de la sesión!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destruye la sesión.
session_destroy();

// Redirecciona a la página de inicio de sesión o a la página principal
header('Location: ../index.php');
exit();
?>