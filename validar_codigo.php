<?php
session_start();

// Validar que se haya enviado código
if (!isset($_POST['codigo']) || !isset($_SESSION['codigo_verificacion'])) {
    echo "<script>alert('Sesión inválida. Vuelve a iniciar sesión.'); window.location.href='login.php';</script>";
    exit;
}

$codigo_ingresado = trim($_POST['codigo']);
$codigo_correcto = $_SESSION['codigo_verificacion'];

// Validación
if ($codigo_ingresado === $codigo_correcto) {
    unset($_SESSION['codigo_verificacion']); // Limpia código
    $_SESSION['autenticado'] = true; // Bandera de autenticación
    header("Location: principal.php");
    exit;
} else {
    echo "<script>alert('Código incorrecto. Intente nuevamente.'); window.location.href='verificacion.php';</script>";
    exit;
}
?>
