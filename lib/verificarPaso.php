<?php
include "checkFileExists.php";

// Function to verify the step
function verificarPaso()
{
    // List of modules (PHP files)
    $modulos = [
        "./lib/cambiar_contrasena.php",
        "./lib/importar_base_datos.php",
        "./lib/importar_menu.php",
    ];
    for ($i = 0; $i < count($modulos); $i++) {
        $file = $modulos[$i];

        // Use checkFileExists to verify if the module file exists
        if (checkFileExists($file)) {
            return $i + 1;
        }
    }

    return -1;
}

// Example usage
// echo verificarPaso();
