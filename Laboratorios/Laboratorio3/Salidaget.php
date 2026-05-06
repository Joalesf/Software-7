<?php
require_once 'IMC.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado del IMC</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['nombre'], $_GET['peso'], $_GET['altura'])) {
            $nombre = $_GET['nombre'];
            $peso = floatval($_GET['peso']);
            $altura = floatval($_GET['altura']);

            $imcObj = new IMC($nombre, $peso, $altura);

            echo "<h2>Resultado del IMC para " . htmlspecialchars($imcObj->getNombre()) . "</h2>";
            echo "Peso: " . htmlspecialchars($imcObj->getPeso()) . " kg<br>";
            echo "Altura: " . htmlspecialchars($imcObj->getAltura()) . " m<br>";
            echo "IMC: " . number_format($imcObj->getIMC(), 2) . "<br>";
            echo "Clasificación: " . htmlspecialchars($imcObj->getClasificacion()) . "<br>";

            echo "<h2>Información del Servidor</h2>";
            echo "PHP_SELF: " . htmlspecialchars($_SERVER['PHP_SELF']) . "<br>";
            echo "SERVER_NAME: " . htmlspecialchars($_SERVER['SERVER_NAME']) . "<br>";
            echo "HTTP_USER_AGENT: " . htmlspecialchars($_SERVER['HTTP_USER_AGENT']) . "<br>";
            echo "REQUEST_METHOD: " . htmlspecialchars($_SERVER['REQUEST_METHOD']) . "<br>";
            echo "REMOTE_ADDR: " . htmlspecialchars($_SERVER['REMOTE_ADDR']) . "<br>";
            echo "QUERY_STRING: " . htmlspecialchars($_SERVER['QUERY_STRING']) . "<br>";
        } else {
            echo "<p>No se han enviado datos válidos del formulario.</p>";
        }
        ?>
    </div>
</body>
</html>
