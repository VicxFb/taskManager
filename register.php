<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Register</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <?php
            include("php/config.php");
            if (isset($_POST['submit'])) {
                $username = $_POST['username'];
                $email = $_POST['email'];
                $celular = $_POST['celular'];
                $age = $_POST['age'];
                $password = $_POST['password'];

                // Generar un id_usuario único
                $id_usuario = uniqid();
                $verify_query = mysqli_query($con, "SELECT email_usuario FROM usuarios WHERE email_usuario='$email'");

                if (mysqli_num_rows($verify_query) != 0) {
                    echo "<div class='message'>
                      <p>Este email está usado, ¡Intente con otro por favor!</p>
                  </div> <br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Volver atrás</button>";
                } else {
                    mysqli_query($con, "INSERT INTO usuarios(id_usuario, nombre_usuario, email_usuario, celular_usuario, edad_usuario, password_usuario) VALUES('$id_usuario', '$username', '$email', '$celular', '$age', '$password')") or die("Error Occurred");

                    echo "<div class='message'>
                      <p>Registro realizado con éxito!</p>
                  </div> <br>";
                    echo "<a href='index.php'><button class='btn'>Iniciar sesión ahora</button>";
                }
            } else {
            ?>
                <header>Registro</header>
                <form action="" method="post">
                    <div class="field input">
                        <label for="username">Nombre de usuario</label>
                        <input type="text" name="username" id="username" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="email">Correo electronico</label>
                        <input type="text" name="email" id="email" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="celular">Celular</label>
                        <input type="text" name="celular" id="celular" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="age">Edad</label>
                        <input type="number" name="age" id="age" autocomplete="off" required>
                    </div>
                    <div class="field input">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" id="password" autocomplete="off" required>
                    </div>

                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Registrarse" required>
                    </div>
                    <div class="links">
                        Estas registrado? <a href="index.php">Iniciar sesión</a>
                    </div>
                </form>
        </div>
    <?php } ?>
    </div>
</body>

</html>
