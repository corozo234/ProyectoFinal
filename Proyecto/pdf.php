<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;

function cargar_solicitudes() {
    return json_decode(file_get_contents('solicitudes.json'), true);
}

$id = $_GET['id'] ?? '';
$solicitudes = cargar_solicitudes();

foreach ($solicitudes as $s) {
    if ($s['id'] === $id) {
        $html = "<h1>Solicitud de " . htmlspecialchars($s['nombre']) . "</h1>";
        $html .= "<p><strong>Mensaje:</strong><br>" . nl2br(htmlspecialchars($s['mensaje'])) . "</p>";
        $html .= "<p><strong>Estado:</strong> " . $s['estado'] . "</p>";
        $html .= "<p><strong>Respuesta:</strong> " . htmlspecialchars($s['comentario_respuesta']) . "</p>";

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream("solicitud_{$id}.pdf");
        exit;
    }
}
?>
