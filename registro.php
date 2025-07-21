<?php




ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



require 'conexion.php';
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST["dni"];
    $nombre = $_POST["nombre"];
    $apellido_p = $_POST["apellido_p"];
    $apellido_m = $_POST["apellido_m"];
    $direccion = $_POST["direccion"];
    $correo = $_POST["correo"];
    $telefono = $_POST["telefono"];
    $acepta = isset($_POST["terminos"]) ? 1 : 0;

    // Verificar si el DNI ya está registrado
    $verificar = $conn->prepare("SELECT * FROM usu_contribuyente WHERE DNI = ?");
    $verificar->bind_param("s", $dni);
    $verificar->execute();
    $resultado = $verificar->get_result();

    if ($resultado->num_rows > 0) {
        $mensaje = "El DNI ingresado ya está registrado. Por favor, ingrese otro.";
    } else {
        $sql = "INSERT INTO usu_contribuyente (DNI, nombre, direccion, correo, apellido_p, apellido_m, telefono, acepta_terminos) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssi", $dni, $nombre, $direccion, $correo, $apellido_p, $apellido_m, $telefono, $acepta);


        
   if ($stmt->execute()) {
    echo "<script>
        alert('Se registró con éxito');
        window.location.href = 'login.php';
    </script>";
    exit;
}
else {
            $mensaje = "Error al registrar: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registrarse</title>
  <link rel="stylesheet" href="css/registro.css" />
</head>
<body>
  <div class="app-container">
    <div class="header">
      <div class="header-title">REGISTRARSE</div>
      <img src="img/logo.png" alt="Logo" class="logo-derecha" />
    </div>

    <?php if (!empty($mensaje)) : ?>
      <div class="mensaje-error"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <form action="" method="post" class="formulario">
      <h3>Ingresa tus datos</h3>
      <input type="text" name="dni" placeholder="DNI" required />
      <input type="text" name="nombre" placeholder="Nombres" required />
      <input type="text" name="apellido_p" placeholder="Apellido Paterno" required />
      <input type="text" name="apellido_m" placeholder="Apellido Materno" required />
      <input type="text" name="direccion" placeholder="Dirección" required />
      <input type="email" name="correo" placeholder="Correo Electrónico" required />
      <input type="tel" name="telefono" placeholder="Teléfono" required />
      <label class="terminos">
        <input type="checkbox" name="terminos" required />
        Acepto los <a href="#">términos</a> y <a href="#">condiciones</a>
      </label>
      <button type="submit">Registrarse</button>
      <p class="login-link">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
    </form>
  </div>
</body>
</html>
