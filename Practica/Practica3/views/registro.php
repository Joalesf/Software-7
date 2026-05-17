<?php
$theme = $theme ?? Autenticacion::temaActual();
$datos = $datos ?? [];
?>
<!doctype html>
<html lang="es" data-theme="<?= e($theme) ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro</title>
    <link rel="stylesheet" href="<?= e(asset_url('css/estilos.css')) ?>">
</head>
<body>
    <main class="login">
        <section class="caja">
            <h1>Crear usuario</h1>
            <p>Registro basico para el laboratorio</p>

            <?php if (!empty($error)): ?>
                <div class="mensaje"><?= e($error) ?></div>
            <?php endif; ?>

            <form action="<?= e(route_url('registro')) ?>" method="post">
                <label for="nombre_completo">Nombre completo</label>
                <input id="nombre_completo" name="nombre_completo" type="text" value="<?= e($datos['nombre_completo'] ?? '') ?>" required>

                <label for="usuario">Nombre de usuario</label>
                <input id="usuario" name="usuario" type="text" value="<?= e($datos['usuario'] ?? '') ?>" required>

                <label for="correo">Correo</label>
                <input id="correo" name="correo" type="email" value="<?= e($datos['correo'] ?? '') ?>" required>

                <label for="contrasena">Contrasena</label>
                <input id="contrasena" name="contrasena" type="password" required>

                <label for="confirmar">Confirmar contrasena</label>
                <input id="confirmar" name="confirmar" type="password" required>

                <button type="submit">Registrarse</button>
            </form>

            <p class="enlace">Ya tienes cuenta? <a href="<?= e(route_url('iniciar_sesion')) ?>">Inicia sesion</a></p>
        </section>
    </main>
</body>
</html>
