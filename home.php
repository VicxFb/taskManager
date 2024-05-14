<?php
session_start();
include("php/config.php");
if (!isset($_SESSION['valid'])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Home</title>
</head>

<body>
    <div class="nav">
        <div class="logo">
            <a href="home.php"><img src="assets/Logo_fondo.svg" height="100%"></a>
        </div>
        <div class="right-links">
            <a href="edit.php"><button class="btn">Modificar perfil</button></a>
            <a href="php/logout.php"><button class="btn">Cerrar sesión</button></a>
            <a href="create_task.php"><button class="btn">Crear tarea</button></a>
        </div>
    </div>
    <main>
        <div class="main-box top">
            <?php
            $user_id = $_SESSION['id'];
            $tasks_query = mysqli_query($con, "SELECT t.*, e.nombre_estadotarea, tt.nombre_tipotarea FROM tareas t JOIN estadotareas e ON t.id_estadotarea_tarea = e.id_estadotarea JOIN tipotareas tt ON t.id_tipotarea_tarea = tt.id_tipotarea WHERE t.id_usuario_tarea='$user_id'");

            if ($tasks_query) {
                if (mysqli_num_rows($tasks_query) > 0) {
                    while ($task = mysqli_fetch_assoc($tasks_query)) {
            ?>
                        <div class="task-box" id="task_<?php echo $task['id_tarea']; ?>">
                            <h3><?php echo $task['nombre_tarea']; ?></h3>
                            <p><strong>Descripción:</strong> <span id="description_<?php echo $task['id_tarea']; ?>"><?php echo $task['descripcion_tarea']; ?></span></p>
                            <p><strong>Observación:</strong> <span id="observation_<?php echo $task['id_tarea']; ?>"><?php echo $task['observacion_tarea']; ?></span></p>
                            <p><strong>Fecha de vencimiento:</strong> <span id="due_date_<?php echo $task['id_tarea']; ?>"><?php echo $task['fechavencimiento_tarea']; ?></span></p>
                            <p><strong>Estado:</strong> <span id="status_<?php echo $task['id_tarea']; ?>"><?php echo $task['nombre_estadotarea']; ?></span></p>
                            <p><strong>Tarea:</strong> <span id="type_<?php echo $task['id_tarea']; ?>"><?php echo $task['nombre_tipotarea']; ?></span></p>
                            <button class="btn" onclick="openEditModal(<?php echo $task['id_tarea']; ?>)">Editar</button>
                            <!-- Agrega este campo al formulario de edición de tarea -->
                            <div class="field input">
                                <label for="edit_task_status">Estado de la Tarea</label>
                                <select name="edit_task_status" id="edit_task_status" required>
                                    <option value="">Seleccione un estado de tarea</option>
                                    <?php
                                    $task_status_query = mysqli_query($con, "SELECT * FROM estadotareas");
                                    while ($task_status = mysqli_fetch_assoc($task_status_query)) {
                                        echo '<option value="' . $task_status['id_estadotarea'] . '">' . $task_status['nombre_estadotarea'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Agrega este botón al formulario de edición de tarea para eliminar la tarea -->
                            <button class="btn" onclick="confirmDelete(<?php echo $task['id_tarea']; ?>)">Eliminar</button>
                        </div>


            <?php
                    }
                } else {
                    echo "<p>No tienes tareas creadas.</p>";
                }
            } else {
                echo "Error al ejecutar la consulta: " . mysqli_error($con);
            }
            ?>
        </div>
        <div id="editModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeEditModal()">&times;</span>
                <h2>Editar Tarea</h2>
                <form id="editForm" method="post" action="edit_task.php">
                    <input type="hidden" id="edit_task_id" name="edit_task_id">
                    <div class="field input">
                        <label for="edit_task_name">Nombre de la Tarea:</label>
                        <input type="text" id="edit_task_name" name="edit_task_name" required>
                    </div>
                    <div class="field input">
                        <label for="edit_task_description">Descripción de la Tarea:</label>
                        <textarea id="edit_task_description" name="edit_task_description" required></textarea>
                    </div>
                    <div class="field input">
                        <label for="edit_task_observation">Observaciones:</label>
                        <textarea id="edit_task_observation" name="edit_task_observation"></textarea>
                    </div>
                    <div class="field input">
                        <label for="edit_task_due_date">Fecha de Vencimiento:</label>
                        <input type="datetime-local" id="edit_task_due_date" name="edit_task_due_date" required>
                    </div>

                    <div class="field">
                        <input class="btn" type="submit" name="submit" value="Guardar">
                        <button class="btn" onclick="closeEditModal()">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            function openEditModal(taskId) {
                document.getElementById('edit_task_id').value = taskId;
                document.getElementById('edit_task_name').value = document.getElementById('task_' + taskId).querySelector('h3').textContent;
                document.getElementById('edit_task_description').value = document.getElementById('description_' + taskId).textContent;
                document.getElementById('edit_task_observation').value = document.getElementById('observation_' + taskId).textContent;
                document.getElementById('edit_task_due_date').value = document.getElementById('due_date_' + taskId).textContent.replace(' ', 'T');
                document.getElementById('editModal').style.display = 'block';
            }

            function closeEditModal() {
                document.getElementById('editModal').style.display = 'none';
            }

            function confirmDelete(taskId) {
                if (confirm("¿Está seguro de que desea eliminar esta tarea?")) {
                    window.location.href = "edit_task.php?delete=" + taskId;
                }
            }
        </script>

    </main>
</body>

</html>