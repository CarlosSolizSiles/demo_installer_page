<?php
include "./lib/verificarPaso.php";
switch (verificarPaso()) {
    case 1:
        include "./lib/cambiar_contrasena.php";
        break;
    case 2:
        include "./lib/importar_base_datos.php";
        break;
    case 3:
        include "./lib/importar_menu.php";
        break;
    default:
        echo "terminado";
        # code...
        break;
}
