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
    <title>Registrar Proyecto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Registrar Proyecto</h3>
                    </div>
                    <div class="card-body">
                        <form name="projectForm" onsubmit="return validateProjectForm()" method="post"
                            action="../controllers/ProjectController.php">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="id_proyecto" name="id_proyecto" type="text"
                                            placeholder="ID del Proyecto" required />
                                        <label for="id_proyecto">ID del Proyecto</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="descripcion" name="descripcion" type="text"
                                            placeholder="Descripción del proyecto" required />
                                        <label for="descripcion">Descripción</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="fecha_inicio" name="fecha_inicio" type="date"
                                            placeholder="Fecha de Inicio" required />
                                        <label for="fecha_inicio">Fecha de Inicio</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="fecha_entrega" name="fecha_entrega" type="date"
                                            placeholder="Fecha de Entrega" required />
                                        <label for="fecha_entrega">Fecha de Entrega</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="valor" name="valor" type="number"
                                            placeholder="Valor del proyecto" required />
                                        <label for="valor">Valor</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="lugar" name="lugar" type="text"
                                            placeholder="Lugar del proyecto" required />
                                        <label for="lugar">Lugar</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="responsable" name="responsable" required>
                                            <?php
                                            include '../db_conexion.php';
                                            $stmt = $pdo->query("SELECT id_persona, nombre FROM personas");
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                echo "<option value='" . $row['id_persona'] . "'>" . $row['id_persona'] . " - " . htmlspecialchars($row['nombre']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="responsable">Responsable</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="estado" name="estado" required>
                                            <option value="Pendiente">Pendiente</option>
                                            <option value="En progreso">En progreso</option>
                                            <option value="Completado">Completado</option>
                                        </select>
                                        <label for="estado">Estado</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-success me-2" type="submit" name="create">Crear Proyecto</button>
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
            return true;
        }
    </script>

</body>

</html>