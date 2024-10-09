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
    <title>Detalles de la Tarea</title>
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
                        <h3 class="text-center font-weight-light my-4"> Detalles de la Tarea</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        require_once '../db_conexion.php';
                        $idTarea = $_GET['id'];

                        try {
                            echo "<h4 class='mt-4 fw-bold'>Información de la Tarea</h4>";
                            $stmt = $pdo->prepare("SELECT * FROM tareas WHERE id_tarea = ?");
                            $stmt->execute([$idTarea]);
                            $tarea = $stmt->fetch(PDO::FETCH_ASSOC);

                            if (!$tarea) {
                                echo "<p class='text-center'>Tarea no encontrada.</p>";
                            } else {
                                echo "<ul class='list-group list-group-flush'>";
                                echo "<li class='list-group-item'><span class='detail-title'>ID de Tarea:</span> " . htmlspecialchars($tarea['id_tarea']) . "</li>";
                                echo "<li class='list-group-item'><span class='detail-title'>Descripción:</span> " . htmlspecialchars($tarea['descripcion']) . "</li>";
                                echo "<li class='list-group-item'><span class='detail-title'>Fecha de Inicio:</span> " . htmlspecialchars($tarea['fecha_inicio']) . "</li>";
                                echo "<li class='list-group-item'><span class='detail-title'>Fecha Final:</span> " . htmlspecialchars($tarea['fecha_final']) . "</li>";
                                echo "<li class='list-group-item'><span class='detail-title'>Estado:</span> " . htmlspecialchars($tarea['estado']) . "</li>";

                                // Recursos asignados a la tarea
                                echo "<h4 class='mt-4 fw-bold'>Recursos Asignados</h4>";
                                $stmtRecursos = $pdo->prepare("SELECT r.nombre, tr.cantidad FROM TareaxRecurso tr JOIN recursos r ON tr.id_recurso = r.id_recurso WHERE tr.id_tarea = ?");
                                $stmtRecursos->execute([$idTarea]);
                                $recursos = $stmtRecursos->fetchAll(PDO::FETCH_ASSOC);
                                if ($recursos) {
                                    echo "<ul class='list-group'>";
                                    foreach ($recursos as $recurso) {
                                        echo "<li class='list-group-item'>" . htmlspecialchars($recurso['nombre']) . " - Cantidad: " . htmlspecialchars($recurso['cantidad']) . "</li>";
                                    }
                                    echo "</ul>";
                                } else {
                                    echo "<p>No hay recursos asignados.</p>";
                                }

                                // Personal asignado a la tarea
                                echo "<h4 class='mt-4 fw-bold'>Personal Asignado</h4>";
                                $stmtPersonal = $pdo->prepare("SELECT p.nombre, tp.duracion FROM TareaxPersona tp JOIN personas p ON tp.id_persona = p.id_persona WHERE tp.id_tarea = ?");
                                $stmtPersonal->execute([$idTarea]);
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
                            }
                        } catch (PDOException $e) {
                            echo "<p class='text-center'>ERROR: " . $e->getMessage() . "</p>";
                        }
                        ?>
                    </div>
                    <div class="card-footer text-center">
                        <a class="btn btn-danger" href="../views/dashboardTask.php">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>