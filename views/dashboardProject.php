<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/loginForm.php");
    exit;
}
require '../models/updateStatus.php';  // Asegúrate de ajustar la ruta correctamente

// Consulta para obtener proyectos no cumplidos
$queryNoCumplidos = "SELECT * FROM proyectos WHERE fecha_entrega < CURDATE() AND estado != 'Completado'";
$stmtNoCumplidos = $pdo->prepare($queryNoCumplidos);
$stmtNoCumplidos->execute();
$proyectosNoCumplidos = $stmtNoCumplidos->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Gestión de Proyectos</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html">Gestión de Proyectos</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Ajustes</a></li>
                    <li><a class="dropdown-item" href="#!">Registro de actividad</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="../models/Logout.php">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Principal</div>
                        <a class="nav-link" href="../views/dashboardUser.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Usuarios
                        </a>
                        <a class="nav-link" href="../views/dashboardProject.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-project-diagram"></i></div>
                            Proyectos
                        </a>
                        <a class="nav-link" href="../views/dashboardActivity.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                            Actividades
                        </a>
                        <a class="nav-link" href="../views/dashboardTask.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tasks"></i></div>
                            Tareas
                        </a>
                        <a class="nav-link" href="../views/dashboardResource.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tools"></i></div>
                            Recursos
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <br>
                    <h1 class="mb-4 text-center fw-bold">Gestión de Proyectos</h1>
                    <!-- Aquí va tu contenido específico de dashboard -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h2 class="fw-bold h3">Proyectos</h2>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <a href="createProjectForm.php" class="btn btn-primary">Registrar Nuevo Proyecto</a>
                                <!-- Formulario para filtrar por estado -->
                                <form action="" method="GET">
                                    <div class="input-group">
                                        <select class="form-select" name="filtro_estado" onchange="this.form.submit()">
                                            <option value="">Todos los Estados</option>
                                            <option value="Pendiente" <?php echo (isset($_GET['filtro_estado']) && $_GET['filtro_estado'] == 'Pendiente') ? 'selected' : ''; ?>>Pendiente
                                            </option>
                                            <option value="En progreso" <?php echo (isset($_GET['filtro_estado']) && $_GET['filtro_estado'] == 'En progreso') ? 'selected' : ''; ?>>En progreso
                                            </option>
                                            <option value="Completado" <?php echo (isset($_GET['filtro_estado']) && $_GET['filtro_estado'] == 'Completado') ? 'selected' : ''; ?>>Completado
                                            </option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive" style="overflow: visible;">
                                <table class="table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID Proyecto</th>
                                            <th>Descripción</th>
                                            <th>Fecha de Inicio</th>
                                            <th>Fecha de Entrega</th>
                                            <th>Valor</th>
                                            <th>Lugar</th>
                                            <th>Responsable</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include '../db_conexion.php';
                                        $filtro_estado = isset($_GET['filtro_estado']) ? $_GET['filtro_estado'] : '';
                                        $query = "SELECT a.*, p.nombre AS nombre_responsable FROM proyectos a LEFT JOIN personas p ON a.responsable = p.id_persona";
                                        if (!empty($filtro_estado)) {
                                            $query .= " WHERE a.estado = :estado";
                                            $stmt = $pdo->prepare($query);
                                            $stmt->bindParam(':estado', $filtro_estado);
                                        } else {
                                            $stmt = $pdo->query($query);
                                        }
                                        $stmt->execute();
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row['id_proyecto']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['descripcion']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['fecha_inicio']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['fecha_entrega']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['valor']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['lugar']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nombre_responsable']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['estado']) . "</td>";
                                            echo "<td>
                                            <a class='btn btn-warning' href='updateProjectForm.php?id=" . $row['id_proyecto'] . "'>Actualizar</a>
                                            <a class='btn btn-primary ms-2' href='ProjectDetails.php?id=" . $row['id_proyecto'] . "'>Ver Detalles</a>
                                          </td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Proyectos No Cumplidos
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>ID Proyecto</th>
                                                    <th>Descripción</th>
                                                    <th>Fecha de Inicio</th>
                                                    <th>Fecha de Entrega</th>
                                                    <th>Valor</th>
                                                    <th>Lugar</th>
                                                    <th>Responsable</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (count($proyectosNoCumplidos) > 0): ?>
                                                    <?php foreach ($proyectosNoCumplidos as $proyecto): ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($proyecto['id_proyecto']); ?></td>
                                                            <td><?php echo htmlspecialchars($proyecto['descripcion']); ?></td>
                                                            <td><?php echo htmlspecialchars($proyecto['fecha_inicio']); ?></td>
                                                            <td><?php echo htmlspecialchars($proyecto['fecha_entrega']); ?></td>
                                                            <td><?php echo htmlspecialchars($proyecto['valor']); ?></td>
                                                            <td><?php echo htmlspecialchars($proyecto['lugar']); ?></td>
                                                            <td><?php echo htmlspecialchars($proyecto['responsable']); ?></td>
                                                            <td><?php echo htmlspecialchars($proyecto['estado']); ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="8" class="text-center">No hay proyectos no cumplidos.
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Gestión de Proyectos 2024</div>
                        <div>
                            <a href="#">Política de Privacidad</a>
                            &middot;
                            <a href="#">Términos & Condiciones</a>
                        </div>
                    </div>
            </footer>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
</body>

</html>