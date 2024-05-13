<?php
include("php/config.php");

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $celular = $_POST['celular'];
    $age = $_POST['age'];
    $password = $_POST['password'];
    $id_municipio = $_POST['id_municipio'];

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

                    <div class="field">
                        <label for="departamento">Departamento</label>
                        <select name="departamento" id="departamento" required>
                            <option value="">Seleccione un departamento</option>
                            <?php
                            $departamentos_query = mysqli_query($con, "SELECT * FROM departamentos");
                            while ($departamento = mysqli_fetch_assoc($departamentos_query)) {
                                echo '<option value="' . $departamento['id_departamento'] . '">' . $departamento['nombre_departamento'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="field">
                        <label for="municipio">Municipio</label>
                        <select name="id_municipio" id="municipio" required>
                            <option value="">Seleccione un municipio</option>
                            <?php
                            $municipios_query = mysqli_query($con, "SELECT * FROM municipios");
                            while ($municipio = mysqli_fetch_assoc($municipios_query)) {
                                echo '<option value="' . $municipio['id_municipio'] . '" data-departamento="' . $municipio['id_departamento_municipio'] . '">' . $municipio['nombre_municipio'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var municipios = document.querySelectorAll('#municipio option');
                            var departamento = document.getElementById('departamento');

                            departamento.addEventListener('change', function() {
                                var selectedDepartamento = this.value;
                                municipios.forEach(function(municipio) {
                                    if (municipio.getAttribute('data-departamento') === selectedDepartamento || selectedDepartamento === '') {
                                        municipio.style.display = 'block';
                                    } else {
                                        municipio.style.display = 'none';
                                    }
                                });
                            });

                            // Limpiar el valor seleccionado del departamento y municipio después de recargar la página
                            departamento.value = '';
                            municipios.forEach(function(municipio) {
                                municipio.style.display = 'none';
                            });
                        });
                    </script>

                    <div class="field input">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" id="password" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="password2">Verificar Contraseña</label>
                        <input type="password" name="password2" id="password2" autocomplete="off" required>
                        <div id="password-error"></div>
                    </div>

                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Registrarse" required>
                    </div>
                    <div class="links">
                        Estas registrado? <a href="index.php">Iniciar sesión</a>
                    </div>
                </form>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $('#password, #password2').on('keyup', function() {
                if ($('#password').val() == $('#password2').val()) {
                    $('#password-error').html('');
                } else {
                    $('#password-error').html('Las contraseñas no coinciden');
                }
            });
        </script>
    </body>
    </html>
<?php } ?>
