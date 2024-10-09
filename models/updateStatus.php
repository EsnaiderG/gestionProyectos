<?php
require_once '../db_conexion.php';
function updateActivityAndProjectStatus() {
    global $pdo;

    // Paso 1: Actualizar el estado de las actividades
    $sqlUpdateActivity = "UPDATE actividades SET estado = CASE 
        WHEN id_actividad IN (
            SELECT id_actividad FROM tareas
            GROUP BY id_actividad
            HAVING COUNT(*) = SUM(CASE WHEN estado = 'Completada' THEN 1 ELSE 0 END)
        ) THEN 'Completada'
        ELSE 'En Progreso'
        END";
    $pdo->exec($sqlUpdateActivity);

    // Paso 2: Actualizar el estado de los proyectos
    $sqlUpdateProject = "UPDATE proyectos SET estado = CASE 
        WHEN id_proyecto IN (
            SELECT id_proyecto FROM actividades
            GROUP BY id_proyecto
            HAVING COUNT(*) = SUM(CASE WHEN estado = 'Completada' THEN 1 ELSE 0 END)
        ) THEN 'Completado'
        ELSE 'En Progreso'
        END";
    $pdo->exec($sqlUpdateProject);
}

// Ejecutar la función de actualización
updateActivityAndProjectStatus();
?>