<?php $theme = $theme ?? Autenticacion::temaActual(); ?>
<!doctype html>
<html lang="es" data-theme="<?= e($theme) ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesion</title>
    <link rel="stylesheet" href="<?= e(asset_url('css/estilos.css')) ?>">
</head>
<body>
    <main class="login">
        <section class="caja">
            <h1>Iniciar sesion</h1>
            <p>Laboratorio PHP Cookies y Sesiones</p>

            <?php if (!empty($error)): ?>
                <div class="mensaje"><?= e($error) ?></div>
            <?php endif; ?>

            <form action="<?= e(route_url('iniciar_sesion')) ?>" method="post">
                <label for="usuario">Nombre de usuario</label>
                <input id="usuario" name="usuario" type="text" value="<?= e($usuarioAnterior ?? '') ?>" required>

                <label for="contrasena">Contrasena</label>
                <input id="contrasena" name="contrasena" type="password" required>

                <label class="check" for="recordar">
                    <input id="recordar" name="recordar" type="checkbox" value="1">
                    Recuerdame
                </label>

                <button type="submit">Entrar</button>
            </form>

            <p class="enlace">No tienes cuenta? <a href="<?= e(route_url('registro')) ?>">Registrate</a></p>
        </section>
    </main>
</body>
</html>
