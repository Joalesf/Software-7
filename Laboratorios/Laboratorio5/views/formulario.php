<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de servicios</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <main class="contenedor">
        <section class="panel panel-ancho">
            <div class="barra">
                <div>
                    <h1>Orden de servicio</h1>
                    <p>Complete los datos y marque los trabajos solicitados.</p>
                </div>
                <a class="enlace-salir" href="index.php?accion=salir">Cerrar sesion</a>
            </div>

            <?php if (count($errores) > 0) { ?>
                <div class="alerta error">
                    <strong>Revise el formulario:</strong>
                    <ul>
                        <?php foreach ($errores as $error) { ?>
                            <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>

            <form class="formulario formulario-horizontal" action="index.php?accion=procesar" method="post">
                <div class="datos-cliente">
                    <div class="campo">
                        <label for="nombre">Nombre del cliente</label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars(isset($datos['nombre']) ? $datos['nombre'] : '', ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>

                    <div class="campo">
                        <label for="fecha_nacimiento">Fecha de nacimiento</label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo htmlspecialchars(isset($datos['fecha_nacimiento']) ? $datos['fecha_nacimiento'] : '', ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>

                    <div class="campo">
                        <label for="genero">Genero</label>
                        <select id="genero" name="genero" required>
                            <?php $generoSeleccionado = isset($datos['genero']) ? $datos['genero'] : ''; ?>
                            <option value="">Seleccione</option>
                            <option value="Masculino" <?php echo $generoSeleccionado === 'Masculino' ? 'selected' : ''; ?>>Masculino</option>
                            <option value="Femenino" <?php echo $generoSeleccionado === 'Femenino' ? 'selected' : ''; ?>>Femenino</option>
                            <option value="Otro" <?php echo $generoSeleccionado === 'Otro' ? 'selected' : ''; ?>>Otro</option>
                        </select>
                    </div>

                    <div class="campo">
                        <label for="nacionalidad">Nacionalidad</label>
                        <input type="text" id="nacionalidad" name="nacionalidad" value="<?php echo htmlspecialchars(isset($datos['nacionalidad']) ? $datos['nacionalidad'] : '', ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>

                    <div class="campo campo-completo">
                        <label for="direccion">Direccion de residencia</label>
                        <textarea id="direccion" name="direccion" rows="3" required><?php echo htmlspecialchars(isset($datos['direccion']) ? $datos['direccion'] : '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>
                </div>

                <fieldset class="servicios bloque-servicios">
                    <legend>Servicios disponibles</legend>
                    <?php
                    $serviciosMarcados = isset($datos['servicios']) && is_array($datos['servicios']) ? $datos['servicios'] : array();
                    foreach ($servicios as $id => $servicio) {
                    ?>
                        <label class="servicio">
                            <input type="checkbox" name="servicios[]" value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>" <?php echo in_array($id, $serviciosMarcados) ? 'checked' : ''; ?>>
                            <span><?php echo htmlspecialchars($servicio['nombre'], ENT_QUOTES, 'UTF-8'); ?></span>
                            <strong>$<?php echo number_format($servicio['precio'], 2); ?></strong>
                        </label>
                    <?php } ?>
                </fieldset>

                <div class="acciones campo-completo">
                    <button type="submit">Calcular total</button>
                    <button type="reset" class="boton-secundario">Limpiar</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
