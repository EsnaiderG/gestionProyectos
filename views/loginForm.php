<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Iniciar sesión</h3>
                    </div>
                    <div class="card-body">
                        <form action="../controllers/LoginController.php" method="post">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="id_persona" name="id_persona" type="text"
                                    placeholder="ID Usuario" required />
                                <label for="id_persona">ID Usuario</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="password" name="password" type="password"
                                    placeholder="Contraseña" required />
                                <label for="password">Contraseña</label>
                            </div>
                            <div class="d-flex justify-content-center mt-4 mb-0">
                                <button class="btn btn-success me-2" type="submit">Ingresar</button>
                                <a class="btn btn-danger" href="../index.php">Cancelar</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>