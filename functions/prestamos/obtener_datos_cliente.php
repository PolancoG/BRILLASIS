<?php
    // Conexión a la base de datos
    $host = 'localhost';
    $dbname = 'cooplight';
    $username = 'root';
    $password = '';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error de conexión: ' . $e->getMessage()]);
        exit;
    }

    // Validar los parámetros recibidos
    $cuota_id = $_GET['cuota_id'] ?? null;

    if (!$cuota_id) {
        echo json_encode(['success' => false, 'message' => 'Cuota ID no proporcionado.']);
        exit;
    }

    try {
        // Obtener datos del cliente, sucursal y compañía
       /* $stmt = $conn->prepare("
            SELECT 
                c.id AS cliente_id, 
                c.nombre AS cliente_nombre, 
                co.nombre AS compania, 
                ta.interes
            FROM tabla_amortizacion ta
            JOIN prestamo p ON ta.prestamo_id = p.id
            JOIN cliente c ON p.cliente_id = c.id
            JOIN sucursal s ON c.sucursal_id = s.id
            JOIN compania co ON s.compania_id = co.id
            WHERE ta.id = :cuota_id
        ");
        $stmt->execute([':cuota_id' => $cuota_id]); */

        $stmt = $conn->prepare("
            SELECT 
                c.id AS cliente_id, 
                c.nombre AS cliente_nombre, 
                co.nombre AS compania, 
                ta.interes
            FROM tabla_amortizacion ta
            JOIN prestamo p ON ta.prestamo_id = p.id
            JOIN cliente c ON p.cliente_id = c.id
            JOIN sucursal s ON c.sucursal_id = s.id
            JOIN compania co ON s.compania_id = co.id
            WHERE ta.id = :cuota_id
        ");
        $stmt->execute([':cuota_id' => $cuota_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode([
                'success' => true,
                'cliente' => $result['cliente_nombre'],
                'compania' => $result['compania'],
                'interes' => $result['interes'],
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se encontró información para la cuota.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener los datos: ' . $e->getMessage()]);
    }
?>