<?php
    /*session_start();
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
    $monto_abono = $_POST['monto_abono'] ?? null;

    if (!$cuota_id || !$monto_abono || $monto_abono <= 0) {
        echo json_encode(['success' => false, 'message' => 'Datos inválidos para el abono.']);
        exit;
    }

    try {
        $conn->beginTransaction();

        $stmt = $conn->prepare("SELECT * FROM tabla_amortizacion WHERE id = :cuota_id");
        $stmt->execute([':cuota_id' => $cuota_id]);
        $cuota = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$cuota) {
            echo json_encode(['success' => false, 'message' => 'Cuota no encontrada.']);
            $conn->rollBack();
            exit;
        }

        $nuevo_saldo = $cuota['saldo_restante'] - $monto_abono;

        if ($nuevo_saldo < 0) {
            echo json_encode(['success' => false, 'message' => 'El abono supera el saldo restante.']);
            $conn->rollBack();
            exit;
        }

        $stmt = $conn->prepare("UPDATE tabla_amortizacion SET saldo_restante = :nuevo_saldo WHERE id = :cuota_id");
        $stmt->execute([':nuevo_saldo' => $nuevo_saldo, ':cuota_id' => $cuota_id]);

        $stmt = $conn->prepare("INSERT INTO abonos_capital (cuota_id, monto, fecha) VALUES (:cuota_id, :monto, NOW())");
        $stmt->execute([':cuota_id' => $cuota_id, ':monto' => $monto_abono]);

        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Abono al capital procesado correctamente.']);
    } catch (PDOException $e) {
        $conn->rollBack();
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    } */
?>
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
    $monto_abono = $_POST['monto_abono'] ?? null;

    if (!$cuota_id || !$monto_abono || $monto_abono <= 0) {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos o inválidos.']);
        exit;
    }

    try {
        $conn->beginTransaction();

        // Actualizar el saldo restante de la cuota
        $stmt = $conn->prepare("UPDATE tabla_amortizacion SET saldo_restante = saldo_restante - :monto_abono WHERE id = :cuota_id");
        $stmt->execute([':monto_abono' => $monto_abono, ':cuota_id' => $cuota_id]);

        // Generar nueva tabla de amortización
        require_once 'generar_nueva_amortizacion.php'; // Reutilizar lógica existente para regenerar tabla

        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Abono al capital realizado correctamente.']);
    } catch (PDOException $e) {
        $conn->rollBack();
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
?>
