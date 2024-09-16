<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dbname = $_POST['dbname'];
    $nombre_completo = $_POST['nombre_completo'];
    $contrasena = $_POST['contrasena'];
 

    // Crear la base de datos
    $conn = new mysqli('localhost', 'root', '');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "CREATE DATABASE $dbname";
    if ($conn->query($sql) === TRUE) {
        echo "Base de datos creada exitosamente<br>";
    } else {
        echo "Error creando la base de datos: " . $conn->error;
    }
    // Importar el archivo .txt a la base de datos
    $conn->select_db($dbname);
    $sql = "CREATE TABLE example (id int PRIMARY KEY, nombre_completo VARCHAR(100) NOT NULL, contraseña VARCHAR(100) NOT NULL );INSERT INTO `example`(`id`, `nombre_completo`, `contraseña`) VALUES (1, $nombre_completo, $contrasena);";
    if ($conn->multi_query($sql)) {
        echo "Datos importados exitosamente";
    } else {
        echo "Error importando los datos: " . $conn->error;
    }

    $conn->close();
}
?>