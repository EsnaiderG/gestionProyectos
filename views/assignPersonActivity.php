<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/loginForm.php");
    exit;
}

require_once '../db_conexion.php';  // Asegúrate de ajustar la ruta correctamente
$idActividad = $_GET['id'];

// Intenta realizar la consulta para obtener personal disponible
try {
    $personal = $pdo->query("SELECT id_persona, nombre FROM personas");
} catch (PDOException $e) {
    die("ERROR: No se pudo ejecutar la consulta: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Personal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Asignar Personal a una Actividad</h3>
                    </div>
                    <div class="card-body">
                        <form action="../controllers/AssignPersonActivity.php" method="post">
                            <input type="hidden" name="idActividad" value="<?php echo $idActividad; ?>">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="persona" name="idPersona" required>
                                    <?php while ($row = $personal->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row['id_persona'] . "'>" . $row['nombre'] . "</option>";
                                    } ?>
                                </select>
                                <label for="persona">Personal:</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="duracion" name="duracion" placeholder="Duración" required>
                                <label for="duracion">Duración:</label>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-success me-2" type="submit">Asignar Personal</button>
                                <a class="btn btn-danger" href="../views/dashboardActivity.php">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
