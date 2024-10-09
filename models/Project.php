<?php
require_once '../db_conexion.php';

class Project
{
    // Método para crear un nuevo proyecto
    public function createProject($id_proyecto, $descripcion, $fecha_inicio, $fecha_entrega, $valor, $lugar, $responsable, $estado)
    {
        global $pdo;
        $sql = "INSERT INTO proyectos (id_proyecto, descripcion, fecha_inicio, fecha_entrega, valor, lugar, responsable, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_proyecto, $descripcion, $fecha_inicio, $fecha_entrega, $valor, $lugar, $responsable, $estado]);
    }

    // Método para actualizar un proyecto existente
    public function updateProject($id_proyecto, $descripcion, $fecha_inicio, $fecha_entrega, $valor, $lugar, $responsable, $estado)
    {
        global $pdo;
        $sql = "UPDATE proyectos SET descripcion = ?, fecha_inicio = ?, fecha_entrega = ?, valor = ?, lugar = ?, responsable = ?, estado = ? WHERE id_proyecto = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$descripcion, $fecha_inicio, $fecha_entrega, $valor, $lugar, $responsable, $estado, $id_proyecto]);
    }
}
?>