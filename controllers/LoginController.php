<?php
require_once '../db_conexion.php';  // Asegúrate que la ruta es correcta

session_start();  // Iniciar la sesión al comienzo del script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_persona = $_POST['id_persona'];
    $password = $_POST['password'];

    // Modificar la consulta para recuperar también el campo 'rol'
    $sql = "SELECT id_persona, password, rol FROM personas WHERE id_persona = :id_persona";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_persona', $id_persona);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        // Log del hash recuperado
        error_log("Hash recuperado: " . $user['password']);

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $id_persona;  // Almacenar el ID de usuario en la sesión
            $_SESSION['rol'] = $user['rol'];     // Almacenar el rol del usuario en la sesión
            
            // Redirigir basado en el rol del usuario
            if ($user['rol'] === 'gerente') {
                header("Location: ../views/dashboardUser.php");
            } else if ($user['rol'] === 'trabajador') {
                header("Location: ../views/dashboardTrabajador.php");
            } else {
                // Redireccionar a un por defecto si el rol no es reconocido
                header("Location: ../views/loginForm.php");
            }
            exit;  // Asegurarse de que no se ejecute más código después de la redirección
        } else {
            echo "<script>alert('ID de usuario o contraseña incorrectos.'); window.location.href='../views/loginForm.php';</script>";
        }
    } else {
        echo "<script>alert('ID de usuario o contraseña incorrectos.'); window.location.href='../views/loginForm.php';</script>";
    }
}
?>
