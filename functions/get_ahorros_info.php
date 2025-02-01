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

    // Validar el ID del cliente
    $cliente_id = $_GET['cliente_id'] ?? null;

    if (!$cliente_id) {
        echo json_encode(['success' => false, 'message' => 'ID del cliente no proporcionado.']);
        exit;
    }

    try {
        // Obtener los registros de ahorros del cliente
        $stmt = $conn->prepare("
            SELECT *
            FROM registro_ahorros 
            WHERE cliente_id = :cliente_id 
            ORDER BY fecha_agregado DESC
        ");
        $stmt->execute([':cliente_id' => $cliente_id]);
        $ahorros = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($ahorros) {
            echo json_encode(['success' => true, 'ahorros' => $ahorros]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se encontraron registros de ahorros.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener los datos: ' . $e->getMessage()]);
    }
?>