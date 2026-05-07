<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesion</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <main class="contenedor">
        <section class="panel panel-pequeno acceso-horizontal">
            <div class="intro-acceso">
                <h1>Acceso al sistema</h1>
                <p>Ordenes de servicios tecnicos.</p>
            </div>

            <div>
                <?php if ($error !== '') { ?>
                    <div class="alerta error">
                        <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php } ?>

                <form class="formulario" action="index.php?accion=autenticar" method="post">
                    <div class="campo">
                        <label for="usuario">Usuario</label>
                        <input type="text" id="usuario" name="usuario" required>
                    </div>

                    <div class="campo">
                        <label for="clave">Contrasena</label>
                        <input type="password" id="clave" name="clave" required>
                    </div>

                    <button type="submit">Entrar</button>
                </form>

                <p class="ayuda">Usuario de prueba: admin / 1234</p>
            </div>
        </section>
    </main>
</body>
</html>
