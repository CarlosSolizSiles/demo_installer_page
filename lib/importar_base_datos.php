<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Base de Datos</title>
</head>

<body>
    <form action="create.php" method="post" enctype="multipart/form-data">

        <label for="dbname">nombre base de datos</label>
        <input type="text" id="dbname" name="username" required><br><br>
        <label for="dbname"></label>
        <input type="text" id="dbname" name="pass" required><br><br>

        <input type="submit" value="Crear Base de Datos">
    </form>
</body>

</html>