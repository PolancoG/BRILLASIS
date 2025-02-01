<?php
    session_start();

    // Generar el recibo en PDF
    require_once '../templates/TCPDF-main/tcpdf.php';

    // Conexión a la base de datos
    $host = 'localhost';
    $dbname = 'cooplight';
    $username = 'root';
    $password = '';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }

    // Validar si se recibe el ID del ahorro
    if (!isset($_GET['ahorro_id'])) {
        die("ID del ahorro no proporcionado.");
    }

    $ahorro_id = $_GET['ahorro_id'];

    try {

        // Obtener la información del depósito de ahorro
        $stmt = $conn->prepare("
            SELECT ra.id, ra.fecha_agregado, ra.monto_agregado, ra.numero_socio, 
                c.nombre AS cliente_nombre, c.apellido AS cliente_apellido, 
                u.username AS usuario_nombre,
                a.monto AS ahorro_total
            FROM registro_ahorros ra
            INNER JOIN cliente c ON ra.cliente_id = c.id
            INNER JOIN usuarios u ON ra.usuario_id = u.id
            INNER JOIN ahorro a ON ra.cliente_id = a.cliente_id
            WHERE ra.id = :ahorro_id
        ");    
        $stmt->execute([':ahorro_id' => $ahorro_id]);
        $ahorro = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$ahorro) {
            die("No se encontró información del ahorro.");
        }

        // Generar el recibo en PDF
        $pdf = new TCPDF('P', 'mm', [80, 200], true, 'UTF-8', false);
        $pdf->SetMargins(5, 5, 5);
        $pdf->AddPage();

        // Encabezado
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 5, 'BRILLASIS', 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 5, 'Recibo de Depósito de Ahorros', 0, 1, 'C');
        $pdf->Cell(0, 5, 'Fecha:', 0, 1, 'C');
        $pdf->Cell(0, 5, date('d/m/Y H:i:s', strtotime($ahorro['fecha_agregado'])), 0, 1, 'C');
        $pdf->Ln(5);
        $pdf->Cell(0, 5, 'Recibo No.: ' . htmlspecialchars($ahorro['id']), 0, 1);
        $pdf->Ln(5);

        // Línea separadora
        $pdf->Line(5, $pdf->GetY(), 75, $pdf->GetY());
        $pdf->Ln(5);

        // Contenido del recibo
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 5, 'Cliente: ' . htmlspecialchars($ahorro['cliente_nombre'] . ' ' . $ahorro['cliente_apellido']), 0, 1);
        $pdf->Cell(0, 5, 'Monto Depositado: RD$' . number_format($ahorro['monto_agregado'], 2), 0, 1);
        $pdf->Cell(0, 5, 'Ahorro Total: RD$' . number_format($ahorro['ahorro_total'], 2), 0, 1);
        $pdf->Ln(5);
        $pdf->Cell(0, 5, 'Registrado por: ' . htmlspecialchars($ahorro['usuario_nombre']), 0, 1);
        $pdf->Ln(5);

        $pdf->Output('recibo_deposito.pdf', 'I');

    } catch (PDOException $e) {
        die("Error al generar el recibo: " . $e->getMessage());
    }
?>
