<?php
require_once 'Contacto.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Datos del Contacto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = $_POST['nombre'] ?? '';
            $correo = $_POST['correo'] ?? '';
            $cedula = $_POST['cedula'] ?? '';
            $edad = $_POST['edad'] ?? '';

            $contacto = new Contacto($nombre, $correo, $cedula, $edad);

            echo "<h2>Datos del Contacto</h2>";
            echo "Nombre: " . htmlspecialchars($contacto->getNombre()) . "<br>";
            echo "Correo electrónico: " . htmlspecialchars($contacto->getCorreo()) . "<br>";
            echo "Cédula: " . htmlspecialchars($contacto->getCedula()) . "<br>";
            echo "Edad: " . htmlspecialchars($contacto->getEdad()) . "<br>";
        } else {
            echo "<p>No se han enviado datos del formulario.</p>";
        }
        ?>
    </div>
</body>
</html>