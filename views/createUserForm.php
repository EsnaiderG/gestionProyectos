<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/loginForm.php");
    exit;
}
?>

<?php require_once '../controllers/UserController.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Registrar Usuario</h3>
                    </div>
                    <div class="card-body">
                        <form name="myForm" onsubmit="return validateForm()" method="post"
                            action="../controllers/UserController.php">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="id_persona" name="id_persona" type="text"
                                            placeholder="ID de Usuario" required />
                                        <label for="id_persona">ID de Usuario</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="password" name="password" type="password"
                                            placeholder="Contraseña" required />
                                        <label for="password">Contraseña</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="nombre" name="nombre" type="text"
                                            placeholder="Nombre" required />
                                        <label for="nombre">Nombre</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="apellidos" name="apellidos" type="text"
                                            placeholder="Apellidos" required />
                                        <label for="apellidos">Apellidos</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="direccion" name="direccion" type="text"
                                    placeholder="Dirección" required />
                                <label for="direccion">Dirección</label>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="telefono" name="telefono" type="text"
                                            placeholder="Teléfono" required />
                                        <label for="telefono">Teléfono</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="sexo" name="sexo" required>
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                        </select>
                                        <label for="sexo">Sexo</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="fecha_nacimiento" name="fecha_nacimiento"
                                            type="date" placeholder="Fecha de Nacimiento" required />
                                        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="profesion" name="profesion" type="text"
                                            placeholder="Profesión" required />
                                        <label for="profesion">Profesión</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-success me-2" type="submit" name="create">Registrar</button>
                                <a class="btn btn-danger" href="../views/dashboardUser.php">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateForm() {
            var nombre = document.forms["myForm"]["nombre"].value;
            var apellidos = document.forms["myForm"]["apellidos"].value;
            var telefono = document.forms["myForm"]["telefono"].value;
            var fechaNacimiento = document.forms["myForm"]["fecha_nacimiento"].value;

            // Validar nombre y apellidos para que no contengan números
            if (/[\d]/.test(nombre) || /[\d]/.test(apellidos)) {
                alert("El nombre y los apellidos no deben contener números.");
                return false;
            }

            // Validar que el teléfono contenga sólo números
            if (!/^\d+$/.test(telefono)) {
                alert("El número de teléfono solo debe contener números.");
                return false;
            }

            // Validar el rango de edad entre 15 y 90 años
            var birthDate = new Date(fechaNacimiento);
            var today = new Date();
            var age = today.getFullYear() - birthDate.getFullYear();
            var m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            if (age < 15 || age > 90) {
                alert("La edad debe estar entre 15 y 90 años.");
                return false;
            }

            return true;
        }
    </script>

</body>

</html>