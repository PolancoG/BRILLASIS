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

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $prestamo_id = $_GET['prestamo_id'] ?? null;

        if (empty($prestamo_id)) {
            echo json_encode([
                'success' => false,
                'message' => 'El ID del préstamo es obligatorio.'
            ]);
            exit;
        }

        try {
            // Recuperar el préstamo
            $stmt = $conn->prepare("SELECT * FROM prestamo WHERE id = :prestamo_id");
            $stmt->execute([':prestamo_id' => $prestamo_id]);
            $prestamo = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$prestamo) {
                echo json_encode([
                    'success' => false,
                    'message' => 'El préstamo no existe.'
                ]);
                exit;
            }

            // Recuperar la tabla de amortización
            $stmt = $conn->prepare("
                SELECT cuota_numero, fecha_pago, monto_cuota, interes, capital, saldo_restante 
                FROM tabla_amortizacion 
                WHERE prestamo_id = :prestamo_id
                ORDER BY cuota_numero ASC
            ");
            $stmt->execute([':prestamo_id' => $prestamo_id]);
            $amortizacion = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!$amortizacion) {
                echo json_encode([
                    'success' => false,
                    'message' => 'No se encontró la tabla de amortización para este préstamo.'
                ]);
                exit;
            }

            // Devolver datos en formato JSON
            echo json_encode([
                'success' => true,
                'prestamo' => $prestamo,
                'amortizacion' => $amortizacion
            ]);
            exit;

        } catch (PDOException $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error al recuperar la tabla de amortización: ' . $e->getMessage()
            ]);
            exit;
        }
    }
?>
