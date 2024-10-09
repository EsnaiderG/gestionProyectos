<?php
require_once '../models/Activity.php';

$activityModel = new Activity();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_actividad = filter_input(INPUT_POST, 'id_actividad', FILTER_VALIDATE_INT);
    $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
    $fecha_inicio = filter_input(INPUT_POST, 'fecha_inicio', FILTER_SANITIZE_STRING);
    $fecha_final = filter_input(INPUT_POST, 'fecha_final', FILTER_SANITIZE_STRING);
    $id_proyecto = filter_input(INPUT_POST, 'id_proyecto', FILTER_VALIDATE_INT);
    $responsable = filter_input(INPUT_POST, 'responsable', FILTER_VALIDATE_INT);
    $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);
    $presupuesto = filter_input(INPUT_POST, 'presupuesto', FILTER_VALIDATE_FLOAT);

    // Validar si el id_proyecto existe
    $sql = "SELECT id_proyecto FROM proyectos WHERE id_proyecto = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_proyecto]);
    if (!$stmt->fetch()) {
        echo "<script>alert('Error: El ID del proyecto ingresado no existe.'); window.location.href='../views/dashboardActivity.php';</script>";
        exit;
    }

    // Validar si el responsable existe
    $sql = "SELECT id_persona FROM personas WHERE id_persona = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$responsable]);
    if (!$stmt->fetch()) {
        echo "<script>alert('Error: El ID del responsable ingresado no existe.'); window.location.href='../views/dashboardActivity.php';</script>";
        exit;
    }

    // Continúa con la validación de fechas y otros campos
    $inicio = new DateTime($fecha_inicio);
    $final = new DateTime($fecha_final);
    if ($final < $inicio) {
        echo "<script>alert('Error: La fecha final no puede ser menor que la fecha de inicio.'); window.location.href='../views/dashboardActivity.php';</script>";
        exit;
    }

    if (!$descripcion || !$fecha_inicio || !$fecha_final || !$id_proyecto || !$responsable || !$estado || $presupuesto === false) {
        echo "<script>alert('Error en la validación de los datos.'); window.location.href='../views/dashboardActivity.php';</script>";
        exit;
    }

    try {
        if (isset($_POST['create'])) {
            $activityModel->createActivity($id_actividad, $descripcion, $fecha_inicio, $fecha_final, $id_proyecto, $responsable, $estado, $presupuesto);
            echo "<script>alert('Actividad creada exitosamente!'); window.location.href='../views/dashboardActivity.php';</script>";
        } elseif (isset($_POST['update'])) {
            $activityModel->updateActivity($id_actividad, $descripcion, $fecha_inicio, $fecha_final, $id_proyecto, $responsable, $estado, $presupuesto);
            echo "<script>alert('Actividad actualizada exitosamente!'); window.location.href='../views/dashboardActivity.php';</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error en la base de datos: " . addslashes($e->getMessage()) . "'); window.location.href='../views/dashboadashboardActivityrdGerente.php';</script>";
    }
} else {
    echo "<script>alert('Error en la validación de los datos.'); window.location.href='../views/dashboardActivity.php';</script>";
}
?>