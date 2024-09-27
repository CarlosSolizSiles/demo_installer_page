<?php
include "./lib/verificarPaso.php";
include "./lib/eliminarPaso.php";
$carlos = verificarPaso();
echo $carlos;
if (verificarPaso() !== -1) {
    eliminarPaso(verificarPaso());
    header("Location: index.php");
}
?>