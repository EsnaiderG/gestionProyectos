<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/loginForm.php");
    exit;
}

require_once '../db_conexion.php';  // Asegúrate de ajustar la ruta correctamente
$idTarea = $_GET['id'];

// Consulta para obtener recursos disponibles
try {
    $recursos = $pdo->query("SELECT id_recurso, nombre FROM recursos");
} catch (PDOException $e) {
    die("ERROR: No se pudo ejecutar la consulta: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Recursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Asignar Recurso a una Tarea</h3>
                    </div>
                    <div class="card-body">
                        <form action="../controllers/AssignResourceTask.php" method="post">
                            <input type="hidden" name="idTarea" value="<?php echo $idTarea; ?>">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="recurso" name="idRecurso" required>
                                    <?php while ($row = $recursos->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row['id_recurso'] . "'>" . $row['nombre'] . "</option>";
                                    } ?>
                                </select>
                                <label for="recurso">Recurso:</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="Cantidad" min="1" required>
                                <label for="cantidad">Cantidad:</label>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-success me-2" type="submit">Asignar Recurso</button>
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