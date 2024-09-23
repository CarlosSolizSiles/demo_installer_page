<?php

// Function to move a module to a temp folder based on step
function eliminarPaso($pasoAEliminar)
{
    // List of modules (PHP files)
    $modulos = [
        "./lib/cambiar_contrasena.php",
        "./lib/importar_base_datos.php",
        "./lib/importar_menu.php",
        // Add more modules as needed
    ];

    if (isset($modulos[$pasoAEliminar])) {
        $fileToMove = $modulos[$pasoAEliminar];
        $tempDir = "./temp/";

        // Check if the temp directory exists, if not, create it
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        // Define the target path in the temp folder
        $newPath = $tempDir . basename($fileToMove);
        echo $fileToMove;
        echo $newPath;
        // Attempt to move the file
        if (file_exists($fileToMove) && rename($fileToMove, $newPath)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}


echo eliminarPaso(0) ? "1": "0";
