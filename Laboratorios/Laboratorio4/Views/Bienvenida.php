<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenida</title>
    <link rel="stylesheet" href="../Assets/Main.css">
</head>
<body>
    <main class="contenedor">
        <section class="panel">
            <?php if ($nombre !== null): ?>
                <h1>Bienvenido, <?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?></h1>
                <p>Su nombre fue guardado en una cookie valida por 5 minutos.</p>
                <a class="boton secundario" href="../Controlador/Salir.php">Salir</a>
            <?php else: ?>
                <h1>No se ha ingresado el nombre</h1>
                <p>Debe volver al formulario para guardar su nombre en una cookie.</p>
                <a class="boton" href="../Controlador/Formulario.php">Volver al formulario</a>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
