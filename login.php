

<!DOCTYPE html>
<html lang="es">
<head>

<!-- Manifest -->
<link rel="manifest" href="manifest.json" />

<!-- Icono para Android -->
<link rel="icon" type="image/png" sizes="192x192" href="img/icon-192.png">

<!-- Meta para color de tema -->
<meta name="theme-color" content="#007BFF">




<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST["numero-doc"];

    // Verifica si el DNI existe en la base de datos
    $stmt = $conn->prepare("SELECT * FROM usu_contribuyente WHERE dni = ?");
    $stmt->bind_param("s", $dni);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $_SESSION["dni"] = $dni; // Guardamos el DNI en sesión para usarlo en verificacion.php
        header("Location: principal.php");
        exit();
    } else {
        echo "<script>alert('DNI no registrado. Por favor, regístrese.'); window.location.href='login.php';</script>";
    }
}
?>


  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="css/login.css" />
</head>
<body>
  <div class="app-container">
    <div class="overlay">
      <br>
      <br>
      <!-- Logo superior -->
      <div class="logo-container">
        <img src="img/logo.png" alt="Muni Sullana Digital" class="logo" />
      </div>

      <!-- Formulario -->
      <form action="login.php" method="post" class="formulario">
        <label for="numero-doc"><strong>Documento de Identidad</strong></label>
        <input type="text" id="numero-doc" name="numero-doc" required />

        <p class="terminos">
          Al continuar, usted indica que ha leído y acepta los 
          <a href="#">Términos y Condiciones</a> y la 
          <a href="#">Política de Privacidad</a>
        </p>
        <button type="submit" class="btn-ingresar">INGRESAR</button>
      </form>

      <!-- Enlace de registro -->
      <p class="registro">
        ¿Eres nuevo? <a href="registro.php">Regístrate aquí</a>
      </p>

      <!-- Logo inferior -->
      <div class="logo-bottom">
        <img src="img/logosullana.png" alt="Municipalidad de Sullana" />
      </div>
    </div>
  </div>



  <!-- Script para registrar el Service Worker -->
  <script>
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('service-worker.js')

      .then(() => console.log("✅ Service Worker registrado"))
      .catch(error => console.error("❌ Error al registrar SW", error));
  }
</script>



</body>
</html>
