<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/loginForm.php");
    exit;
}

require_once '../db_conexion.php';

$id_actividad = isset($_GET['id']) ? $_GET['id'] : 0;  // Obtener el ID de la actividad desde la URL.

// Consulta para obtener los datos de la actividad
$sql = "SELECT * FROM actividades WHERE id_actividad = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_actividad]);
$actividad = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$actividad) {
    echo "Actividad no encontrada";
    exit;  // Si no se encuentra la actividad, termina la ejecución.
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Actualizar Actividad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Actualizar Actividad</h3>
                    </div>
                    <div class="card-body">
                        <form name="activityForm" onsubmit="return validateActivityForm()" method="post"
                            action="../controllers/ActivityController.php">
                            <input type="hidden" id="id_actividad" name="id_actividad"
                                value="<?php echo htmlspecialchars($actividad['id_actividad']); ?>">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="descripcion" name="descripcion"
                                            value="<?php echo htmlspecialchars($actividad['descripcion']); ?>"
                                            placeholder="Descripción" required>
                                        <label for="descripcion">Descripción</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio"
                                            value="<?php echo htmlspecialchars($actividad['fecha_inicio']); ?>"
                                            placeholder="Fecha de Inicio" required>
                                        <label for="fecha_inicio">Fecha de Inicio</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="fecha_final" name="fecha_final"
                                            value="<?php echo htmlspecialchars($actividad['fecha_final']); ?>"
                                            placeholder="Fecha Final" required>
                                        <label for="fecha_final">Fecha Final</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="presupuesto" name="presupuesto"
                                            value="<?php echo htmlspecialchars($actividad['presupuesto']); ?>"
                                            placeholder="Presupuesto" required>
                                        <label for="presupuesto">Presupuesto</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="id_proyecto" name="id_proyecto" required>
                                            <?php
                                            include '../db_conexion.php';
                                            $stmt = $pdo->query("SELECT id_proyecto, descripcion FROM proyectos");
                                            while ($proyecto = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                $selected = ($proyecto['id_proyecto'] == $actividad['id_proyecto']) ? ' selected' : '';
                                                echo "<option value='" . $proyecto['id_proyecto'] . "'" . $selected . ">" . $proyecto['id_proyecto'] . " - " . htmlspecialchars($proyecto['descripcion']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="id_proyecto">Proyecto</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="responsable" name="responsable" required>
                                            <?php
                                            $stmt = $pdo->query("SELECT id_persona, nombre FROM personas");
                                            while ($persona = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                $selected = ($persona['id_persona'] == $actividad['responsable']) ? ' selected' : '';
                                                echo "<option value='" . $persona['id_persona'] . "'" . $selected . ">" . $persona['id_persona'] . " - " . htmlspecialchars($persona['nombre']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="responsable">Responsable (ID Persona)</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating mb-3">
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="Pendiente" <?php echo $actividad['estado'] === 'Pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                    <option value="En progreso" <?php echo $actividad['estado'] === 'En progreso' ? 'selected' : ''; ?>>En progreso</option>
                                    <option value="Completada" <?php echo $actividad['estado'] === 'Completada' ? 'selected' : ''; ?>>Completada</option>
                                </select>
                                <label for="estado">Estado</label>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button class="btn btn-warning me-2" type="submit" name="update">Actualizar
                                    Actividad</button>
                                <a class="btn btn-danger" href="../views/dashboardActivity.php">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateActivityForm() {
            var fechaInicio = document.forms["activityForm"]["fecha_inicio"].value;
            var fechaFinal = document.forms["activityForm"]["fecha_final"].value;

            // Convertir las fechas a objetos Date para comparación
            var inicio = new Date(fechaInicio);
            var final = new Date(fechaFinal);

            // Verificar que la fecha final no sea anterior a la fecha de inicio
            if (final < inicio) {
                alert("La fecha final no puede ser menor que la fecha de inicio.");
                return false;
            }

            return true;
        }
    </script>

</body>

</html>