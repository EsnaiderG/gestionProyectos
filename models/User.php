<?php
require_once '../db_conexion.php';

class User
{
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createUser($id_persona, $nombre, $apellidos, $direccion, $telefono, $sexo, $fecha_nacimiento, $profesion, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        error_log("Hash generado para inserción: " . $hashedPassword);

        $sql = "INSERT INTO personas (id_persona, nombre, apellidos, direccion, telefono, sexo, fecha_nacimiento, profesion, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        if (!$stmt) {
            error_log("Error al preparar la declaración: " . implode(";", $this->pdo->errorInfo()));
            return false;
        }

        $success = $stmt->execute([$id_persona, $nombre, $apellidos, $direccion, $telefono, $sexo, $fecha_nacimiento, $profesion, $hashedPassword]);
        if ($success) {
            error_log("Usuario creado con éxito. ID: {$id_persona}");
        } else {
            error_log("Error al insertar el usuario: " . implode(";", $stmt->errorInfo()));
        }
        return $success;
    }

    public function updateUser($id, $nombre, $apellidos, $direccion, $telefono, $sexo, $fecha_nacimiento, $profesion, $newPassword = null)
    {
        global $pdo;
        // Actualizar la contraseña solo si se proporciona una nueva
        if ($newPassword) {
            $passwordHash = password_hash($newPassword, PASSWORD_BCRYPT);
            $sql = "UPDATE personas SET nombre = ?, apellidos = ?, direccion = ?, telefono = ?, sexo = ?, fecha_nacimiento = ?, profesion = ?, password = ? WHERE id_persona = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nombre, $apellidos, $direccion, $telefono, $sexo, $fecha_nacimiento, $profesion, $passwordHash, $id]);
        } else {
            $sql = "UPDATE personas SET nombre = ?, apellidos = ?, direccion = ?, telefono = ?, sexo = ?, fecha_nacimiento = ?, profesion = ? WHERE id_persona = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nombre, $apellidos, $direccion, $telefono, $sexo, $fecha_nacimiento, $profesion, $id]);
        }
    }
}
?>