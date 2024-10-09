<?php
require_once '../models/Task.php';

$taskModel = new Task();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_tarea = filter_input(INPUT_POST, 'id_tarea', FILTER_VALIDATE_INT);
    $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
    $fecha_inicio = filter_input(INPUT_POST, 'fecha_inicio', FILTER_SANITIZE_STRING);
    $fecha_final = filter_input(INPUT_POST, 'fecha_final', FILTER_SANITIZE_STRING);
    $id_actividad = filter_input(INPUT_POST, 'id_actividad', FILTER_VALIDATE_INT);
    $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);
    $presupuesto = filter_input(INPUT_POST, 'presupuesto', FILTER_VALIDATE_FLOAT);

    // Validar si el id_actividad existe en la tabla de actividades
    $sql = "SELECT fecha_inicio, fecha_final, presupuesto FROM actividades WHERE id_actividad = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_actividad]);
    $actividad = $stmt->fetch();

    if (!$actividad) {
        echo "<script>alert('Error: El ID de actividad ingresado no existe.'); window.location.href='../views/dashboardTask.php';</script>";
        exit;
    }

    // Calcular el total de presupuesto ya gastado en tareas de esta actividad
    $sqlGastado = "SELECT SUM(presupuesto) AS total_gastado FROM tareas WHERE id_actividad = ?";
    $stmtGastado = $pdo->prepare($sqlGastado);
    $stmtGastado->execute([$id_actividad]);
    $gasto = $stmtGastado->fetch();
    $presupuestoGastado = $gasto['total_gastado'] ?? 0;
    $presupuestoRestante = $actividad['presupuesto'] - $presupuestoGastado;
    
    // Validaciones fechas
    $inicioActividad = new DateTime($actividad['fecha_inicio']);
    $finalActividad = new DateTime($actividad['fecha_final']);
    $inicio = new DateTime($fecha_inicio);
    $final = new DateTime($fecha_final);

    // Validación de fechas y presupuesto
    if ($final < $inicio || $inicio < $inicioActividad || $final > $finalActividad) {
        echo "<script>alert('Error: La fecha de la tarea debe estar dentro del periodo de la actividad asignada.'); window.location.href='../views/dashboardTask.php';</script>";
        exit;
    }

    if ($presupuesto > $presupuestoRestante) {
        echo "<script>alert('Error: El presupuesto de la tarea no puede exceder el presupuesto restante de la actividad asignada. Presupuesto disponible: $presupuestoRestante'); window.location.href='../views/dashboardTask.php';</script>";
        exit;
    }

    // Crear o actualizar la tarea
    try {
        if (isset($_POST['create'])) {
            $taskModel->createTask($id_tarea, $descripcion, $fecha_inicio, $fecha_final, $id_actividad, $estado, $presupuesto);
            echo "<script>alert('Tarea creada exitosamente!'); window.location.href='../views/dashboardTask.php';</script>";
        } elseif (isset($_POST['update'])) {
            $taskModel->updateTask($id_tarea, $descripcion, $fecha_inicio, $fecha_final, $id_actividad, $estado, $presupuesto);
            echo "<script>alert('Tarea actualizada exitosamente!'); window.location.href='../views/dashboardTask.php';</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error en la base de datos: " . addslashes($e->getMessage()) . "'); window.location.href='../views/dashboardTask.php';</script>";
    }
} else {
    echo "<script>alert('Error en la validación de los datos.'); window.location.href='../views/dashboardTask.php';</script>";
}
?>
