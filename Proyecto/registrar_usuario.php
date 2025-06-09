<?php
// php/registrar_usuario.php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
    $rol = $_POST['rol'];

    // Validar si el correo ya existe
    $checkQuery = "SELECT id FROM usuarios WHERE correo = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Este correo ya está registrado.'); window.history.back();</script>";
        exit();
    }

    // Insertar nuevo usuario
    $query = "INSERT INTO usuarios (nombre, correo, contrasena, id_rol) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $nombre, $correo, $contrasena, $rol);

    if ($stmt->execute()) {
        echo "<script>alert('Usuario registrado correctamente.'); window.location.href='../index.html';</script>";
    } else {
        echo "Error al registrar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Acceso no permitido";
}
?>
