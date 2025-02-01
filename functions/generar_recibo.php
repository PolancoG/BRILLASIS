<?php
    session_start();
    // Conexion a la base de datos
    $host = 'localhost';
    $dbname = 'cooplight';
    $username = 'root';
    $password = '';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
        die();
    }

    // Obtener los datos del recibo
    if (isset($_GET['recibo_id'])) {
        $recibo_id = $_GET['recibo_id'];

        try {
            // Consulta para obtener los datos del recibo
            $stmt = $conn->prepare(
                "SELECT r.id, r.cliente_id, r.usuario_id, r.monto_retirado, r.ahorro_restante, r.fecha, r.nrc, 
                        c.nombre AS cliente_nombre, c.apellido AS cliente_apellido, 
                        u.username AS usuario_nombre
                FROM recibos_retiros r
                JOIN cliente c ON r.cliente_id = c.id
                JOIN usuarios u ON r.usuario_id = u.id
                WHERE r.id = :recibo_id"
            );
            $stmt->execute([':recibo_id' => $recibo_id]);
            $recibo = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$recibo) {
                die('Recibo no encontrado.');
            }

            // Generar el recibo en PDF
            require_once '../templates/TCPDF-main/tcpdf.php';

            $pdf = new TCPDF('P', 'mm', [80, 200], true, 'UTF-8', false);
            $pdf->SetMargins(5, 5, 5);
            $pdf->AddPage();

            // Configurar el encabezado manualmente con centrado
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(0, 5, 'BRILLASIS', 0, 1, 'C'); // Nombre del sistema centrado
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(0, 5, 'Recibo de Retiro de Ahorros', 0, 1, 'C'); // Subtítulo centrado
            $pdf->Cell(0, 5, 'Fecha:', 0, 1, 'C'); // Fecha centrada
            $pdf->Cell(0, 5, date('d/m/Y H:i:s', strtotime($recibo['fecha'])), 0, 1, 'C');
            $pdf->Ln(5); // Espacio extra
            $pdf->Cell(0, 5, 'Recibo No.: ' . htmlspecialchars($recibo['nrc']), 0, 1); // Número de recibo centrado
            $pdf->Ln(5); // Espacio extra

            // Línea separadora
            $pdf->Line(5, $pdf->GetY(), 75, $pdf->GetY());
            $pdf->Ln(5);

            // Contenido del recibo
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(0, 5, 'Cliente: ' . htmlspecialchars($recibo['cliente_nombre'] . ' ' . $recibo['cliente_apellido']), 0, 1);
            $pdf->Cell(0, 5, 'Monto Retirado: RD$' . number_format($recibo['monto_retirado'], 2), 0, 1);
            $pdf->Cell(0, 5, 'Ahorro Restante: RD$' . number_format($recibo['ahorro_restante'], 2), 0, 1);
            $pdf->Ln(5);
            $pdf->Ln(5);
            $pdf->Cell(0, 5, 'Atendido por: ' . htmlspecialchars($recibo['usuario_nombre']), 0, 1);
            $pdf->Ln(5);

            // Línea separadora
            $pdf->Line(5, $pdf->GetY(), 75, $pdf->GetY());
            $pdf->Ln(5);

            // Pie de página centrado
            $pdf->SetFont('helvetica', 'I', 9);
            $pdf->MultiCell(0, 5, "Gracias por confiar en nosotros.\nEste recibo es válido como comprobante oficial.", 0, 'C');

            // Salida del PDF
            $pdf->Output('recibo_retiro.pdf', 'I');
        } catch (PDOException $e) {
            echo "Error al obtener los datos del recibo: " . $e->getMessage();
        }
    } else {
        echo "ID del recibo no proporcionado.";
    }
?>

