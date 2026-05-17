<?php $temaActual = $theme ?? Autenticacion::temaActual(); ?>
<!doctype html>
<html lang="es" data-theme="<?= e($temaActual) ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perfil</title>
    <link rel="stylesheet" href="<?= e(asset_url('css/estilos.css')) ?>">
</head>
<body>
    <header class="barra">
        <strong>Laboratorio PHP</strong>
        <form action="<?= e(route_url('salir')) ?>" method="post">
            <button class="salir" type="submit">Cerrar sesion</button>
        </form>
    </header>

    <main class="contenedor">
        <section class="caja">
            <h1>Perfil personal</h1>
            <p>Bienvenido, <?= e($usuario['nombre_completo']) ?></p>

            <table>
                <tr>
                    <th>Usuario</th>
                    <td><?= e($usuario['usuario']) ?></td>
                </tr>
                <tr>
                    <th>Correo</th>
                    <td><?= e($usuario['correo']) ?></td>
                </tr>
                <tr>
                    <th>Registro</th>
                    <td><?= e(date('d/m/Y H:i', strtotime($usuario['creado_en']))) ?></td>
                </tr>
            </table>
        </section>

        <section class="caja">
            <h2>Tema</h2>
            <form action="<?= e(route_url('tema')) ?>" method="post" data-theme-form>
                <?php foreach (app_config('themes') as $option): ?>
                    <label class="opcion">
                        <input type="radio" name="theme" value="<?= e($option) ?>" <?= $temaActual === $option ? 'checked' : '' ?>>
                        <?= e(ucfirst($option)) ?>
                    </label>
                <?php endforeach; ?>

                <button type="submit">Guardar tema</button>
            </form>
        </section>
    </main>

    <script src="<?= e(asset_url('js/aplicacion.js')) ?>"></script>
</body>
</html>
