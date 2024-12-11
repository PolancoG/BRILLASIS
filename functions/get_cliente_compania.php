<?php
    //conexion database
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

    $id = $_GET['cliente_id'] ?? null;

    if (!$id) {
        echo json_encode(['error' => 'ID del cliente no especificado']);
        exit;
    }

    try {
        $stmt = $conn->prepare("
            SELECT 
                c.id AS cliente_id, 
                c.nombre AS cliente_nombre, 
                s.id AS sucursal_id, 
                co.id AS compania_id, 
                co.nombre AS compania_nombre, 
                co.interes_fijo 
            FROM cliente c
            JOIN sucursal s ON c.sucursal_id = s.id
            JOIN compania co ON s.compania_id = co.id
            WHERE c.id = :id
        ");
        $stmt->execute([':id' => $id]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cliente) {
            echo json_encode($cliente);
        } else {
            echo json_encode(['error' => 'Cliente no encontrado.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error al obtener datos: ' . $e->getMessage()]);
    }
?>