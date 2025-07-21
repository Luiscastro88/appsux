<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

error_reporting(E_ALL & ~E_NOTICE);
session_start();
require 'conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$dni = $_SESSION["dni"];
$stmt = $conn->prepare("SELECT nombre FROM usu_contribuyente WHERE DNI = ?");
$stmt->bind_param("s", $dni);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
  <link rel="stylesheet" href="css/principal.css" />
</head>
<body>
  <div class="app-container">
    <div class="header">
      <h2>Hola, <?php echo htmlspecialchars($usuario['nombre']); ?></h2>
    </div>

    <div class="btn-whatsapp">
      <a href="reporte_wa.php" target="_blank">
        Reporte a WhatsApp
      </a>
    </div>

    <div class="logo-central">
      <img src="img/satsullana.png" alt="Escudo">
      <h3>SAT SULLANA<br>SULLANA</h3>
    </div>

    <div class="acciones">
      <a href="rutas_programadas.php" class="boton">VISUALIZAR RUTAS PROGRAMADAS</a>
      <a href="https://www.google.com/maps" class="boton">VISUALIZAR EN TIEMPO REAL</a>
      <a href="logout.php" class="boton cerrar">CERRAR SESIÓN</a>
    </div>
  </div>
</body>
</html>
