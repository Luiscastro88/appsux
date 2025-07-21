<?php
session_start();

// Verifica si hay sesión
if (!isset($_SESSION['dni'])) {
    echo "<script>alert('Sesión no válida. Inicia sesión.'); window.location.href='login.php';</script>";
    exit;
}

require 'conexion.php';

$dni = $_SESSION['dni'];
$tipo = $_POST['metodo'];

// Obtener correo y teléfono desde la BD
$stmt = $conn->prepare("SELECT telefono, correo FROM USU_CONTRIBUYENTE WHERE DNI=?");
$stmt->bind_param("s", $dni);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

// Validaciones
if (!$data) {
    echo "<script>alert('Usuario no encontrado.'); window.location.href='login.php';</script>";
    exit;
}

// Genera código de verificación
$codigo = rand(100000, 999999);
$_SESSION['codigo'] = $codigo;

// DATOS DE META API (rellena con tus valores reales)
$ACCESS_TOKEN = 'EAAPC8QH9EalBPFAGEG...'; // Token real de Meta
$PHONE_NUMBER_ID = '680176258517859';    // Phone Number ID

if ($tipo === 'whatsapp') {
    $telefono = preg_replace('/[^0-9]/', '', $data['telefono']); // Limpiar número
    $to = 'whatsapp:+51' . $telefono;

    $body = [
        "messaging_product" => "whatsapp",
        "to" => $to,
        "type" => "text",
        "text" => [
            "body" => "Tu código de verificación es: $codigo"
        ]
    ];

    $headers = [
        "Authorization: Bearer $ACCESS_TOKEN",
        "Content-Type: application/json"
    ];

    $url = "https://graph.facebook.com/v18.0/$PHONE_NUMBER_ID/messages";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        echo "<script>alert('Error al enviar mensaje: $error'); history.back();</script>";
        exit;
    }
}

// Redirigir a pantalla de validación
header("Location: validar_codigo.php");
exit;
