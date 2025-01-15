<?php
/*
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

    $cliente_id = $_POST['cliente_id'] ?? null;
    $monto = $_POST['monto'] ?? null;

    if (!$cliente_id || !$monto) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
        exit;
    }

    try {
        // Validar que el monto a retirar no sea mayor al ahorro
        $stmt = $conn->prepare("SELECT monto FROM ahorro WHERE cliente_id = :cliente_id");
        $stmt->execute([':cliente_id' => $cliente_id]);
        $ahorro = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$ahorro || $ahorro['monto'] < $monto) {
            echo json_encode(['success' => false, 'message' => 'El monto a retirar no puede ser mayor al ahorro disponible.']);
            exit;
        }

        // Restar el monto al ahorro
        $stmt = $conn->prepare("
            UPDATE ahorro 
            SET monto = monto - :monto, fecha_ahorro = NOW()
            WHERE cliente_id = :cliente_id
        ");
        $stmt->execute([':monto' => $monto, ':cliente_id' => $cliente_id]);

        echo json_encode(['success' => true, 'message' => 'Monto retirado exitosamente.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al procesar el retiro: ' . $e->getMessage()]);
    }
        */
?>

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

    $cliente_id = $_POST['cliente_id'] ?? null;
    $monto = $_POST['monto'] ?? null;
    $usuario_id = $_SESSION['user_id']; // ID del usuario logueado

    if (!$cliente_id || !$monto) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
        exit;
    }

    try {
        // Obtener el ahorro actual del cliente
        $stmt = $conn->prepare("SELECT monto FROM ahorro WHERE cliente_id = :cliente_id");
        $stmt->execute([':cliente_id' => $cliente_id]);
        $ahorro = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$ahorro) {
            echo json_encode(['success' => false, 'message' => 'No se encontró el ahorro del cliente.']);
            exit;
        }

        if ($monto > $ahorro['monto']) {
            echo json_encode(['success' => false, 'message' => 'El monto a retirar no puede ser mayor al ahorro total.']);
            exit;
        }

        // Calcular el ahorro restante
        $ahorro_restante = $ahorro['monto'] - $monto;

        // Actualizar el monto del ahorro
        $stmt = $conn->prepare("UPDATE ahorro SET monto = :ahorro_restante WHERE cliente_id = :cliente_id");
        $stmt->execute([':ahorro_restante' => $ahorro_restante, ':cliente_id' => $cliente_id]);

        // Generar NRC
        $nrc = strtoupper(bin2hex(random_bytes(5))); //'NRC-' .

        // Registrar el recibo
        $stmt = $conn->prepare("
            INSERT INTO recibos_retiros (cliente_id, usuario_id, monto_retirado, ahorro_restante, nrc)
            VALUES (:cliente_id, :usuario_id, :monto_retirado, :ahorro_restante, :nrc)
        ");
        $stmt->execute([
            ':cliente_id' => $cliente_id,
            ':usuario_id' => $usuario_id,
            ':monto_retirado' => $monto,
            ':ahorro_restante' => $ahorro_restante,
            ':nrc' => $nrc
        ]);
        $recibo_id = $conn->lastInsertId();

        echo json_encode([
            'success' => true,
            'message' => 'El retiro se realizó con éxito.',
            'recibo_id' => $recibo_id
        ]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al procesar el retiro: ' . $e->getMessage()]);
    }
?>
