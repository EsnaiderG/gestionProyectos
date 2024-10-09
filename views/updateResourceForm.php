<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/loginForm.php");
    exit;
}
require_once '../db_conexion.php';

$id_recurso = isset($_GET['id']) ? $_GET['id'] : 0;  // Obtener el ID del recurso desde la URL.

// Consulta para obtener los datos del recurso
$sql = "SELECT * FROM recursos WHERE id_recurso = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_recurso]);
$resource = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$resource) {
    echo "Recurso no encontrado";
    exit;  // Si no se encuentra el recurso, termina la ejecución.
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Actualizar Recurso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Actualizar Recurso</h3>
                    </div>
                    <div class="card-body">
                        <form name="updateResourceForm" onsubmit="return validateResourceForm()" method="post"
                            action="../controllers/ResourceController.php">
                            <input type="hidden" id="id_recurso" name="id_recurso"
                                value="<?php echo htmlspecialchars($resource['id_recurso']); ?>">

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                    value="<?php echo htmlspecialchars($resource['nombre']); ?>" placeholder="Nombre"
                                    required>
                                <label for="descripcion">Nombre</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="descripcion" name="descripcion"
                                    value="<?php echo htmlspecialchars($resource['descripcion']); ?>"
                                    placeholder="Descripción" required>
                                <label for="descripcion">Descripción</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="valor" name="valor"
                                    value="<?php echo htmlspecialchars($resource['valor']); ?>" placeholder="Valor"
                                    required>
                                <label for="valor">Valor</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="unidad_medida" name="unidad_medida"
                                    value="<?php echo htmlspecialchars($resource['unidad_medida']); ?>"
                                    placeholder="Unidad de Medida" required>
                                <label for="unidad_medida">Unidad de Medida</label>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-warning me-2" type="submit" name="update">Actualizar
                                    Recurso</button>
                                <a class="btn btn-danger" href="../views/dashboardResource.php">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateResourceForm() {
            var valor = document.forms["updateResourceForm"]["valor"].value;

            // Verificar que el valor del recurso sea un número positivo
            if (isNaN(valor) || valor <= 0) {
                alert("El valor del recurso debe ser un número positivo.");
                return false;
            }

            return true;
        }
    </script>
</body>

</html>