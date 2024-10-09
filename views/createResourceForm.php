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
    <title>Registrar Recurso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Registrar Recurso</h3>
                    </div>
                    <div class="card-body">
                        <form name="resourceForm" onsubmit="return validateResourceForm()" method="post"
                            action="../controllers/ResourceController.php">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="id_recurso" name="id_recurso"
                                    placeholder="ID del Recurso" required>
                                <label for="id_recurso">ID del Recurso</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                    placeholder="Nombre del Recurso" required>
                                <label for="nombre">Descripción</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="descripcion" name="descripcion"
                                    placeholder="Descripción del Recurso" required>
                                <label for="descripcion">Descripción</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="valor" name="valor"
                                    placeholder="Valor del Recurso" required>
                                <label for="valor">Valor</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="unidad_medida" name="unidad_medida"
                                    placeholder="Unidad de Medida" required>
                                <label for="unidad_medida">Unidad de Medida</label>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-success me-2" type="submit" name="create">Crear Recurso</button>
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
            var valor = document.forms["resourceForm"]["valor"].value;
            var id_recurso = document.forms["resourceForm"]["id_recurso"].value;

            // Verificar que el valor del recurso sea un número positivo
            if (isNaN(valor) || valor <= 0) {
                alert("El valor del recurso debe ser un número positivo.");
                return false;
            }

            
            // Verificar que el campo "idRecurso" contenga solo números
            if (!/^\d+$/.test(id_recurso)) {
                alert("El campo 'ID de Recurso' debe contener solo números.");
                return false;
            }

            return true;
        }
    </script>

</body>

</html>
