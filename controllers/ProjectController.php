<?php
require_once '../models/Project.php';

$projectModel = new Project();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_proyecto = filter_input(INPUT_POST, 'id_proyecto', FILTER_VALIDATE_INT);
    $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
    $fecha_inicio = filter_input(INPUT_POST, 'fecha_inicio', FILTER_SANITIZE_STRING);
    $fecha_entrega = filter_input(INPUT_POST, 'fecha_entrega', FILTER_SANITIZE_STRING);
    $valor = filter_input(INPUT_POST, 'valor', FILTER_VALIDATE_FLOAT);
    $lugar = filter_input(INPUT_POST, 'lugar', FILTER_SANITIZE_STRING);
    $responsable = filter_input(INPUT_POST, 'responsable', FILTER_VALIDATE_INT);
    $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);

    // Consulta para verificar si el ID del responsable existe en la base de datos
    $sql = "SELECT id_persona FROM personas WHERE id_persona = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$responsable]);
    $persona = $stmt->fetch();

    if (!$persona) {
        echo "<script>alert('El ID del responsable no existe en la base de datos.'); window.location.href='../views/dashboardProject.php';</script>";
        exit;
    }

    if (!$descripcion || !$fecha_inicio || !$fecha_entrega || $valor === false || !$lugar || !$responsable || !$estado) {
        echo "<script>alert('Error en la validación de los datos.'); window.location.href='../views/dashboardProject.php';</script>";
        exit;
    }

    // Convertir fechas a objetos DateTime para comparar
    $inicio = new DateTime($fecha_inicio);
    $entrega = new DateTime($fecha_entrega);

    if ($entrega < $inicio) {
        echo "<script>alert('Error: La fecha de entrega no puede ser menor que la fecha de inicio.'); window.location.href='../views/dashboardProject.php';</script>";
        exit;
    }

    try {
        if (isset($_POST['create'])) {
            $projectModel->createProject($id_proyecto, $descripcion, $fecha_inicio, $fecha_entrega, $valor, $lugar, $responsable, $estado);
            echo "<script>alert('Proyecto creado exitosamente!'); window.location.href='../views/dashboardProject.php';</script>";
        } elseif (isset($_POST['update'])) {
            $projectModel->updateProject($id_proyecto, $descripcion, $fecha_inicio, $fecha_entrega, $valor, $lugar, $responsable, $estado);
            echo "<script>alert('Proyecto actualizado exitosamente!'); window.location.href='../views/dashboardProject.php';</script>";
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "<script>alert('Error: El ID de proyecto ya está en uso. Por favor, elige otro.'); window.location.href='../views/dashboardProject.php';</script>";
        } else {
            echo "<script>alert('Error en la base de datos: " . addslashes($e->getMessage()) . "'); window.location.href='../views/dashboardProject.php';</script>";
        }
    }
} else {
    echo "<script>alert('Error en la validación de los datos.'); window.location.href='../views/dashboardProject.php';</script>";
}
?>