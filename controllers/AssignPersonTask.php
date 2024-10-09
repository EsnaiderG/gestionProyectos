<?php
require_once '../db_conexion.php';  // Asegúrate de que la ruta es correcta

// Recibir datos del formulario
$idTarea = $_POST['idTarea'];
$idPersona = $_POST['idPersona'];
$duracion = $_POST['duracion'];

try {
    // Preparar la consulta SQL para insertar la asignación en la base de datos
    $sql = "INSERT INTO Tareaxpersona (id_tarea, id_persona, duracion) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    // Vincular los valores a los parámetros
    $stmt->bindValue(1, $idTarea, PDO::PARAM_INT);
    $stmt->bindValue(2, $idPersona, PDO::PARAM_INT);
    $stmt->bindValue(3, $duracion, PDO::PARAM_STR);

    $stmt->execute();
    echo "<script>alert('Personal asignado correctamente!'); window.location.href='../views/dashboardTask.php';</script>";

} catch (PDOException $e) {
    echo "Error al asignar personal: " . $e->getMessage();
}

// Cerrar la sentencia y la conexión (opcional si usas conexiones persistentes)
$stmt = null;
$pdo = null;
?>
