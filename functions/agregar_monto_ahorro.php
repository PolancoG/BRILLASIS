<?php
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

    $cliente_id = $_POST['cliente_id'] ?? null;
    $monto = $_POST['monto'] ?? null;

    if (!$cliente_id || !$monto) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
        exit;
    }

    try {
        // Sumar el nuevo monto al ahorro existente
        $stmt = $conn->prepare("
            UPDATE ahorro 
            SET monto = monto + :monto, fecha_ahorro = NOW()
            WHERE cliente_id = :cliente_id
        ");
        $stmt->execute([':monto' => $monto, ':cliente_id' => $cliente_id]);

        echo json_encode(['success' => true, 'message' => 'Monto agregado al ahorro exitosamente.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al agregar el monto: ' . $e->getMessage()]);
    }
?>