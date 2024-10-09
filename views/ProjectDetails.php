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
    <title>Detalles del Proyecto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .header-area {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e3e6f0;
        }

        .card-header {
            background-color: #007bff;
            color: white;
        }

        .list-group-item {
            border: none;
        }

        .list-group-item:nth-of-type(odd) {
            background-color: #f8f9fa;
        }

        .detail-title {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Detalles del Proyecto</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        require_once '../db_conexion.php';
                        $idProyecto = $_GET['id'];
                        try {
                            // Información del proyecto
                            echo "<h4 class='mt-4 fw-bold'>Información</h4>";
                            $stmt = $pdo->prepare("SELECT * FROM proyectos WHERE id_proyecto = ?");
                            $stmt->execute([$idProyecto]);
                            $proyecto = $stmt->fetch(PDO::FETCH_ASSOC);
                            $totalGastado = 0;

                            if (!$proyecto) {
                                echo "<p class='text-center'>Proyecto no encontrado.</p>";
                            } else {
                                echo "<ul class='list-group list-group-flush'>";
                                echo "<li class='list-group-item'><span class='detail-title'>ID de Proyecto:</span> " . htmlspecialchars($proyecto['id_proyecto']) . "</li>";
                                echo "<li class='list-group-item'><span class='detail-title'>Descripción:</span> " . htmlspecialchars($proyecto['descripcion']) . "</li>";
                                echo "<li class='list-group-item'><span class='detail-title'>Fecha de Inicio:</span> " . htmlspecialchars($proyecto['fecha_inicio']) . "</li>";
                                echo "<li class='list-group-item'><span class='detail-title'>Fecha de Entrega:</span> " . htmlspecialchars($proyecto['fecha_entrega']) . "</li>";
                                echo "<li class='list-group-item'><span class='detail-title'>Valor:</span> $" . number_format($proyecto['valor'], 2) . " COP</li>";
                                echo "<li class='list-group-item'><span class='detail-title'>Lugar:</span> " . htmlspecialchars($proyecto['lugar']) . "</li>";
                                echo "<li class='list-group-item'><span class='detail-title'>Responsable:</span> " . htmlspecialchars($proyecto['responsable']) . "</li>";
                                echo "<li class='list-group-item'><span class='detail-title'>Estado:</span> " . htmlspecialchars($proyecto['estado']) . "</li>";
                                echo "</ul>";

                                // Recursos asignados de actividades y tareas
                                echo "<h4 class='mt-4 fw-bold'>Recursos Asignados</h4>";
                                $queryRecursos = "SELECT r.nombre, ar.cantidad, r.valor, (r.valor * ar.cantidad) AS total_costo FROM recursos r JOIN (SELECT id_recurso, cantidad FROM ActividadxRecurso WHERE id_actividad IN (SELECT id_actividad FROM actividades WHERE id_proyecto = ?) UNION ALL SELECT id_recurso, cantidad FROM TareaxRecurso WHERE id_tarea IN (SELECT id_tarea FROM tareas WHERE id_actividad IN (SELECT id_actividad FROM actividades WHERE id_proyecto = ?))) ar ON r.id_recurso = ar.id_recurso";
                                $stmtRecursos = $pdo->prepare($queryRecursos);
                                $stmtRecursos->execute([$idProyecto, $idProyecto]);
                                $recursos = $stmtRecursos->fetchAll(PDO::FETCH_ASSOC);

                                if ($recursos) {
                                    echo "<ul class='list-group'>";
                                    foreach ($recursos as $recurso) {
                                        echo "<li class='list-group-item'>" . htmlspecialchars($recurso['nombre']) . " - Cantidad: " . htmlspecialchars($recurso['cantidad']) . ", <span style='margin-left: 10px;'><strong>Valor unitario:</strong> $" . number_format($recurso['valor'], 2) . "</span>, <span style='margin-left: 10px;'><strong>Total gastado:</strong> $" . number_format($recurso['total_costo'], 2) . "</span></li>";
                                    }
                                    echo "</ul>";
                                } else {
                                    echo "<p>No hay recursos asignados.</p>";
                                }

                                // Personal asignado de actividades y tareas
                                echo "<h4 class='mt-4 fw-bold'>Personal Asignado</h4>";
                                $queryPersonal = "SELECT p.nombre, ap.duracion FROM personas p JOIN (SELECT id_persona, duracion FROM ActividadxPersona WHERE id_actividad IN (SELECT id_actividad FROM actividades WHERE id_proyecto = ?) UNION ALL SELECT id_persona, duracion FROM TareaxPersona WHERE id_tarea IN (SELECT id_tarea FROM tareas WHERE id_actividad IN (SELECT id_actividad FROM actividades WHERE id_proyecto = ?))) ap ON p.id_persona = ap.id_persona";
                                $stmtPersonal = $pdo->prepare($queryPersonal);
                                $stmtPersonal->execute([$idProyecto, $idProyecto]);
                                $personal = $stmtPersonal->fetchAll(PDO::FETCH_ASSOC);
                                if ($personal) {
                                    echo "<ul class='list-group'>";
                                    foreach ($personal as $persona) {
                                        echo "<li class='list-group-item'>" . htmlspecialchars($persona['nombre']) . " - Duración: " . htmlspecialchars($persona['duracion']) . " días</li>";
                                    }
                                    echo "</ul>";
                                } else {
                                    echo "<p>No hay personal asignado.</p>";
                                }

                                // Calcular el presupuesto total del proyecto basado en las actividades
                                $stmtPresupuesto = $pdo->prepare("SELECT SUM(presupuesto) AS presupuesto_total FROM actividades WHERE id_proyecto = ?");
                                $stmtPresupuesto->execute([$idProyecto]);
                                $presupuesto = $stmtPresupuesto->fetch(PDO::FETCH_ASSOC);
                                $presupuestoTotal = $presupuesto['presupuesto_total'];

                                echo "<h4 class='mt-4 fw-bold'>Presupuesto del Proyecto</h4>";
                                echo "<p>Total de presupuesto de actividades: $" . number_format($presupuestoTotal, 2) . " COP</p>";

                                // Calcular gastos de recursos
                                $queryGastos = "SELECT SUM(r.valor * ar.cantidad) AS total_gastado FROM recursos r JOIN (SELECT id_recurso, cantidad FROM ActividadxRecurso WHERE id_actividad IN (SELECT id_actividad FROM actividades WHERE id_proyecto = ?) UNION ALL SELECT id_recurso, cantidad FROM TareaxRecurso WHERE id_tarea IN (SELECT id_tarea FROM tareas WHERE id_actividad IN (SELECT id_actividad FROM actividades WHERE id_proyecto = ?))) ar ON r.id_recurso = ar.id_recurso";
                                $stmtGastos = $pdo->prepare($queryGastos);
                                $stmtGastos->execute([$idProyecto, $idProyecto]);
                                $gastos = $stmtGastos->fetch(PDO::FETCH_ASSOC);
                                $totalGastado = $gastos['total_gastado'];

                                echo "<h4 class='mt-4 fw-bold'>Gastos en Recursos</h4>";
                                echo "<p>Total gastado en recursos: $" . number_format($totalGastado, 2) . " COP</p>";

                                // Calcular ganancias
                                $ganancias = $proyecto['valor'] - $totalGastado;
                                echo "<h4 class='mt-4 fw-bold'>Ganancias del Proyecto</h4>";
                                echo "<p>Ganancias: $" . number_format($ganancias, 2)  .  " COP</p>";
                            }
                        } catch (PDOException $e) {
                            echo "<p class='text-center'>ERROR: " . $e->getMessage() . "</p>";
                        }
                        ?>
                    </div>
                    <div class="card-footer text-center">
                        <a class="btn btn-danger" href="../views/dashboardProject.php">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>