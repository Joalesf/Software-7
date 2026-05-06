<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratorio Cookies</title>
    <link rel="stylesheet" href="../Assets/Main.css">
</head>
<body>
    <main class="contenedor">
        <section class="panel">
            <h1>Laboratorio Cookies</h1>
            <p>Ingrese su nombre para guardarlo temporalmente en una cookie.</p>

            <form action="ProcesarNombre.php" method="POST" class="formulario">
                <label for="nombre">Nombre</label>
                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    placeholder="Escriba su nombre"
                    required
                    autocomplete="name"
                >

                <button type="submit">Guardar nombre</button>
            </form>
        </section>
    </main>
</body>
</html>
