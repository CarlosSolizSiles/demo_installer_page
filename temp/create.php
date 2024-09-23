<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $pass = $_POST['pass'];


    // Crear la base de datos
    $conn = new mysqli('localhost', 'root', '', 'pruebaspiris');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "INSERT INTO `usuarios`(`username`, `pass`) VALUES ('$username', '$pass');";
    if ($conn->query($sql) === TRUE) {
        echo "datos del usuarios se cambio con exito.";
    } else {
        echo "Error al canbiar los datos: " . $conn->error;
    }

    $conn->close();
}
