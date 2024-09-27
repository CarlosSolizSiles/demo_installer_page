<?php
session_start();
// Configuración de la base de datos
include "./lib/conn.php"; // Asegúrate de que esta conexión usa `mysqli`

// Verificar si el usuario ya está autenticado
if (isset($_SESSION['usuario_id'])) {
    if (isset($_POST['nueva_usuario']) && isset($_POST['nueva_password']) && isset($_POST['confirmar_password'])) {
        $nuevaUsuario = $_POST['nueva_usuario'];
        $nuevaPassword = $_POST['nueva_password'];
        $confirmarPassword = $_POST['confirmar_password'];

        // Verificar que la nueva contraseña y la confirmación coincidan
        if ($nuevaPassword === $confirmarPassword) {
            // Encriptar la nueva contraseña
            $nuevaPasswordHashed = password_hash($nuevaPassword, PASSWORD_BCRYPT);

            // Actualizar los datos del usuario en la base de datos
            $stmt = $conn->prepare("UPDATE usuarios SET username = ?, pass = ? WHERE id = ?");
            $stmt->bind_param("ssi", $nuevaUsuario, $nuevaPasswordHashed, $_SESSION['usuario_id']);
            $stmt->execute();

            // Actualizar el usuario de MySQL con los nuevos datos
            $nuevaPasswordMySQL = mysqli_real_escape_string($conn, $nuevaPassword); // Escapar la contraseña para MySQL
            $sqlCreateUser = "CREATE USER '$nuevaUsuario'@'%' IDENTIFIED BY '$nuevaPasswordMySQL';
                GRANT ALL PRIVILEGES ON *.* TO '$nuevaUsuario'@'%' REQUIRE NONE WITH GRANT OPTION;
                REVOKE GRANT OPTION ON *.* FROM '$nuevaUsuario'@'%';
                GRANT SELECT, INSERT, UPDATE, DELETE, FILE ON *.* TO '$nuevaUsuario'@'%' REQUIRE NONE;";
            
            if ($conn->multi_query($sqlCreateUser)) {
                do {
                    // Limpia resultados anteriores
                    if ($result = $conn->store_result()) {
                        $result->free();
                    }
                } while ($conn->next_result());
            } else {
                echo "<p style='color: red;'>Error al actualizar los privilegios de MySQL: " . $conn->error . "</p>";
            }

            // Redirigir al finalizar el proceso
            header("Location: terminarPaso.php");
            exit;
        } else {
            echo "<p style='color: red;'>Las contraseñas no coinciden. Inténtalo de nuevo.</p>";
        }
    }
?>
    <h2>Cambiar Nombre de Usuario y Contraseña</h2>
    <form method="post">
        <label for="nueva_usuario">Nuevo Nombre de Usuario:</label>
        <input type="text" name="nueva_usuario" id="nueva_usuario" required>
        <br>
        <label for="nueva_password">Nueva Contraseña:</label>
        <input type="password" name="nueva_password" id="nueva_password" required>
        <br>
        <label for="confirmar_password">Confirmar Contraseña:</label>
        <input type="password" name="confirmar_password" id="confirmar_password" required>
        <br>
        <button type="submit">Guardar Cambios</button>
    </form>
<?php
    exit();
}

// Verificar si se envió el formulario de inicio de sesión
if (isset($_POST['usuario']) && isset($_POST['password'])) {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Consultar la base de datos para obtener el usuario y la contraseña encriptada
    $stmt = $conn->prepare("SELECT id, pass FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuarioData = $result->fetch_assoc();

    if ($usuarioData && password_verify($password, $usuarioData['pass'])) {
        // Guardar el ID del usuario en la sesión
        $_SESSION['usuario_id'] = $usuarioData['id'];
        header('Location: ' . $_SERVER['PHP_SELF']); // Redirige al mismo archivo para mostrar el formulario de cambio
        exit();
    } else {
        echo "<p style='color: red;'>Nombre de usuario o contraseña incorrectos. Inténtalo de nuevo.</p>";
    }
}
?>

<h2>Iniciar Sesión</h2>
<form method="post">
    <label for="usuario">Nombre de Usuario:</label>
    <input type="text" name="usuario" id="usuario" required>
    <br>
    <label for="password">Contraseña:</label>
    <input type="password" name="password" id="password" required>
    <br>
    <button type="submit">Iniciar Sesión</button>
</form>
