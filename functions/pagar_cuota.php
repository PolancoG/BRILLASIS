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
    echo "Error de conexión: " . $e->getMessage();
    die();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cuota_id = $_POST['cuota_id'] ?? null;
    $monto_pago = $_POST['monto_pago'] ?? null;
    $metodo_pago = $_POST['metodo_pago'] ?? null;

    if (!$cuota_id || !$monto_pago || !$metodo_pago) {
        echo json_encode([
            'success' => false,
            'message' => 'Todos los campos son obligatorios.'
        ]);
        exit;
    }

    try {
        $conn->beginTransaction();

        // Actualizar estado de la cuota en la tabla "tabla_amortizacion"
        $stmt = $conn->prepare("UPDATE tabla_amortizacion SET estado = 'pagada' WHERE id = :cuota_id");
        $stmt->execute([':cuota_id' => $cuota_id]);

        // Registrar el pago en la tabla "pagos_cuotas"
        $stmt = $conn->prepare("INSERT INTO pagos_cuotas (cuota_id, monto, metodo_pago, fecha_pago) 
                                VALUES (:cuota_id, :monto_pago, :metodo_pago, NOW())");
        $stmt->execute([
            ':cuota_id' => $cuota_id,
            ':monto_pago' => $monto_pago,
            ':metodo_pago' => $metodo_pago
        ]);

        $conn->commit();

        echo json_encode([
            'success' => true,
            'prestamo_id' => $_POST['prestamo_id'] // Enviar ID del préstamo para recargar amortización
        ]);
    } catch (PDOException $e) {
        $conn->rollBack();
        echo json_encode([
            'success' => false,
            'message' => 'Error al registrar el pago: ' . $e->getMessage()
        ]);
    }
}
?>

