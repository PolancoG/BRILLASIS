<?php
    session_start();
    date_default_timezone_set('America/Santo_Domingo');

    require_once __DIR__ . '/../../templates/TCPDF-main/tcpdf.php';
    
    $host = 'localhost';
    $dbname = 'cooplight';
    $username = 'root';
    $password = '';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die('Error de conexión: ' . $e->getMessage());
    }

    // Obtener el ID del préstamo desde el cliente
    $prestamo_id = $_GET['prestamo_id'] ?? null;

    if (!$prestamo_id) {
        die('El ID del préstamo no fue proporcionado.');
    }

    try {
        // Consultar datos del cliente y del préstamo
        $stmt = $conn->prepare("
            SELECT cliente.nombre AS nombre, cliente.apellido AS apellido, 
            prestamo.monto AS monto_prestamo 
            FROM prestamo 
            JOIN cliente ON prestamo.cliente_id = cliente.id 
            WHERE prestamo.id = :prestamo_id
        ");
        $stmt->execute([':prestamo_id' => $prestamo_id]);
        $prestamo = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$prestamo) {
            die('El préstamo no existe.');
        }

        // Consultar la tabla de amortización
        $stmt = $conn->prepare("SELECT * FROM tabla_amortizacion WHERE prestamo_id = :prestamo_id");
        $stmt->execute([':prestamo_id' => $prestamo_id]);
        $amortizacion = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$amortizacion) {
            die('No hay datos de amortización para este préstamo.');
        }

        $logoPath = '/imgs/logo.png'; // Cambiar por la ruta real del logo
        $logoWidth = 30;
        $hoy = date("d-m-Y");

        // Crear PDF
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Brillasis');
        $pdf->SetTitle('Tabla de Amortización de '. $prestamo['nombre'] .''. $prestamo['apellido']);
        $pdf->SetSubject('Tabla de Amortización del Préstamo');

        // Configuración de la página
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();

        // Encabezado del PDF
        $pdf->SetFont('helvetica', 'B', 16);

        // Agregar el logo
        $pdf->Image($logoPath, 15, 10, $logoWidth); // (ruta, posición X, posición Y, ancho)

        // Espacio para el título
        $pdf->SetFont('helvetica', 'B', 17);
        $pdf->Cell(0, 10, 'BRILLASIS', 0, 1, 'C');
        $pdf->SetFont('helvetica', 'B', 15);
        $pdf->Cell(0, 10, 'TABLA DE AMORTIZACIÓN', 0, 1, 'C');
        $pdf->SetFont('helvetica', 'B', 13);
        $pdf->Cell(0, 10, 'Fecha : ' . $hoy, 0, 1, 'C');
        $pdf->SetFont('helvetica', 'B', 13);
        $pdf->Ln(5);
        $pdf->Cell(0, 10, 'Nombre del socio: ' . $prestamo['nombre'] . '' . $prestamo['apellido'], 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 11);
        $pdf->Ln(5);

        // Crear tabla en el PDF
        $html = '<table border="1" cellpadding="4">
            <thead>
                <tr style="background-color:rgb(142, 194, 153);">
                  <th>Cuota</th>
                  <th>Fecha Pago</th>
                  <th>Monto Cuota</th>
                  <th>Interés</th>
                  <th>Capital</th>
                  <th>Saldo Restante</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($amortizacion as $cuota) {
            $html .= '<tr>
                <td>' . $cuota['cuota_numero'] . '</td>
                <td>' . $cuota['fecha_pago'] . '</td>
                <td>RD$' . number_format($cuota['monto_cuota'], 2) . '</td>
                <td>RD$' . number_format($cuota['interes'], 2) . '</td>
                <td>RD$' . number_format($cuota['capital'], 2) . '</td>
                <td>RD$' . number_format($cuota['saldo_restante'], 2) . '</td>
            </tr>';
        }

        $html .= '</tbody></table>';

        $pdf->writeHTML($html, true, false, true, false, '');

        // Salida del PDF
        $pdf->Output('Tabla_Amortizacion.pdf', 'I'); // 'I' para mostrar en el navegador
        exit;

    } catch (PDOException $e) {
        die('Error al generar el PDF: ' . $e->getMessage());
    }
?>
