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
    <title>Gestión de Proyectos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-4">
        <h1 class="mb-4 text-center fw-bold">Gestión de Proyectos</h1>


         <!-- Panel de Acciones Rápidas -->
         <div class="card mb-4">
            <div class="card-header">
                <h2 class="fw-bold h3">Acciones Rápidas</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <button class="btn btn-info w-100" onclick="location.href='asignarRecursos.html'">Asignar Recursos y Personal</button>
                    </div>
                    <div class="col-md-4 mb-3">
                        <button class="btn btn-warning w-100" onclick="location.href='verificarProyectos.html'">Verificar Estado de Proyectos</button>
                    </div>
                    <div class="col-md-4 mb-3">
                        <button class="btn btn-success w-100" onclick="location.href='gestionarTareas.html'">Gestionar Tareas</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sección de Usuarios -->
        <div class="card mb-3">
            <div class="card-header">
                <h2 class="fw-bold h3">Usuarios</h2>
            </div>
            <div class="card-body">
                <a href="createUserForm.php" class="btn btn-primary mb-3">Registrar Nuevo Usuario</a>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Sexo</th>
                                <th>Fecha de Nacimiento</th>
                                <th>Profesión</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include '../db_conexion.php';
                            $stmt = $pdo->query("SELECT * FROM personas");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['id_persona']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['apellidos']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['direccion']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['telefono']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['sexo']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['fecha_nacimiento']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['profesion']) . "</td>";
                                echo "<td><a href='updateUserForm.php?id=" . $row['id_persona'] . "'>Actualizar</a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sección de Proyectos -->
        <div class="card mb-3">
            <div class="card-header">
                <h2 class="fw-bold h3">Proyectos</h2>
            </div>
            <div class="card-body">
                <a href="createProjectForm.php" class="btn btn-primary mb-3">Registrar Nuevo Proyecto</a>
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
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            include '../db_conexion.php';
                            $stmt = $pdo->query("SELECT * FROM proyectos");
                            $stmt = $pdo->query("SELECT a.*, p.nombre AS nombre_responsable FROM proyectos a LEFT JOIN personas p ON a.responsable = p.id_persona");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['id_proyecto']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['descripcion']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['fecha_inicio']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['fecha_entrega']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['valor']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['lugar']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nombre_responsable']) . "</td>"; // Mostrar nombre del responsable
                                echo "<td>" . htmlspecialchars($row['estado']) . "</td>";
                                echo "<td><a href='updateProjectForm.php?id=" . $row['id_proyecto'] . "'>Actualizar</a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sección de Actividades -->
        <div class="card mb-3">
            <div class="card-header">
                <h2 class="fw-bold h3">Actividades</h2>
            </div>
            <div class="card-body">
                <a href="createActivityForm.php" class="btn btn-primary mb-3">Registrar Nueva Actividad</a>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>ID Actividad</th>
                                <th>Descripción</th>
                                <th>Fecha de Inicio</th>
                                <th>Fecha Final</th>
                                <th>ID Proyecto</th>
                                <th>Responsable</th>
                                <th>Estado</th>
                                <th>Presupuesto</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include '../db_conexion.php';
                            $stmt = $pdo->query("SELECT * FROM actividades");
                            $stmt = $pdo->query("SELECT a.*, p.nombre AS nombre_responsable FROM actividades a LEFT JOIN personas p ON a.responsable = p.id_persona");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['id_actividad']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['descripcion']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['fecha_inicio']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['fecha_final']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['id_proyecto']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nombre_responsable']) . "</td>"; // Mostrar nombre del responsable
                                echo "<td>" . htmlspecialchars($row['estado']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['presupuesto']) . "</td>";
                                echo "<td><a href='updateActivityForm.php?id=" . $row['id_actividad'] . "'>Actualizar</a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sección de Tareas -->
        <div class="card">
            <div class="card-header">
                <h2 class="fw-bold h3">Tareas</h2>
            </div>
            <div class="card-body">
                <a href="createTaskForm.php" class="btn btn-primary mb-3">Registrar Nueva Tarea</a>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>ID Tarea</th>
                                <th>Descripción</th>
                                <th>Fecha de Inicio</th>
                                <th>Fecha Final</th>
                                <th>ID Actividad</th>
                                <th>Estado</th>
                                <th>Presupuesto</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $pdo->query("SELECT * FROM tareas");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['id_tarea']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['descripcion']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['fecha_inicio']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['fecha_final']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['id_actividad']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['estado']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['presupuesto']) . "</td>";
                                echo "<td><a href='updateTaskForm.php?id=" . $row['id_tarea'] . "'>Actualizar</a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</body>

</html>