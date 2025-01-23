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

    $stmt = $conn->prepare("SELECT saldo_restante FROM tabla_amortizacion WHERE id = :cuota_id");
    $stmt->execute([':cuota_id' => $cuota_id]);
    $cuota = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cuota) {
        echo json_encode(['success' => true, 'saldo_restante' => number_format($cuota['saldo_restante'], 2, '.', '')]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Cuota no encontrada.']);
    }
?>
