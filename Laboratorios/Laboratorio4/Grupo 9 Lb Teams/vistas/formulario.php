<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Cookies</title>
    <link rel="stylesheet" href="Style.css">
</head>

<body>
    <div class="contenedor">
        <div class="panel">
            <h1>Ingresa tu nombre</h1>
            <p>Por favor completa el formulario para continuar</p>
            <form class="formulario" action="index.php?accion=guardar" method="post">
                <div>
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu nombre" required>
                </div>
                <button type="submit" class="boton">Enviar</button>
            </form>
        </div>
    </div>
</body>

</html>