<?php
require_once '../models/User.php';  // Asegúrate de que la ruta al modelo User es correcta

$userModel = new User($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar y validar la entrada
    $id_persona = filter_input(INPUT_POST, 'id_persona', FILTER_VALIDATE_INT);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $apellidos = filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING);
    $direccion = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRING);
    $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);
    $sexo = filter_input(INPUT_POST, 'sexo', FILTER_SANITIZE_STRING);
    $fecha_nacimiento = filter_input(INPUT_POST, 'fecha_nacimiento', FILTER_SANITIZE_STRING);
    $profesion = filter_input(INPUT_POST, 'profesion', FILTER_SANITIZE_STRING);


    if ($nombre && $apellidos && $direccion && $telefono && in_array($sexo, ['M', 'F']) && $fecha_nacimiento && $profesion && $password) {
        try {
            if (isset($_POST['create'])) {
                $userModel->createUser($id_persona, $nombre, $apellidos, $direccion, $telefono, $sexo, $fecha_nacimiento, $profesion, $password);
                echo "<script>alert('Usuario creado exitosamente!'); window.location.href='../views/dashboardUser.php';</script>";
            } elseif (isset($_POST['update'])) {
                $userModel->updateUser($id_persona, $nombre, $apellidos, $direccion, $telefono, $sexo, $fecha_nacimiento, $profesion, $password);
                echo "<script>alert('Usuario actualizado exitosamente!'); window.location.href='../views/dashboardUser.php';</script>";
            }
        } catch (PDOException $e) {
            error_log("Error PDO: " . $e->getMessage());
            echo "<script>alert('Error en la base de datos: " . addslashes($e->getMessage()) . "'); window.location.href='../views/dashboardUser.php';</script>";
        }
    } else {
        error_log("Error en validación de los datos.");
        echo "<script>alert('Error en la validación de los datos.'); window.location.href='../views/dashboardUser.php';</script>";
    }
}
?>