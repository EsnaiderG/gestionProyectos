<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/loginForm.php");
    exit;
}

require_once '../db_conexion.php';

$id_proyecto = isset($_GET['id']) ? $_GET['id'] : 0;  // Obtener el ID del proyecto desde la URL.

// Consulta para obtener los datos del proyecto
$sql = "SELECT * FROM proyectos WHERE id_proyecto = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_proyecto]);
$project = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$project) {
    echo "Proyecto no encontrado";
    exit;  // Si no se encuentra el proyecto, termina la ejecución.
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Actualizar Proyecto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Actualizar Proyecto</h3>
                    </div>
                    <div class="card-body">
                        <form name="updateProjectForm" onsubmit="return validateProjectForm()" method="post"
                            action="../controllers/ProjectController.php">
                            <input type="hidden" id="id_proyecto" name="id_proyecto"
                                value="<?php echo htmlspecialchars($project['id_proyecto']); ?>">

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="descripcion" name="descripcion"
                                    value="<?php echo htmlspecialchars($project['descripcion']); ?>"
                                    placeholder="Descripción del proyecto" required>
                                <label for="descripcion">Descripción</label>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio"
                                            value="<?php echo htmlspecialchars($project['fecha_inicio']); ?>"
                                            placeholder="Fecha de Inicio" required>
                                        <label for="fecha_inicio">Fecha de Inicio</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega"
                                            value="<?php echo htmlspecialchars($project['fecha_entrega']); ?>"
                                            placeholder="Fecha de Entrega" required>
                                        <label for="fecha_entrega">Fecha de Entrega</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="valor" name="valor"
                                            value="<?php echo htmlspecialchars($project['valor']); ?>"
                                            placeholder="Valor del proyecto" required>
                                        <label for="valor">Valor</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="lugar" name="lugar"
                                            value="<?php echo htmlspecialchars($project['lugar']); ?>"
                                            placeholder="Lugar del proyecto" required>
                                        <label for="lugar">Lugar</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="responsable" name="responsable" required>
                                            <?php
                                            $stmt_personas = $pdo->query("SELECT id_persona, nombre FROM personas");
                                            while ($persona = $stmt_personas->fetch(PDO::FETCH_ASSOC)) {
                                                $selected = ($persona['id_persona'] == $project['responsable']) ? ' selected' : '';
                                                echo "<option value='" . $persona['id_persona'] . "'" . $selected . ">" . $persona['id_persona'] . " - " . htmlspecialchars($persona['nombre']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="responsable">Responsable</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="estado" name="estado" required>
                                            <option value="Pendiente" <?php echo $project['estado'] === 'Pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                            <option value="En progreso" <?php echo $project['estado'] === 'En progreso' ? 'selected' : ''; ?>>En progreso</option>
                                            <option value="Completado" <?php echo $project['estado'] === 'Completado' ? 'selected' : ''; ?>>Completado</option>
                                        </select>
                                        <label for="estado">Estado</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button class="btn btn-warning me-2" type="submit" name="update">Actualizar Proyecto</button>
                                <a class="btn btn-danger" href="../views/dashboardProject.php">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateProjectForm() {
            var fechaInicio = document.forms["projectForm"]["fecha_inicio"].value;
            var fechaEntrega = document.forms["projectForm"]["fecha_entrega"].value;
            var responsable = document.forms["projectForm"]["responsable"].value;

            // Convertir las fechas a objetos Date para comparación
            var inicio = new Date(fechaInicio);
            var entrega = new Date(fechaEntrega);

            // Verificar que la fecha de entrega no sea anterior a la fecha de inicio
            if (entrega < inicio) {
                alert("La fecha de entrega no puede ser menor que la fecha de inicio.");
                return false;
            }

            // Verificar que el campo "responsable" contenga solo números
            if (!/^\d+$/.test(responsable)) {
                alert("El campo 'Responsable' debe contener solo números (id_persona).");
                return false;
            }

            return true;
        }
    </script>
</body>

</html>