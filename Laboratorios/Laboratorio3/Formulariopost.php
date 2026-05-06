<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Contacto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Registro de Contacto</h1>
        <form action="Salidapost.php" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required><br><br>

            <label for="correo">Correo electrónico:</label>
            <input type="email" id="correo" name="correo" required><br><br>

            <label for="cedula">Cédula:</label>
            <input type="text" id="cedula" name="cedula" required><br><br>

            <label for="edad">Edad:</label>
            <input type="number" id="edad" name="edad" required><br><br>

            <input type="submit" value="Enviar">
        </form>
    </div>
</body>
</html>