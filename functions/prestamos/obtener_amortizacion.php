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

// Obtener el ID del préstamo desde el cliente
$prestamo_id = $_GET['prestamo_id'] ?? null;

if (!$prestamo_id) {
    echo json_encode(['success' => false, 'message' => 'El ID del préstamo no fue proporcionado.']);
    exit;
}

try {
    // Consultar las cuotas de amortización del préstamo
    $stmt = $conn->prepare("SELECT * FROM tabla_amortizacion WHERE prestamo_id = :prestamo_id");
    $stmt->execute([':prestamo_id' => $prestamo_id]);
    $amortizacion = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'amortizacion' => $amortizacion]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error al obtener los datos: ' . $e->getMessage()]);
}
?>
