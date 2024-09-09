<!DOCTYPE html>
<html>
<head>
    <title>Añadir Base de Datos</title>
</head>
<body>
    <form action="procesar_formulario.php" method="post" enctype="multipart/form-data">
        <label for="dbname">Nombre de la Base de Datos:</label>
        <input type="text" id="dbname" name="dbname" required><br><br>
        <label for="dbfile">Archivo .txt de la Base de Datos:</label>
        <input type="file" id="dbfile" name="dbfile" accept=".txt" required><br><br>
        <input type="submit" value="Crear Base de Datos">
    </form>
</body>
</html>
