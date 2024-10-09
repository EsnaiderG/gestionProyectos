<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/loginForm.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrar Actividad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Registrar Actividad</h3>
                    </div>
                    <div class="card-body">
                        <form name="activityForm" onsubmit="return validateActivityForm()" method="post"
                            action="../controllers/ActivityController.php">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="id_actividad" name="id_actividad"
                                            placeholder="ID de la Actividad" required>
                                        <label for="id_actividad">ID de la Actividad</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="descripcion" name="descripcion"
                                            placeholder="Descripción" required>
                                        <label for="descripcion">Descripción</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio"
                                            placeholder="Fecha de Inicio" required>
                                        <label for="fecha_inicio">Fecha de Inicio</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="fecha_final" name="fecha_final"
                                            placeholder="Fecha Final" required>
                                        <label for="fecha_final">Fecha Final</label>
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
                                                echo "<option value='" . $proyecto['id_proyecto'] . "'>" . $proyecto['id_proyecto'] . " - " . htmlspecialchars($proyecto['descripcion']) . "</option>";
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
                                                echo "<option value='" . $persona['id_persona'] . "'>" . $persona['id_persona'] . " - " . htmlspecialchars($persona['nombre']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="responsable">Responsable</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="estado" name="estado" required>
                                            <option value="Pendiente">Pendiente</option>
                                            <option value="En progreso">En progreso</option>
                                            <option value="Completada">Completada</option>
                                        </select>
                                        <label for="estado">Estado</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="presupuesto" name="presupuesto"
                                            placeholder="Presupuesto" required>
                                        <label for="presupuesto">Presupuesto</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-success me-2" type="submit" name="create">Crear
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
            var responsable = document.forms["activityForm"]["responsable"].value;

            // Convertir las fechas a objetos Date para comparación
            var inicio = new Date(fechaInicio);
            var final = new Date(fechaFinal);

            // Verificar que la fecha final no sea anterior a la fecha de inicio
            if (final < inicio) {
                alert("La fecha final no puede ser menor que la fecha de inicio.");
                return false;
            }

            // Verificar que el campo "responsable" contenga solo números
            if (!/^\d+$/.test(responsable)) {
                alert("El campo 'Responsable' debe contener solo números.");
                return false;
            }

            return true;
        }
    </script>

</body>

</html>