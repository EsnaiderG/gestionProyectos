<?php
require_once '../db_conexion.php';

class Activity
{
    // Método para crear una nueva actividad
    public function createActivity($id_actividad, $descripcion, $fecha_inicio, $fecha_final, $id_proyecto, $responsable, $estado, $presupuesto)
    {
        global $pdo;
        $sql = "INSERT INTO actividades (id_actividad, descripcion, fecha_inicio, fecha_final, id_proyecto, responsable, estado, presupuesto) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_actividad, $descripcion, $fecha_inicio, $fecha_final, $id_proyecto, $responsable, $estado, $presupuesto]);
    }

    // Método para actualizar una actividad existente
    public function updateActivity($id_actividad, $descripcion, $fecha_inicio, $fecha_final, $id_proyecto, $responsable, $estado, $presupuesto)
    {
        global $pdo;
        $sql = "UPDATE actividades SET descripcion = ?, fecha_inicio = ?, fecha_final = ?, id_proyecto = ?, responsable = ?, estado = ?, presupuesto = ? WHERE id_actividad = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$descripcion, $fecha_inicio, $fecha_final, $id_proyecto, $responsable, $estado, $presupuesto, $id_actividad]);
    }
}
?>
