<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del servicio</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <main class="contenedor">
        <section class="panel panel-ancho">
            <div class="barra">
                <div>
                    <h1>Factura de servicios</h1>
                    <p>Detalle de trabajos y total a pagar.</p>
                </div>
                <a class="enlace-salir" href="index.php?accion=salir">Cerrar sesion</a>
            </div>

            <div class="resultado-horizontal">
                <div class="resumen-cliente">
                    <h2><?php echo htmlspecialchars($resultado['cliente']['nombre'], ENT_QUOTES, 'UTF-8'); ?></h2>
                    <p><strong>Fecha de nacimiento:</strong> <?php echo htmlspecialchars($resultado['cliente']['fecha_nacimiento'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Genero:</strong> <?php echo htmlspecialchars($resultado['cliente']['genero'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Nacionalidad:</strong> <?php echo htmlspecialchars($resultado['cliente']['nacionalidad'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Direccion:</strong> <?php echo htmlspecialchars($resultado['cliente']['direccion'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>

                <div>
                    <h2>Servicios seleccionados</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Servicio</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultado['servicios'] as $servicio) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($servicio['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>$<?php echo number_format($servicio['precio'], 2); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total a pagar</th>
                                <th>$<?php echo number_format($resultado['total'], 2); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="acciones">
                <a class="boton" href="index.php?accion=formulario">Realizar otro calculo</a>
            </div>
        </section>
    </main>
</body>
</html>
