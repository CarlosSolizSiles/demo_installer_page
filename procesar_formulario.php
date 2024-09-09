<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dbname = $_POST['dbname'];
    $dbfile = $_FILES['dbfile']['tmp_name'];

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
    $sql = file_get_contents($dbfile);
    if ($conn->multi_query($sql)) {
        echo "Datos importados exitosamente";
    } else {
        echo "Error importando los datos: " . $conn->error;
    }

    $conn->close();
}
?>
