<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importar Archivo TXT</title>
</head>

<body>

    <h1>Importar Archivo TXT y Crear Menú</h1>

    <?php
    // Iniciamos la sesión para almacenar el nombre del archivo
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Verificamos si el archivo fue subido correctamente
        if (isset($_FILES['archivo_txt']) && $_FILES['archivo_txt']['error'] == 0) {
            // Definimos la carpeta donde se guardará el archivo
            $directorioDestino = 'temp/';
            // Creamos la carpeta si no existe
            if (!is_dir($directorioDestino)) {
                mkdir($directorioDestino, 0777, true);
            }

            // Obtenemos el nombre y la ruta temporal del archivo
            $nombreArchivo = basename($_FILES['archivo_txt']['name']);
            $rutaTemporal = $_FILES['archivo_txt']['tmp_name'];
            $rutaDestino = $directorioDestino . $nombreArchivo;

            // Movemos el archivo a la carpeta 'temp'
            if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                // Guardamos el nombre del archivo en la sesión
                $_SESSION['nombreArchivo'] = $nombreArchivo;

                // Redirigimos para evitar reenvío de formularios al recargar la página
                header("Location: ?success=1");
                exit();
            } else {
                echo "<p style='color:red;'>Error al mover el archivo a la carpeta 'temp'.</p>";
            }
        } else {
            echo "<p style='color:red;'>Hubo un error al subir el archivo.</p>";
        }
    }

    // Mostrar el menú y generar el archivo menu.php solo si se ha subido un archivo con éxito
    if (isset($_GET['success']) && $_GET['success'] == 1 && isset($_SESSION['nombreArchivo'])) {
        // Obtenemos el nombre del archivo de la sesión
        $nombreArchivo = $_SESSION['nombreArchivo'];
        $rutaDestino = 'temp/' . $nombreArchivo;

        if (file_exists($rutaDestino)) {
            // Leemos el contenido del archivo
            $contenidoArchivo = file_get_contents($rutaDestino);

            // Mostramos el menú en la página actual
            echo "<h2>Menú Generado:</h2>";
            echo "<ul>";
            $lineas = explode("\n", $contenidoArchivo); // Dividimos el contenido en líneas
            $menuHTML = "<ul>\n"; // Variable para almacenar el contenido HTML del menú
            foreach ($lineas as $linea) {
                if (trim($linea) !== '') {
                    $partes = explode(' ', $linea, 2); // Limitar a 2 partes (URL y nombre)
                    if (count($partes) == 2) {
                        $url = trim($partes[0]);
                        $nombre = trim($partes[1], ' "'); // Elimina comillas si las tiene
                        echo "<li><a href=\"$url\">$nombre</a></li>";
                        $menuHTML .= "<li><a href=\"$url\">$nombre</a></li>\n"; // Añadir al archivo
                    }
                }
            }
            echo "</ul>";
            $menuHTML .= "</ul>";

            // Guardar el menú en un archivo PHP en la carpeta 'lib'
            $rutaMenu = './lib/menu.php';
            $contenidoMenu = "<?php\n// Archivo generado automáticamente\n?>\n" . $menuHTML;
            if (file_put_contents($rutaMenu, $contenidoMenu)) {
                echo "<p>El archivo <strong>menu.php</strong> se ha generado correctamente en la carpeta 'lib'.</p>";
            } else {
                echo "<p style='color:red;'>Error al generar el archivo menu.php en la carpeta 'lib'.</p>";
            }
        } else {
            echo "<p style='color:red;'>No se encontró el archivo en la ruta especificada.</p>";
        }
    }
    ?>

    <!-- Formulario para subir archivo -->
    <form method="POST" enctype="multipart/form-data">
        <label for="archivo_txt">Selecciona un archivo TXT:</label>
        <input type="file" name="archivo_txt" id="archivo_txt" accept=".txt" required>
        <br><br>
        <button type="submit">Importar Archivo</button>
    </form>

</body>

</html>