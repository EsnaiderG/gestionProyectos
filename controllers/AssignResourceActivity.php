<?php
require_once '../db_conexion.php';  // Asegúrate de ajustar la ruta correctamente
$idActividad = $_POST['idActividad'];
$idRecurso = $_POST['idRecurso'];
$cantidad = $_POST['cantidad'];

try {
    $sql = "INSERT INTO ActividadxRecurso (id_actividad, id_recurso, cantidad) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    // Vinculando los valores de las variables
    $stmt->bindValue(1, $idActividad, PDO::PARAM_INT);
    $stmt->bindValue(2, $idRecurso, PDO::PARAM_INT);
    $stmt->bindValue(3, $cantidad, PDO::PARAM_INT);
    $stmt->execute();
    echo "<script>alert('Recurso asignado correctamente!'); window.location.href='../views/dashboardActivity.php';</script>";
} catch (PDOException $e) {
    die("ERROR: No se pudo ejecutar $sql. " . $e->getMessage());
}

$stmt = null;
$pdo = null;
?>