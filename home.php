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
            <a href="edit.php"> <button class="btn">Modificar perfil</button> </a>
            <a href="php/logout.php"> <button class="btn">Cerrar sesión</button> </a>
            <a href="create_task.php"> <button>Crear tarea</button></a>
        </div>
    </div>
    <main>
        <div class="main-box top">
            <?php
            $user_id = $_SESSION['id'];
            $tasks_query = mysqli_query($con, "SELECT * FROM tareas WHERE id_usuario_tarea='$user_id'");
            if (mysqli_num_rows($tasks_query) > 0) {
                while ($task = mysqli_fetch_assoc($tasks_query)) {
            ?>
                    <div class="task-box">
                        <h3><?php echo $task['nombre_tarea']; ?></h3>
                        <p><strong>Descripción:</strong> <?php echo $task['descripcion_tarea']; ?></p>
                        <p><strong>Fecha de vencimiento:</strong> <?php echo $task['fechavencimiento_tarea']; ?></p>
                        <p><strong>Estado:</strong> <?php echo $task['id_estadotarea_tarea']; ?></p>
                    </div>
            <?php
                }
            } else {
                echo "<p>No tienes tareas creadas.</p>";
            }
            ?>
        </div>
    </main>
</body>

</html>