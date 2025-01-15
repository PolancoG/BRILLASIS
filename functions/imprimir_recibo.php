<?php
    require '../db.php';

    $recibo_id = $_GET['recibo_id'] ?? null;

    if (!$recibo_id) {
        die('Recibo no especificado.');
    }

    $stmt = $conn->prepare("
        SELECT r.*, c.nombre, c.apellido, u.username AS usuario_nombre
        FROM recibos_retiros r
        JOIN cliente c ON r.cliente_id = c.id
        JOIN usuarios u ON r.usuario_id = u.id
        WHERE r.id = :recibo_id
    ");
    $stmt->execute([':recibo_id' => $recibo_id]);
    $recibo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$recibo) {
        die('Recibo no encontrado.');
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Retiro</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .recibo { border: 1px solid #000; padding: 20px; width: 600px; margin: auto; }
        .recibo h1 { text-align: center; }
        .recibo p { margin: 5px 0; }
    </style>
</head>
<body>
    <div class="recibo">
        <h1>BRILLASIS</h1>
        <p><strong>NRC:</strong> <?= $recibo['nrc'] ?></p>
        <p><strong>Fecha:</strong> <?= date('d/m/Y H:i:s', strtotime($recibo['fecha'])) ?></p>
        <p><strong>Cliente:</strong> <?= $recibo['nombre'] . ' ' . $recibo['apellido'] ?></p>
        <p><strong>Monto Retirado:</strong> RD$<?= number_format($recibo['monto_retirado'], 2) ?></p>
        <p><strong>Ahorro Restante:</strong> RD$<?= number_format($recibo['ahorro_restante'], 2) ?></p>
        <p><strong>Usuario:</strong> <?= $recibo['usuario_nombre'] ?></p>
        <p><strong>Mensaje:</strong> Gracias por confiar en nosotros.</p>
    </div>
</body>
</html>
