<!DOCTYPE html>
<html>
<head>
    <title>Añadir Base de Datos</title>
</head>
<body>
    <form action="create.php" method="post" enctype="multipart/form-data">
        <label for="dbname">Nombre de la Base de Datos:</label>
        <input type="text" id="dbname" name="dbname" required><br><br>
      
        <label for="dbname">Nombre Completo:</label>
        <input type="text" id="dbname" name="nombre_completo" required><br><br>
        <label for="dbname">Contraseña</label>
        <input type="text" id="dbname" name="contrasena" required><br><br>

        <input type="submit" value="Crear Base de Datos">
    </form>
</body>
</html>
