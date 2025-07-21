<?php
$host = "sql300.infinityfree.com";
$usuario = "if0_39268616";
$contrasena = "0zRISWAxjTLHVw";
$base_datos = "if0_39268616_bdapp01";

$conn = new mysqli($host, $usuario, $contrasena, $base_datos);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
