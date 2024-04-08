<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Inicio</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <?php
            include("php/config.php");
            if (isset($_POST['submit'])) {
                $email = mysqli_real_escape_string($con, $_POST['email']);
                $password = mysqli_real_escape_string($con, $_POST['password']);

                $result = mysqli_query($con, "SELECT * FROM usuarios WHERE email_usuario='$email' AND password_usuario='$password' ") or die("Select Error");
                $row = mysqli_fetch_assoc($result);

                if (is_array($row) && !empty($row)) {
                    $_SESSION['valid'] = $row['email_usuario'];
                    $_SESSION['username'] = $row['nombre_usuario'];
                    $_SESSION['age'] = $row['Age'];
                    $_SESSION['id'] = $row['id_usuario'];
                } else {
                    echo "<div class='message'>
                      <p>Usuario o contraseña incorrectos</p>
                       </div> <br>";
                    echo "<a href='index.php'><button class='btn'>Regresar</button>";
                }
                if (isset($_SESSION['valid'])) {
                    header("Location: home.php");
                }
            } else {

            ?>
                <div class="imagen">
                    <img src="assets/logo.svg" alt="Imagen de inicio de sesión">
                </div>
                <header>Inicio de sesión</header>
                <form action="" method="post">
                    <div class="field input">
                        <label for="email">Correo electronico</label>
                        <input type="text" name="email" id="email" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" id="password" autocomplete="off" required>
                    </div>
                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Iniciar sesión" required>
                    </div>
                    <div class="links">
                        No tienes cuenta? <a href="register.php">Registrarse</a>
                    </div>
                </form>
        </div>
    <?php } ?>
    </div>
</body>

</html>