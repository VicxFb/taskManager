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
    <title>Modificar perfil</title>
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
    <div class="container">
        <div class="box form-box">
            <?php
            if (isset($_POST['submit'])) {
                // Obtener los datos del formulario
                $username = $_POST['username'];
                $email = $_POST['email'];
                $celular = $_POST['celular'];
                $age = $_POST['age'];
                $id = $_SESSION['id'];

                // Subir imagen
                $photo = $_FILES['photo']['name'];
                $photo_temp = $_FILES['photo']['tmp_name'];
                $folder = 'Imagenes/' . $photo;

                // Si no se ha subido una imagen, usar la foto predeterminada
                if (empty($photo)) {
                    $photo = 'default.jpg'; // Nombre de la foto predeterminada
                    $folder = 'assets/' . $photo;
                }

                // Actualizar datos en la base de datos
                $edit_query = mysqli_query($con, "UPDATE usuarios SET nombre_usuario='$username', email_usuario='$email', celular_usuario='$celular', edad_usuario='$age', foto_usuario='$photo' WHERE id_usuario='$id'") or die("Error al actualizar");

                // Mover la foto a la carpeta de imágenes
                if (move_uploaded_file($photo_temp, $folder)) {
                    echo "<h2>Archivo subido con éxito </h2>";
                } else {
                    echo "<h2>Archivo no se logró subir</h2>";
                }

                if ($edit_query) {
                    echo "<div class='message'>
                    <p>Perfil actualizado</p>
                </div> <br>";
                    echo "<a href='home.php'><button class='btn'>Volver a inicio</button>";
                }
            } else {
                // Obtener datos del usuario
                $id = $_SESSION['id'];
                $query = mysqli_query($con, "SELECT * FROM usuarios WHERE id_usuario='$id' ");

                while ($result = mysqli_fetch_assoc($query)) {
                    $res_Uname = $result['nombre_usuario'];
                    $res_Email = $result['email_usuario'];
                    $res_Celular = $result['celular_usuario'];
                    $res_Age = $result['edad_usuario'];
                    $res_Photo = $result['foto_usuario'];
                }

                // Mostrar la foto predeterminada si el usuario no tiene una
                if (empty($res_Photo)) {
                    $res_Photo = 'default.jpg'; // Nombre de la foto predeterminada
                }
            ?>
                <div class="perfil">
                    <img src="Imagenes/<?php echo $res_Photo ?>" />
                </div>
                <header>Modificar perfil</header>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="field input">
                        <label for="username">Nombre de usuario</label>
                        <input type="text" name="username" id="username" value="<?php echo $res_Uname; ?>" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="email">Correo electrónico</label>
                        <input type="text" name="email" id="email" value="<?php echo $res_Email; ?>" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="celular">Celular</label>
                        <input type="text" name="celular" id="celular" value="<?php echo $res_Celular; ?>" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="age">Edad</label>
                        <input type="number" name="age" id="age" value="<?php echo $res_Age; ?>" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="photo">Foto de perfil</label>
                        <input type="file" name="photo" id="photo">
                    </div>

                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Actualizar" required>
                    </div>
                </form>
        </div>
    <?php } ?>
    </div>
</body>
</html>
