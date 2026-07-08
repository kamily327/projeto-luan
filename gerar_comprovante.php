<?php
require_once('./conexao.php');
require_once('./dompdf/autoload.inc.php');

use Dompdf\Dompdf;
use Dompdf\Options;

session_start();

if (!isset($_GET['ingresso_id']) || !isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$id_ingresso = $_GET['ingresso_id'];
$id_usuario = $_SESSION['usuario_id'];
$stmt = $conn->prepare("
    SELECT i.*, e.local_evento, e.data_evento, u.nome, u.email 
    FROM ingressos i
    JOIN eventos e ON i.evento_id = e.id
    JOIN usuarios u ON i.usuario_id = u.id
    WHERE i.id = :id_ingresso AND i.usuario_id = :id_usuario
");
$stmt->execute([':id_ingresso' => $id_ingresso, ':id_usuario' => $id_usuario]);
$dados = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dados) {
    echo "Comprovante não encontrado.";
    exit;
}

$data_show = new DateTime($dados['data_evento']);
$texto_qrcode = "INGRESSO-LS2026-" . $dados['id'] . "-" . md5($dados['id'] . $dados['usuario_id']);
$url_qrcode = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($texto_qrcode);

$html = '
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; background-color: #000000; color: #ffffff; margin: 0; padding: 40px; }
        .ticket-box { border: 2px solid #D4AF37; background-color: #111111; padding: 30px; border-radius: 20px; text-align: center; }
        .header { border-bottom: 1px solid #222222; padding-bottom: 20px; margin-bottom: 20px; }
        .title { color: #D4AF37; font-size: 28px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; }
        .subtitle { font-size: 12px; color: #888888; text-transform: uppercase; letter-spacing: 3px; margin-top: 5px; }
        .event-title { font-size: 22px; font-weight: bold; margin: 20px 0 5px 0; text-transform: uppercase; font-style: italic; }
        .details-grid { margin: 30px 0; text-align: left; background: #1a1a1a; padding: 20px; border-radius: 10px; }
        .detail-item { margin-bottom: 12px; font-size: 14px; }
        .label { color: #D4AF37; font-weight: bold; text-transform: uppercase; font-size: 11px; tracking: 1px; display: block; }
        .value { color: #ffffff; font-size: 15px; margin-top: 2px; }
        .qrcode-container { margin-top: 30px; padding: 15px; background: #ffffff; display: inline-block; border-radius: 10px; }
        .footer-text { font-size: 10px; color: #555555; text-transform: uppercase; margin-top: 20px; letter-spacing: 1px; }
    </style>
</head>
<body>

    <div class="ticket-box">
        <div class="header">
            <div class="title">Luan Santana</div>
            <div class="subtitle">Registro Histórico 2026</div>
        </div>

        <div class="event-title">' . htmlspecialchars($dados['local_evento']) . '</div>
        <div style="color: #888888; font-size: 14px;">Data: ' . $data_show->format('d/m/Y H:i') . '</div>

        <div class="details-grid">
            <div class="detail-item">
                <span class="label">Comprador</span>
                <div class="value">' . htmlspecialchars($dados['nome']) . ' (' . htmlspecialchars($dados['email']) . ')</div>
            </div>
            <div class="detail-item">
                <span class="label">Setor Escolhido</span>
                <div class="value">' . htmlspecialchars($dados['setor_escolhido']) . '</div>
            </div>
            <div class="detail-item">
                <span class="label">Valor Pago</span>
                <div class="value">R$ ' . number_format($dados['valor_pago'], 2, ',', '.') . '</div>
            </div>
            <div class="detail-item">
                <span class="label">Status do Pagamento</span>
                <div class="value" style="color: #4ade80; font-weight: bold;">' . htmlspecialchars($dados['status_pagamento']) . '</div>
            </div>
        </div>

        <div class="qrcode-container">
            <img src="' . $url_qrcode . '" alt="QR Code Ingressos" />
        </div>

        <div class="footer-text">Apresente este QR Code na entrada do evento. ID do Ingresso: #' . $dados['id'] . '</div>
    </div>

</body>
</html>
';


$options = new Options();
$options->set('isRemoteEnabled', true); 
$dompdf = new Dompdf($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Comprovante_Ingresso_LS_" . $dados['id'] . ".pdf", array("Attachment" => true));
exit;