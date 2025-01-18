<?php
session_start();
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
    $stmt = $conn->prepare("SELECT * FROM tabla_amortizacion WHERE id = :cuota_id");
    $stmt->execute([':cuota_id' => $cuota_id]);
    $cuota = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cuota) {
        echo json_encode(['success' => false, 'message' => 'Cuota no encontrada.']);
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM prestamo WHERE id = :prestamo_id");
    $stmt->execute([':prestamo_id' => $cuota['prestamo_id']]);
    $prestamo = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare("SELECT monto FROM ahorro WHERE cliente_id = :cliente_id");
    $stmt->execute([':cliente_id' => $prestamo['cliente_id']]);
    $ahorro = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'cuota' => $cuota, 'prestamo' => $prestamo, 'ahorro' => $ahorro]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error al obtener los datos: ' . $e->getMessage()]);
}
?>
