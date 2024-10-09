<?php
require_once '../db_conexion.php';

class Task
{
    // Método para crear una nueva tarea
    public function createTask($id_tarea, $descripcion, $fecha_inicio, $fecha_final, $id_actividad, $estado, $presupuesto)
    {
        global $pdo;
        $sql = "INSERT INTO tareas (id_tarea, descripcion, fecha_inicio, fecha_final, id_actividad, estado, presupuesto) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_tarea, $descripcion, $fecha_inicio, $fecha_final, $id_actividad, $estado, $presupuesto]);
    }

    // Método para actualizar una tarea existente
    public function updateTask($id_tarea, $descripcion, $fecha_inicio, $fecha_final, $id_actividad, $estado, $presupuesto)
    {
        global $pdo;
        $sql = "UPDATE tareas SET descripcion = ?, fecha_inicio = ?, fecha_final = ?, id_actividad = ?, estado = ?, presupuesto = ? WHERE id_tarea = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$descripcion, $fecha_inicio, $fecha_final, $id_actividad, $estado, $presupuesto, $id_tarea]);
    }
}
?>