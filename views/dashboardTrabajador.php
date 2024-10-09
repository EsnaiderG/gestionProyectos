<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: loginForm.php");
    exit;
}
require_once '../db_conexion.php';

$userId = $_SESSION['user_id'];

// Obtener los proyectos del usuario
$stmtProyectos = $pdo->prepare("SELECT * FROM proyectos WHERE responsable = ?");
$stmtProyectos->execute([$userId]);
$proyectos = $stmtProyectos->fetchAll(PDO::FETCH_ASSOC);
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
                    <li><hr class="dropdown-divider" /></li>
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
                        <a class="nav-link" href="../views/dashboardTrabajador.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Trabajador
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Panel de Trabajador</h1>
                <?php if (empty($proyectos)): ?>
                    <div class="alert alert-info" role="alert">
                        No tienes proyectos asignados.
                    </div>
                <?php else: ?>
                    <?php foreach ($proyectos as $proyecto): ?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-project-diagram"></i>
                                Proyecto asignado: <?= htmlspecialchars($proyecto['descripcion']) ?>
                            </div>
                            <div class="card-body">
                            <div class="card-header">
                                <i class="fas fa-project-diagram"></i>
                                Actividades del proyecto:
                            </div>
                                <?php
                                $stmtActividades = $pdo->prepare("SELECT * FROM actividades WHERE id_proyecto = ?");
                                $stmtActividades->execute([$proyecto['id_proyecto']]);
                                $actividades = $stmtActividades->fetchAll(PDO::FETCH_ASSOC);
                                if (empty($actividades)): ?>
                                    <p>No hay actividades asignadas a este proyecto.</p>
                                <?php else: ?>
                                    <div class="accordion" id="accordionPanelsStayOpenExample">
                                        <?php foreach ($actividades as $actividad): ?>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapse<?= $actividad['id_actividad'] ?>"
                                                        aria-expanded="true" aria-controls="collapseOne">
                                                        Actividad: <?= htmlspecialchars($actividad['descripcion']) ?>
                                                    </button>
                                                </h2>
                                                <div id="collapse<?= $actividad['id_actividad'] ?>"
                                                    class="accordion-collapse collapse show"
                                                    aria-labelledby="panelsStayOpen-headingOne">
                                                    <div class="accordion-body">
                                                        <strong>Detalles de la actividad:</strong>
                                                        <?php
                                                        // Recursos y personal de la actividad
                                                        $stmtRecursosActividad = $pdo->prepare("SELECT r.nombre, ar.cantidad FROM actividadxrecurso ar JOIN recursos r ON ar.id_recurso = r.id_recurso WHERE ar.id_actividad = ?");
                                                        $stmtRecursosActividad->execute([$actividad['id_actividad']]);
                                                        $recursosActividad = $stmtRecursosActividad->fetchAll(PDO::FETCH_ASSOC);
                                                        if (!empty($recursosActividad)): ?>
                                                            <div>
                                                            <strong>Recursos:</strong>
                                                                <ul>
                                                                    <?php foreach ($recursosActividad as $recurso): ?>
                                                                        <li><?= htmlspecialchars($recurso['nombre']) . ": " . htmlspecialchars($recurso['cantidad']) ?></li>
                                                                    <?php endforeach; ?>
                                                                </ul>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php
                                                        // Mostrar tareas de la actividad
                                                        $stmtTareas = $pdo->prepare("SELECT * FROM tareas WHERE id_actividad = ?");
                                                        $stmtTareas->execute([$actividad['id_actividad']]);
                                                        $tareas = $stmtTareas->fetchAll(PDO::FETCH_ASSOC);
                                                        if (!empty($tareas)): ?>
                                                            <ul>
                                                            <strong>Tareas asignadas:</strong>
                                                                <?php foreach ($tareas as $tarea): ?>
                                                                    <li>Tarea: <?= htmlspecialchars($tarea['descripcion']) ?>
                                                                        <?php
                                                                        // Recursos de la tarea
                                                                        $stmtRecursosTarea = $pdo->prepare("SELECT r.nombre, tr.cantidad FROM tareaxrecurso tr JOIN recursos r ON tr.id_recurso = r.id_recurso WHERE tr.id_tarea = ?");
                                                                        $stmtRecursosTarea->execute([$tarea['id_tarea']]);
                                                                        $recursosTarea = $stmtRecursosTarea->fetchAll(PDO::FETCH_ASSOC);
                                                                        if (!empty($recursosTarea)): ?>
                                                                            <div>
                                                                            <strong>Recursos de la Tarea:</strong>
                                                                                <ul>
                                                                                    <?php foreach ($recursosTarea as $recursoTarea): ?>
                                                                                        <li><?= htmlspecialchars($recursoTarea['nombre']) . ": " . htmlspecialchars($recursoTarea['cantidad']) ?></li>
                                                                                    <?php endforeach; ?>
                                                                                </ul>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        <?php else: ?>
                                                            <p>No hay tareas asignadas a esta actividad.</p>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
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
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
</body>
</html>
