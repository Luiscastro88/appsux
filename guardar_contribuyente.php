<?php
require 'db.php'; // conexión PDO

$dni         = $_POST['dni'];
$nombre      = $_POST['nombre'];
$apellido_p  = $_POST['apellido_p'];
$apellido_m  = $_POST['apellido_m'];
$direccion   = $_POST['direccion'];
$correo      = $_POST['correo'];
$telefono    = $_POST['telefono'];
$contraseña  = $_POST['contraseña'];

try {
    $stmt = $pdo->prepare("INSERT INTO USU_CONTRIBUYENTE 
        (DNI, nombre, direccion, correo, contraseña, apellido_p, apellido_m, telefono) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
    $stmt->execute([
        $dni, $nombre, $direccion, $correo, $contraseña,
        $apellido_p, $apellido_m, $telefono
    ]);

    echo "¡Registro exitoso!";
    // header("Location: validacion.php"); // si deseas redirigir después

} catch (PDOException $e) {
    echo "Error al registrar: " . $e->getMessage();
}
?>
