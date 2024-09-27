<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['dbfiles']) && $_FILES['dbfiles']['error'] == UPLOAD_ERR_OK) {
        // Ruta temporal del archivo subido
        $tmpFile = $_FILES['dbfiles']['tmp_name'];

        include "./lib/conn.php";
        
        // Leer el contenido del archivo SQL
        $sqlContent = file_get_contents($tmpFile);

        // Ejecutar el contenido SQL
        if ($conn->multi_query($sqlContent)) {
            // Esperar a que se ejecuten todas las consultas
            do {
                if ($result = $conn->store_result()) {
                    $result->free();
                }
            } while ($conn->more_results() && $conn->next_result());

            // Redirigir a index.php si es exitoso
            header("Location: terminarPaso.php");
            exit;
        } else {
            echo "Error al importar la base de datos: " . $conn->error;
        }

        // Cerrar la conexión
        $conn->close();
    } else {
        echo "Error al cargar el archivo. Verifique e intente nuevamente.";
    }
}
?>

<form method="post" enctype="multipart/form-data">
    <label for="dbfiles">Importar base de datos</label>
    <input type="file" id="dbfiles" name="dbfiles" accept=".txt" required><br><br>
    <input type="submit" value="Crear Base de Datos">
</form>