<?php
require 'conexion.php';
session_start();

// Verificar si se recibió el DNI desde login
if (!isset($_SESSION["dni"])) {
    echo "<script>alert('No se encuentra registrado este DNI'); window.location.href = 'login.php';</script>";
    exit;
}

$dni = $_SESSION["dni"];

// Obtener correo y teléfono del contribuyente
$stmt = $conn->prepare("SELECT correo, telefono FROM USU_CONTRIBUYENTE WHERE DNI = ?");
$stmt->bind_param("s", $dni);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

  
function ocultarCorreo($correo) {
    $partes = explode("@", $correo);
    return substr($partes[0], 0, 1) . str_repeat("*", strlen($partes[0])-2) . substr($partes[0], -1) . "@***";
}

function ocultarTelefono($telefono) {
    return substr($telefono, 0, 2) . str_repeat("*", 5) . substr($telefono, -2);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Verificación</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="css/verificacion.css" />
</head>
<body>
  <div class="app-container">
    <div class="header">
      <h2>VERIFICAR</h2>
      <img src="img/logo.png" class="logo-derecha" />
    </div>
    <h3 class="subtitulo">Seleccione el método de autenticación</h3>
    <form action="enviar_codigo.php" method="post">
      <div class="opciones">
        <label class="opcion">
          <input type="radio" name="metodo" value="correo" required />
          <img src="img/gmail.png" alt="Correo" />
          <p><?php echo ocultarCorreo($data['correo']); ?></p>
        </label>
        <label class="opcion">
          <input type="radio" name="metodo" value="whatsapp" required />
          <img src="img/whatsapp.png" alt="WhatsApp" />
          <p><?php echo ocultarTelefono($data['telefono']); ?></p>
        </label>
      </div>
      <button type="submit" class="btn-enviar" > ENVIAR CÓDIGO</button>
    <br><br><br><br><br><br><br><br><br>
      <br>
      <p class="volver"><a href="principal.php">Regresar al login</a></p>
    </form>
  </div>

  <script>
  const opciones = document.querySelectorAll('.opcion');

  opciones.forEach(opcion => {
    opcion.addEventListener('click', () => {
      opciones.forEach(o => o.classList.remove('selected'));
      opcion.classList.add('selected');
      opcion.querySelector('input[type="radio"]').checked = true;
    });
  });
</script>

</body>
</html>
