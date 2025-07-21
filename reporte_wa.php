<?php
session_start();
$fecha = date("Y-m-d");
$dni = $_SESSION["dni"] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reporte de Incidente</title>
  <link rel="stylesheet" href="css/reportewa.css" />
</head>
<body>
  <div class="form-container">
    <h2>🚛 Reporte de Incidente</h2>
    <form action="guardar_reporte_wa.php" method="POST">
      <input type="text" value="<?= $fecha ?>" readonly />
      <input type="text" name="dni" value="<?= htmlspecialchars($dni) ?>" readonly required />
      <input type="text" name="direccion" placeholder="Dirección o referencia del incidente" required />
      <textarea name="descripcion" placeholder="Describa el problema..." required></textarea>
      <button type="submit">Enviar incidencia por WhatsApp</button>
    </form>
    <p class="nota">Si desea, puede enviar una imagen desde el chat de WhatsApp</p>
  </div>
</body>
</html>

