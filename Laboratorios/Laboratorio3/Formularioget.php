<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calculadora de IMC</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Calculadora de IMC</h1>
        <form action="Salidaget.php" method="get">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required><br><br>

            <label for="peso">Peso (kg):</label>
            <input type="number" id="peso" name="peso" step="0.01" required><br><br>

            <label for="altura">Altura (metros):</label>
            <input type="number" id="altura" name="altura" step="0.01" required><br><br>

            <input type="submit" value="Calcular IMC">
        </form>
    </div>
</body>
</html>