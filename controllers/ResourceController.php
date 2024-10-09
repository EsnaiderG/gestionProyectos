<?php
require_once '../models/Resource.php';

$resourceModel = new Resource();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitización y validación de las entradas
    $id_recurso = filter_input(INPUT_POST, 'id_recurso', FILTER_VALIDATE_INT);
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
    $valor = filter_input(INPUT_POST, 'valor', FILTER_VALIDATE_FLOAT);
    $unidad_medida = filter_input(INPUT_POST, 'unidad_medida', FILTER_SANITIZE_STRING);

    // Verificar que los campos necesarios están presentes
    if (!$descripcion || $valor === false || !$unidad_medida) {
        echo "<script>alert('Error en la validación de los datos.'); window.location.href='../views/dashboardResource.php';</script>";
        exit;
    }

    try {
        if (isset($_POST['create'])) {
            // Crear un nuevo recurso
            $resourceModel->createResource($id_recurso, $nombre, $descripcion, $valor, $unidad_medida);
            echo "<script>alert('Recurso creado exitosamente!'); window.location.href='../views/dashboardResource.php';</script>";
        } elseif (isset($_POST['update'])) {
            // Actualizar un recurso existente
            $resourceModel->updateResource($id_recurso, $nombre, $descripcion, $valor, $unidad_medida);
            echo "<script>alert('Recurso actualizado exitosamente!'); window.location.href='../views/dashboardResource.php';</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error en la base de datos: " . addslashes($e->getMessage()) . "'); window.location.href='../views/dashboardResource.php';</script>";
    }
} else {
    // Método de acceso no permitido
    echo "<script>alert('Método de solicitud no soportado.'); window.location.href='../views/dashboardResource.php';</script>";
}
?>
