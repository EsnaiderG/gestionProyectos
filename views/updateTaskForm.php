<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/loginForm.php");
    exit;
}

require_once '../db_conexion.php';

$id_tarea = isset($_GET['id']) ? $_GET['id'] : 0;  // Obtener el ID de la tarea desde la URL.

// Consulta para obtener los datos de la tarea
$sql = "SELECT * FROM tareas WHERE id_tarea = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_tarea]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    echo "Tarea no encontrada";
    exit;  // Si no se encuentra la tarea, termina la ejecución.
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Actualizar Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Actualizar Tarea</h3>
                    </div>
                    <div class="card-body">
                        <form name="updateTaskForm" onsubmit="return validateTaskForm()" method="post"
                            action="../controllers/TaskController.php">
                            <input type="hidden" id="id_tarea" name="id_tarea"
                                value="<?php echo htmlspecialchars($task['id_tarea']); ?>">

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="descripcion" name="descripcion"
                                    value="<?php echo htmlspecialchars($task['descripcion']); ?>"
                                    placeholder="Descripción" required>
                                <label for="descripcion">Descripción</label>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio"
                                            value="<?php echo htmlspecialchars($task['fecha_inicio']); ?>"
                                            placeholder="Fecha de Inicio" required>
                                        <label for="fecha_inicio">Fecha de Inicio</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="fecha_final" name="fecha_final"
                                            value="<?php echo htmlspecialchars($task['fecha_final']); ?>"
                                            placeholder="Fecha Final" required>
                                        <label for="fecha_final">Fecha Final</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" id="id_actividad" name="id_actividad" required>
                                    <?php
                                    include '../db_conexion.php';
                                    $stmt = $pdo->query("SELECT id_actividad, descripcion FROM actividades");
                                    while ($actividad = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $selected = ($actividad['id_actividad'] == $task['id_actividad']) ? ' selected' : '';
                                        echo "<option value='" . $actividad['id_actividad'] . "'" . $selected . ">" . $actividad['id_actividad'] . " - " . htmlspecialchars($actividad['descripcion']) . "</option>";
                                    }
                                    ?>
                                </select>
                                <label for="id_actividad">Actividad</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="Pendiente" <?php echo $task['estado'] === 'Pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                    <option value="En Progreso" <?php echo $task['estado'] === 'En Progreso' ? 'selected' : ''; ?>>En Progreso</option>
                                    <option value="Completada" <?php echo $task['estado'] === 'Completada' ? 'selected' : ''; ?>>Completada</option>
                                </select>
                                <label for="estado">Estado</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="presupuesto" name="presupuesto"
                                    value="<?php echo htmlspecialchars($task['presupuesto']); ?>"
                                    placeholder="Presupuesto" required>
                                <label for="presupuesto">Presupuesto</label>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-warning me-2" type="submit" name="update">Actualizar Tarea</button>
                                <a class="btn btn-danger" href="../views/dashboardTask.php">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateTaskForm() {
            var fechaInicio = document.forms["updateTaskForm"]["fecha_inicio"].value;
            var fechaFinal = document.forms["updateTaskForm"]["fecha_final"].value;
            var idactividad = document.forms["taskForm"]["id_actividad"].value;

            // Convertir las fechas a objetos Date para comparación
            var inicio = new Date(fechaInicio);
            var final = new Date(fechaFinal);

            // Verificar que la fecha final no sea anterior a la fecha de inicio
            if (final < inicio) {
                alert("La fecha final no puede ser menor que la fecha de inicio.");
                return false;
            }

            // Verificar que el campo "idactividad" contenga solo números
            if (!/^\d+$/.test(idactividad)) {
                alert("El campo 'ID de Actividad' debe contener solo números.");
                return false;
            }

            return true;
        }
    </script>
</body>

</html>