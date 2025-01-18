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

    // Validar método de la solicitud
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Método no permitido']);
        exit;
    }

    // Recepción de datos
    $cuota_id = $_POST['cuota_id'] ?? null;
    $monto_pago = $_POST['monto_pago'] ?? null;
    $tipo_pago = $_POST['tipo_pago'] ?? null; // Puede ser 'cuota', 'capital' o 'interes'

    if (!$cuota_id || !$monto_pago || !$tipo_pago) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
        exit;
    }

    try {
        $conn->beginTransaction();

        // Obtener datos de la cuota
        $stmt = $conn->prepare("SELECT * FROM tabla_amortizacion WHERE id = :cuota_id");
        $stmt->execute([':cuota_id' => $cuota_id]);
        $cuota = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$cuota) {
            echo json_encode(['success' => false, 'message' => 'La cuota no existe.']);
            $conn->rollBack();
            exit;
        }

        $prestamo_id = $cuota['prestamo_id'];

        if ($tipo_pago === 'cuota') {
            // Actualizar el estado de la cuota a 'pagada'
            $stmt = $conn->prepare("UPDATE tabla_amortizacion SET estado = 'pagada' WHERE id = :cuota_id");
            $stmt->execute([':cuota_id' => $cuota_id]);

            // Registrar el pago en la tabla pagos_cuotas
            $stmt = $conn->prepare("INSERT INTO pagos_cuotas (prestamo_id, cuota_numero, monto_pago, metodo_pago, fecha_pago) 
                                    VALUES (:prestamo_id, :cuota_numero, :monto_pago, 'efectivo', NOW())");
            $stmt->execute([
                ':prestamo_id' => $prestamo_id,
                ':cuota_numero' => $cuota['cuota_numero'],
                ':monto_pago' => $monto_pago
            ]);
        } elseif ($tipo_pago === 'capital') {
            // Abonar al capital
            $nuevo_capital = $cuota['saldo_restante'] - $monto_pago;

            if ($nuevo_capital < 0) {
                echo json_encode(['success' => false, 'message' => 'El monto abonado supera el saldo restante.']);
                $conn->rollBack();
                exit;
            }

            // Actualizar saldo restante
            $stmt = $conn->prepare("UPDATE tabla_amortizacion SET saldo_restante = :nuevo_capital WHERE id = :cuota_id");
            $stmt->execute([
                ':nuevo_capital' => $nuevo_capital,
                ':cuota_id' => $cuota_id
            ]);

            // Registrar el abono en la tabla pagos_cuotas
            $stmt = $conn->prepare("INSERT INTO pagos_cuotas (prestamo_id, cuota_numero, monto_pago, metodo_pago, fecha_pago) 
                                    VALUES (:prestamo_id, :cuota_numero, :monto_pago, 'abono', NOW())");
            $stmt->execute([
                ':prestamo_id' => $prestamo_id,
                ':cuota_numero' => $cuota['cuota_numero'],
                ':monto_pago' => $monto_pago
            ]);

            // Recalcular la tabla de amortización con el nuevo capital
            // Obtener el plazo restante
            $stmt = $conn->prepare("SELECT COUNT(*) AS cuotas_pendientes FROM tabla_amortizacion WHERE prestamo_id = :prestamo_id AND estado = 'pendiente'");
            $stmt->execute([':prestamo_id' => $prestamo_id]);
            $cuotas_pendientes = $stmt->fetch(PDO::FETCH_ASSOC)['cuotas_pendientes'];

            // Generar nueva tabla de amortización
            $nueva_cuota_monto = $nuevo_capital / $cuotas_pendientes;
            $stmt = $conn->prepare("UPDATE tabla_amortizacion SET monto_cuota = :monto_cuota WHERE prestamo_id = :prestamo_id AND estado = 'pendiente'");
            $stmt->execute([
                ':monto_cuota' => $nueva_cuota_monto,
                ':prestamo_id' => $prestamo_id
            ]);
        } elseif ($tipo_pago === 'interes') {
            // Registrar solo el pago de interés
            $stmt = $conn->prepare("INSERT INTO pagos_cuotas (prestamo_id, cuota_numero, monto_pago, metodo_pago, fecha_pago) 
                                    VALUES (:prestamo_id, :cuota_numero, :monto_pago, 'interes', NOW())");
            $stmt->execute([
                ':prestamo_id' => $prestamo_id,
                ':cuota_numero' => $cuota['cuota_numero'],
                ':monto_pago' => $monto_pago
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Tipo de pago inválido.']);
            $conn->rollBack();
            exit;
        }

        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Pago procesado correctamente.']);
    } catch (PDOException $e) {
        $conn->rollBack();
        echo json_encode(['success' => false, 'message' => 'Error al procesar el pago: ' . $e->getMessage()]);
    }
?>
