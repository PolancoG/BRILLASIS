<?php
    session_start();

    require_once __DIR__ . '/../../templates/TCPDF-main/tcpdf.php';
    //require_once './templates/TCPDF-main/tcpdf.php'; // Ruta a TCPDF
    // Conexión a la base de datos
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

    if (!isset($_GET['id'])) {
        die('ID del cliente no especificado');
    }

    $id = $_GET['id'];

    // Consulta para obtener los detalles del cliente
    $stmt = $conn->prepare("
        SELECT c.*, s.nombre AS sucursal_nombre, co.nombre AS compania_nombre
        FROM cliente c
        JOIN sucursal s ON c.sucursal_id = s.id
        JOIN compania co ON s.compania_id = co.id
        WHERE c.id = :id
    ");
    $stmt->execute([':id' => $id]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    // Información de ahorros
    $stmta = $conn->prepare("SELECT SUM(monto) AS total_ahorros FROM ahorro WHERE cliente_id = :id");
    $stmta->execute([':id' => $id]);
    $ahorros = $stmta->fetch(PDO::FETCH_ASSOC);

    // Información de préstamos
    $stmtp = $conn->prepare("SELECT SUM(monto) AS total_prestamos FROM prestamo WHERE cliente_id = :id");
    $stmtp->execute([':id' => $id]);
    $prestamos = $stmtp->fetch(PDO::FETCH_ASSOC); 

    $im = 'RD$'. number_format($cliente['ingresos_mensuales'], 2);
    $oi = 'RD$' . number_format($cliente['otros_ingresos'], 2);
    $ah = 'RD$' . number_format($ahorros['total_ahorros'] ?? 0, 2);
    $p = 'RD$' . number_format($prestamos['total_prestamos'] ?? 0, 2);

    if (!$cliente) {
        die('Cliente no encontrado');
    }

    $logo = '/imgs/logo.png'; // Cambiar por la ruta real del logo
    $fecha = date('d/m/Y'); 
    // Crea un nuevo PDF
    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('BRILLASIS');
    $pdf->SetTitle('Detalle del Socio');
    $pdf->SetHeaderData('', 0, 'BRILLASIS', 'Detalle del Socio');
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->AddPage();

    // Configurar fuente
    $pdf->SetFont('helvetica', '', 12);

    // Agregar contenido al PDF

    $html = <<<HTML
    <style>
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 80px;
            height: auto;
        }
        .header h1 {
            margin: 0;
            padding: 0;
        }
        .fecha {
            text-align: right;
            font-size: 12px;
            margin-bottom: 10px;
        }
        .detalle {
            font-size: 12px;
        }
        .detalle strong {
            font-weight: bold;
        }
        .footer {
            text-align: center;
            font-size: 8px;
            margin-top: 30px;
        }
        .table {
            margin: 0 auto; /* Centrar la tabla horizontalmente */
            width: 90%; /* Ajustar ancho general de la tabla */
        }
        .table td {
            padding: 15px;
            vertical-align: top;
        }
        .info-personal {
            text-align: left;
            margin-left: 20px; /* Desplazar la información personal ligeramente a la derecha */
        }
    </style>
    
    <div class="fecha">
        <strong>Fecha:</strong> $fecha
    </div>
    
    <div class="header">
        <img src="$logo" alt="Logo">
        <h1>BRILLASIS</h1>
        <h2>Informe de Socio</h2>
        <h3>Nombre: {$cliente['nombre']} {$cliente['apellido']}</h3>
    </div>
    
    <table  width="100%" class="table"> <!-- border="1" cellpadding="4" cellspacing="0" -->
        <tr>
            <td width="45%">
                <h2>Información Personal:</h2><br>
                <strong>Número de Socio:</strong> {$cliente['numero_socio']}<br>
                <strong>Cédula:</strong> {$cliente['cedula']}<br>
                <strong>Nombre:</strong> {$cliente['nombre']}<br>
                <strong>Apellido:</strong> {$cliente['apellido']}<br>
                <strong>Dirección:</strong> {$cliente['direccion']}<br>
                <strong>Teléfono 1:</strong> {$cliente['telefono1']}<br>
                <strong>Teléfono 2:</strong> {$cliente['telefono2']}<br>
                <strong>Correo Personal:</strong> {$cliente['correo_personal']}<br>
                <strong>Correo Institucional:</strong> {$cliente['correo_institucional']}<br>
            </td>
            <td width="55%">
                <h2>Información Financiera:</h2><br>
                <strong>Ingresos Mensuales:</strong> {$im}<br>
                <strong>Otros Ingresos:</strong> {$oi}<br>
                <strong>Total Ahorrado:</strong> {$ah}<br>
                <strong>Prestamo:</strong> {$p}<br>
                
                <h2>Compañía y Sucursal:</h2><br>
                <strong>Compañía:</strong> {$cliente['compania_nombre']}<br>
                <strong>Sucursal:</strong> {$cliente['sucursal_nombre']}<br>
            </td>
        </tr>
    </table>
    <br><br>
    <div class="footer">
        Este documento es para fines de consulta del detalle de dicho cliente.
    </div>
    HTML;
    


    $pdf->writeHTML($html);

    // Enviar el PDF al navegador
    $pdf->Output("Detalle_Cliente_{$cliente['nombre']}.pdf", 'I');

?>