<?php
require 'conexion.php';
session_start();

if (!isset($_POST['dni']) || !isset($_POST['direccion']) || !isset($_POST['descripcion'])) {
    echo "<script>alert('Faltan datos.'); history.back();</script>";
    exit;
}

$fecha = date("Y-m-d");
$dni = $_POST['dni'];
$direccion = $_POST['direccion'];
$descripcion = $_POST['descripcion'];

// Insertar en la base de datos
$stmt = $conn->prepare("INSERT INTO reporte_wa (fec_reporte, DNI, direccion, descripcion) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $fecha, $dni, $direccion, $descripcion);

if ($stmt->execute()) {
    // Generar mensaje para WhatsApp
    $mensaje = "*Reporte de Incidente*\n";
    $mensaje .= "📅 Fecha: $fecha\n";
    $mensaje .= "🆔 DNI: $dni\n";
    $mensaje .= "📍 Dirección: $direccion\n";
    $mensaje .= "📝 Descripción: $descripcion";

    $mensajeCodificado = urlencode($mensaje);
    $telefonoMunicipal = "51993111134"; // Reemplazar con número real

    // Redirigir a WhatsApp
    header("Location: https://wa.me/$telefonoMunicipal?text=$mensajeCodificado");
    exit;
} else {
    echo "<script>alert('Error al guardar el reporte.'); history.back();</script>";
}
?>
