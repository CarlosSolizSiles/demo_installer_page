<?php
include "./lib/verificarPaso.php";
include "./lib/eliminarPaso.php";
if (verificarPaso() !== -1) {
    eliminarPaso(verificarPaso());
    header("Location: index.php");
}
?>