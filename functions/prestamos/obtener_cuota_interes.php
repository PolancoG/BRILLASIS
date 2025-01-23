<?php
    session_start();
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

    $cuota_id = $_GET['cuota_id'] ?? null;

    if (!$cuota_id) {
        echo json_encode(['success' => false, 'message' => 'ID de cuota no proporcionado.']);
        exit;
    }

    try {
        $stmt = $conn->prepare("SELECT interes FROM tabla_amortizacion WHERE id = :cuota_id");
        $stmt->execute([':cuota_id' => $cuota_id]);
        $cuota = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cuota) {
            echo json_encode(['success' => true, 'interes' => $cuota['interes']]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se encontró la cuota.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
?>

