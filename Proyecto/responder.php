<?php
function cargar_solicitudes() {
    return json_decode(file_get_contents('solicitudes.json'), true);
}

function guardar_solicitudes($solicitudes) {
    file_put_contents('solicitudes.json', json_encode($solicitudes, JSON_PRETTY_PRINT));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $respuesta = $_POST['respuesta'];

    $solicitudes = cargar_solicitudes();
    foreach ($solicitudes as &$s) {
        if ($s['id'] === $id) {
            $s['estado'] = 'resuelto';
            $s['comentario_respuesta'] = $respuesta;

            // Enviar correo (revisa configuración de tu servidor)
            @mail($s['email'], "Solicitud Resuelta", "Su solicitud ha sido resuelta:\n\n$respuesta");

            guardar_solicitudes($solicitudes);
            echo "<script>alert('🔔 Solicitud marcada como resuelta y correo enviado'); window.location.href='index.php';</script>";
            exit;
        }
    }
}
?>
