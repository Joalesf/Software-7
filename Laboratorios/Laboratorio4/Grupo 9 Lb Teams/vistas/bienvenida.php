<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenida</title>
    <link rel="stylesheet" href="Style.css">
</head>

<body>
    <div class="contenedor">
        <div class="panel">
            <?php
            $nombre = Cookie::obtener();

            if ($nombre) {
            ?>
                <h1>¡Bienvenido, <?php echo $nombre; ?>!</h1>
                <p>Tu sesión está activa. La cookie expirará en 5 minutos.</p>
                <form action="index.php?accion=eliminar" method="post">
                    <button type="submit" class="boton secundario">Salir</button>
                </form>
            <?php
            } else {
            ?>
                <h1>Acceso denegado</h1>
                <p>No se ha ingresado un nombre. Por favor, ingresa tu nombre en el formulario.</p>
                <a href="index.php" class="boton">Volver al formulario</a>
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>