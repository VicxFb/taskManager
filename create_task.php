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
    <title>Crear tarea</title>
</head>

<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php"> Logo</a></p>
        </div>
        <div class="right-links">
            <a href="#">Modificar perfil</a>
            <a href="php/logout.php"> <button class="btn">Cerrar sesión</button> </a>
        </div>
    </div>

    <body>
        <div class="container">
            <div class="box form-box">
                <?php
                include("php/config.php");
                if (isset($_POST['submit'])) {
                    $task_name = $_POST['task_name'];
                    $task_description = $_POST['task_description'];
                    $task_observation = $_POST['task_observation'];
                    $task_due_date = $_POST['task_due_date'];
                    $user_id = $_SESSION['id'];
                    $task_type = $_POST['task_type'];
                    $task_status_id = 1;
                    $query = "INSERT INTO tareas (nombre_tarea, descripcion_tarea, fecharegistro_tarea, fechavencimiento_tarea, observacion_tarea, id_usuario_tarea, id_tipotarea_tarea, id_estadotarea_tarea) VALUES ('$task_name', '$task_description', current_timestamp(), '$task_due_date', '$task_observation', '$user_id', '$task_type', 1)";


                    $result = mysqli_query($con, $query);

                    if ($result) {
                        echo "<div class='message'>
                            <p>Tarea creada exitosamente</p>
                        </div>";
                        echo "<a href='home.php'><button class='btn'>Volver a inicio</button></a>";
                    } else {
                        echo "<div class='message'>
                            <p>Error al crear la tarea</p>
                        </div> <br>";
                        echo "<a href='create_task.php'><button class='btn'>Intentar de nuevo</button></a>";
                    }
                }
                ?>
                <header>Crear Tarea</header>
                <form method="post" action="">
                    <div class="field input">
                        <label for="task_name">Nombre de la Tarea:</label>
                        <input type="text" id="task_name" name="task_name" required>
                    </div>

                    <div class="field input">
                        <label for="task_description">Descripción de la Tarea:</label>
                        <textarea id="task_description" name="task_description" required></textarea>
                    </div>
                    <div class="field input">
                        <label for="task_observation">Observaciones:</label>
                        <textarea id="task_observation" name="task_observation"></textarea>
                    </div>

                    <div class="field input">
                        <label for="task_due_date">Fecha de Vencimiento:</label>
                        <input type="datetime-local" id="task_due_date" name="task_due_date" required>
                    </div>
                    <div class="field input">
                        <label for="task_type">Tipo de Tarea</label>
                        <select name="task_type" id="task_type" required>
                            <option value="">Seleccione un tipo de tarea</option>
                            <?php
                            $task_types_query = mysqli_query($con, "SELECT * FROM tipotareas");
                            while ($task_type = mysqli_fetch_assoc($task_types_query)) {
                                echo '<option value="' . $task_type['id_tipotarea'] . '">' . $task_type['nombre_tipotarea'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="field">
                        <input class="btn" type="submit" name="submit" value="Crear Tarea">
                        <a href="home.php"><button class="btn">Cancelar</button></a>
                    </div>

                </form>
            </div>

        </div>
    </body>

</html>