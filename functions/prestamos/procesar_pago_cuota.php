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
        echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
        exit;
    }

    // Recepción de datos
    $cuota_id = $_POST['cuota_id'] ?? null;
    $metodo_pago = $_POST['metodo_pago'] ?? null;

    if (!$cuota_id || !$metodo_pago) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
        exit;
    }

    try {
        $conn->beginTransaction();

        // Obtener datos de la cuota actual
        $stmt = $conn->prepare("SELECT * FROM tabla_amortizacion WHERE id = :cuota_id");
        $stmt->execute([':cuota_id' => $cuota_id]);
        $cuota = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$cuota) {
            echo json_encode(['success' => false, 'message' => 'La cuota no existe.']);
            $conn->rollBack();
            exit;
        }

        // Verificar si la cuota ya está pagada
        if ($cuota['estado'] === 'pagada') {
            echo json_encode(['success' => false, 'message' => 'La cuota ya está pagada.']);
            $conn->rollBack();
            exit;
        }

        // Verificar que todas las cuotas anteriores estén pagadas
        $stmt = $conn->prepare("SELECT * FROM tabla_amortizacion WHERE prestamo_id = :prestamo_id AND cuota_numero < :cuota_numero AND estado = 'pendiente'");
        $stmt->execute([
            ':prestamo_id' => $cuota['prestamo_id'],
            ':cuota_numero' => $cuota['cuota_numero']
        ]);
        $cuotas_pendientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($cuotas_pendientes)) {
            echo json_encode(['success' => false, 'message' => 'Debe pagar la/las cuotas anterior(es) antes de continuar.']);
            $conn->rollBack();
            exit;
        }

        // Obtener el préstamo asociado
        $stmt = $conn->prepare("SELECT * FROM prestamo WHERE id = :prestamo_id");
        $stmt->execute([':prestamo_id' => $cuota['prestamo_id']]);
        $prestamo = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$prestamo) {
            echo json_encode(['success' => false, 'message' => 'El préstamo asociado no existe.']);
            $conn->rollBack();
            exit;
        }

        // Si el método de pago es "ahorro", validar el saldo
        if ($metodo_pago === 'ahorro') {
            $stmt = $conn->prepare("SELECT monto FROM ahorro WHERE cliente_id = :cliente_id");
            $stmt->execute([':cliente_id' => $prestamo['cliente_id']]);
            $ahorro = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$ahorro) {
                echo json_encode(['success' => false, 'message' => 'El cliente no tiene una cuenta de ahorro asociada.']);
                $conn->rollBack();
                exit;
            }

            if ($ahorro['monto'] < $cuota['monto_cuota']) {
                echo json_encode(['success' => false, 'message' => 'El saldo de ahorro es insuficiente para realizar el pago.']);
                $conn->rollBack();
                exit;
            }

            // Restar el monto de la cuota del saldo de ahorro
            $nuevo_saldo = $ahorro['monto'] - $cuota['monto_cuota'];
            $stmt = $conn->prepare("UPDATE ahorro SET monto = :nuevo_saldo WHERE cliente_id = :cliente_id");
            $stmt->execute([':nuevo_saldo' => $nuevo_saldo, ':cliente_id' => $prestamo['cliente_id']]);
        }

        // Actualizar el estado de la cuota a "pagada"
        $stmt = $conn->prepare("UPDATE tabla_amortizacion SET estado = 'pagada' WHERE id = :cuota_id");
        $stmt->execute([':cuota_id' => $cuota_id]);

         // Registrar el interés recaudado en la tabla "interes_recaudado"
         $interes_pagado = $cuota['interes'];
         $stmt = $conn->prepare("INSERT INTO interes_recaudado (prestamo_id, cuota_numero, monto_interes, fecha_recaudo) 
                                 VALUES (:prestamo_id, :cuota_numero, :monto_interes, NOW())");
         $stmt->execute([
             ':prestamo_id' => $cuota['prestamo_id'],
             ':cuota_numero' => $cuota['cuota_numero'],
             ':monto_interes' => $interes_pagado
         ]);

        // Registrar el pago en la tabla "pagos_cuotas"
        $stmt = $conn->prepare("INSERT INTO pagos_cuotas (prestamo_id, cuota_numero, monto_pago, metodo_pago, fecha_pago) 
                                VALUES (:prestamo_id, :cuota_numero, :monto_pago, :metodo_pago, NOW())");
        $stmt->execute([
            ':prestamo_id' => $cuota['prestamo_id'],
            ':cuota_numero' => $cuota['cuota_numero'],
            ':monto_pago' => $cuota['monto_cuota'],
            ':metodo_pago' => $metodo_pago
        ]);

        // Verificar si todas las cuotas del préstamo están pagadas
        $stmt = $conn->prepare("SELECT COUNT(*) AS cuotas_pendientes FROM tabla_amortizacion WHERE prestamo_id = :prestamo_id AND estado = 'pendiente'");
        $stmt->execute([':prestamo_id' => $cuota['prestamo_id']]);
        $cuotas_pendientes = $stmt->fetch(PDO::FETCH_ASSOC)['cuotas_pendientes'];

        if ($cuotas_pendientes == 0) {
            // Actualizar el estado del préstamo a "activo_terminado"
            $stmt = $conn->prepare("UPDATE prestamo SET estado = 'activo_terminado' WHERE id = :prestamo_id");
            $stmt->execute([':prestamo_id' => $cuota['prestamo_id']]);
        }

        // Verificar si hay dos cuotas vencidas
        $stmt = $conn->prepare("SELECT * FROM tabla_amortizacion WHERE prestamo_id = :prestamo_id AND estado = 'pendiente' AND fecha_pago < NOW()");
        $stmt->execute([':prestamo_id' => $cuota['prestamo_id']]);
        $cuotas_vencidas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($cuotas_vencidas) >= 2) {
            // Verificar si la segunda cuota vencida tiene más de 10 días desde su fecha de vencimiento
            $segunda_cuota_vencida = $cuotas_vencidas[1];
            $fecha_vencimiento_segunda = new DateTime($segunda_cuota_vencida['fecha_pago']);
            $fecha_actual = new DateTime();

            $diferencia_dias = $fecha_vencimiento_segunda->diff($fecha_actual)->days;

            if ($diferencia_dias > 10) {
                // Actualizar el estado del préstamo a "activo_problemas"
                $stmt = $conn->prepare("UPDATE prestamo SET estado = 'activo_problemas' WHERE id = :prestamo_id");
                $stmt->execute([':prestamo_id' => $cuota['prestamo_id']]);
            }
        }

        $conn->commit();

        echo json_encode(['success' => true, 'message' => 'Pago procesado correctamente.']);
    } catch (PDOException $e) {
        $conn->rollBack();
        echo json_encode(['success' => false, 'message' => 'Error al procesar el pago: ' . $e->getMessage()]);
    }
?>
