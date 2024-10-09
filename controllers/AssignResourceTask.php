<?php
require_once '../db_conexion.php';  // Asegúrate de ajustar la ruta correctamente
$idTarea = $_POST['idTarea'];
$idRecurso = $_POST['idRecurso'];
$cantidad = $_POST['cantidad'];

try {
    $sql = "INSERT INTO tareaxrecurso (id_tarea, id_recurso, cantidad) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    // Vinculando los valores de las variables
    $stmt->bindValue(1, $idTarea, PDO::PARAM_INT);
    $stmt->bindValue(2, $idRecurso, PDO::PARAM_INT);
    $stmt->bindValue(3, $cantidad, PDO::PARAM_INT);
    $stmt->execute();
    echo "<script>alert('Recurso asignado correctamente!'); window.location.href='../views/dashboardTask.php';</script>";
} catch (PDOException $e) {
    die("ERROR: No se pudo ejecutar $sql. " . $e->getMessage());
}

$stmt = null;
$pdo = null;
?>