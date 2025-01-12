<?php
header('Content-Type: application/json');

// Conexión a la base de datos
$host = 'localhost';
$dbname = 'cooplight';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error de conexión: ' . $e->getMessage()
    ]);
    exit;
}

// Verificar el método y los datos recibidos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prestamo_id = $_POST['prestamo_id'] ?? null;

    if (empty($prestamo_id)) {
        echo json_encode([
            'success' => false,
            'message' => 'No se recibió el ID del préstamo.'
        ]);
        exit;
    }

    try {
        // Recuperar las cuotas desde la tabla_amortizacion
       /* $stmt = $conn->prepare("
            SELECT cuota_numero, fecha_pago, monto_cuota, interes, capital, saldo_restante
            FROM tabla_amortizacion
            WHERE prestamo_id = :prestamo_id
            ORDER BY cuota_numero ASC
        "); */
        $stmt = $conn->prepare("
            SELECT 
                cuota_numero, 
                fecha_pago, 
                monto_cuota, 
                interes, 
                capital, 
                saldo_restante, 
                estado 
            FROM 
                tabla_amortizacion 
            WHERE 
                prestamo_id = :prestamo_id
            ORDER BY cuota_numero ASC
        ");

        $stmt->bindParam(':prestamo_id', $prestamo_id, PDO::PARAM_INT);
        $stmt->execute();

        $cuotas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($cuotas) {
            echo json_encode([
                'success' => true,
                'cuotas' => $cuotas
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No se encontraron cuotas para este préstamo.'
            ]);
        }
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error al recuperar las cuotas: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido.'
    ]);
}
?>