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
    <title>Registrar Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Registrar Tarea</h3>
                    </div>
                    <div class="card-body">
                        <form name="taskForm" method="post" action="../controllers/TaskController.php">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="id_tarea" name="id_tarea"
                                    placeholder="ID de la Tarea" required>
                                <label for="id_tarea">ID de la Tarea</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="descripcion" name="descripcion"
                                    placeholder="Descripción de la Tarea" required>
                                <label for="descripcion">Descripción</label>
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
                            <div class="form-floating mb-3">
                                <select class="form-select" id="id_actividad" name="id_actividad" required>
                                    <?php
                                    include '../db_conexion.php';  // Asegúrate de que la ruta es correcta
                                    $stmt = $pdo->query("SELECT id_actividad, descripcion FROM actividades");
                                    while ($actividad = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $actividad['id_actividad'] . "'>" . $actividad['id_actividad'] . " - " . htmlspecialchars($actividad['descripcion']) . "</option>";
                                    }
                                    ?>
                                </select>
                                <label for="id_actividad">Actividad</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="En Progreso">En Progreso</option>
                                    <option value="Completada">Completada</option>
                                </select>
                                <label for="estado">Estado</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="presupuesto" name="presupuesto"
                                    placeholder="Presupuesto" required>
                                <label for="presupuesto">Presupuesto</label>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-success me-2" type="submit" name="create">Crear Tarea</button>
                                <a class="btn btn-danger" href="../views/dashboardTask.php">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>