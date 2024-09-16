<?php
require 'lib/checkFileExists.php'; // Asegúrate de incluir el archivo donde está la función

if (!checkFileExists('history.log')) {
    echo '<a href="formulario.php">Añadir Base de Datos</a>';
} else {
    echo 'El archivo history.log existe.';
}
?>
