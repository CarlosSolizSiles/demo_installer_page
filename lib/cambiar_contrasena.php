<?php
session_start();

// Configuración de la base de datos
$host = 'localhost';
$db = 'pruebaspiris';  // Cambia esto por el nombre de tu base de datos
$user = 'root';             // Cambia esto por tu usuario de MySQL
$password = '';     // Cambia esto por tu contraseña de MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

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
            $stmt = $pdo->prepare("UPDATE usuarios SET username = :username, pass = :password WHERE id = :id");
            $stmt->execute([
                ':username' => $nuevaUsuario,
                ':password' => $nuevaPasswordHashed,
                ':id' => $_SESSION['usuario_id']
            ]);

            header("Location: terminarPaso.php");
            // echo "<p>¡Cambios guardados correctamente!</p>";
        } else {
            echo "<p style='color: red;'>Las contraseñas no coinciden. Inténtalo de nuevo.</p>";
        }
    }
    // Formulario para cambiar el nombre de usuario y la contraseña
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
    $stmt = $pdo->prepare("SELECT id, pass FROM usuarios WHERE username = :username");
    $stmt->execute([':username' => $usuario]);
    $usuarioData = $stmt->fetch(PDO::FETCH_ASSOC);

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