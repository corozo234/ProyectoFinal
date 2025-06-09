<?php
// php/conexion.php
$host = 'localhost';
$usuario = 'root'; // Cambia si usas otro usuario
$contrasena = '';  // Cambia si tienes una contraseña
$base_datos = 'asesorias_vuelo';

$conn = new mysqli($host, $usuario, $contrasena, $base_datos);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
