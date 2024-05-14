<?php
session_start();
include("php/config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['submit'])) {
    $task_id = $_POST['edit_task_id'];
    $task_name = $_POST['edit_task_name'];
    $task_description = $_POST['edit_task_description'];
    $task_observation = $_POST['edit_task_observation'];
    $task_due_date = $_POST['edit_task_due_date'];
    $task_status = $_POST['edit_task_status'];

    $query = "UPDATE tareas SET nombre_tarea='$task_name', descripcion_tarea='$task_description', observacion_tarea='$task_observation', fechavencimiento_tarea='$task_due_date' WHERE id_tarea='$task_id'";
    $result = mysqli_query($con, $query);

    if ($result) {
        header("Location: home.php");
        exit();
    } else {
        echo "Error al actualizar la tarea: " . mysqli_error($con);
    }
} elseif (isset($_GET['delete'])) {
    $task_id = $_GET['delete'];

    $query = "DELETE FROM tareas WHERE id_tarea='$task_id'";
    $result = mysqli_query($con, $query);

    if ($result) {
        // Éxito al eliminar la tarea
        // Redireccionar a la página de inicio o mostrar un mensaje de éxito
        header("Location: home.php");
        exit();
    } else {
        // Error al eliminar la tarea
        // Mostrar un mensaje de error o redireccionar a la página de inicio
        echo "Error al eliminar la tarea: " . mysqli_error($con);
    }
} else {
    // El formulario no ha sido enviado y no se está intentando eliminar una tarea, redireccionar a la página de inicio
    header("Location: home.php");
    exit();
}

?>
