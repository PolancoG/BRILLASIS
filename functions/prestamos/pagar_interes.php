
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

    $cuota_id = $_POST['cuota_id'] ?? null;

    if (!$cuota_id) {
        echo json_encode(['success' => false, 'message' => 'ID de cuota no proporcionado.']);
        exit;
    }

    try {
        $conn->beginTransaction();

        // Obtener información de la cuota
       /* $stmt = $conn->prepare("
            SELECT 
                ta.*, 
                p.cliente_id, 
                c.compania_id, 
                co.nombre AS compania_nombre
            FROM tabla_amortizacion ta
            INNER JOIN prestamo p ON ta.prestamo_id = p.id
            INNER JOIN cliente c ON p.cliente_id = c.id
            INNER JOIN compania co ON c.compania_id = co.id
            WHERE ta.id = :cuota_id
        ");
        $stmt->execute([':cuota_id' => $cuota_id]); */

        $stmt = $conn->prepare("
            SELECT 
                ta.*, 
                p.cliente_id, 
                s.compania_id, 
                co.nombre AS compania_nombre
            FROM tabla_amortizacion ta
            INNER JOIN prestamo p ON ta.prestamo_id = p.id
            INNER JOIN cliente c ON p.cliente_id = c.id
            INNER JOIN sucursal s ON c.sucursal_id = s.id
            INNER JOIN compania co ON s.compania_id = co.id
            WHERE ta.id = :cuota_id
        ");
        $stmt->execute([':cuota_id' => $cuota_id]);
        $cuota = $stmt->fetch(PDO::FETCH_ASSOC); 
    
        if (!$cuota) {
            echo json_encode(['success' => false, 'message' => 'La cuota no existe.']);
            $conn->rollBack();
            exit;
        }

        if ($compania !== 'Brillacoop') {
            echo json_encode(['success' => false, 'message' => 'Solo los clientes de Brillacoop pueden pagar intereses.']);
            $conn->rollBack();
            exit;
        }

        // Verificar si el interés ya está pagado
        if ((float)$cuota['interes'] === 0) {
            echo json_encode(['success' => false, 'message' => 'El interés ya está pagado para esta cuota.']);
            $conn->rollBack();
            exit;
        }

        // Registrar el pago del interés
        $stmt = $conn->prepare("
            UPDATE tabla_amortizacion 
            SET interes = 0, estado = CASE WHEN capital = 0 THEN 'pagada' ELSE estado END 
            WHERE id = :cuota_id
        ");
        $stmt->execute([':cuota_id' => $cuota_id]);

        // Actualizar tabla de "interes_recaudado" para el resumen del dashboard
        $stmt = $conn->prepare("
            INSERT INTO interes_recaudado (cliente_id, prestamo_id, monto_interes, fecha_pago)
            VALUES (:cliente_id, :prestamo_id, :monto_interes, NOW())
        ");
        $stmt->execute([
            ':cliente_id' => $cuota['cliente_id'],
            ':prestamo_id' => $cuota['prestamo_id'],
            ':monto_interes' => $cuota['interes'],
        ]);

        $conn->commit();

        echo json_encode(['success' => true, 'message' => 'Pago de interés registrado correctamente.']);
    } catch (PDOException $e) {
        $conn->rollBack();
        echo json_encode(['success' => false, 'message' => 'Error al procesar el pago de interés: ' . $e->getMessage()]);
    }
?>