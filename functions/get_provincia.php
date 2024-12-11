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

    $sucursal_id = $_GET['sucursal_id'] ?? null;

    if (!$sucursal_id) {
        echo json_encode(['success' => false, 'error' => 'ID de sucursal no especificado.']);
        exit;
    }

    try {
        $stmt = $conn->prepare("SELECT provincia FROM sucursal WHERE id = :id");
        $stmt->execute([':id' => $sucursal_id]);
        $sucursal = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($sucursal) {
            echo json_encode(['success' => true, 'provincia' => $sucursal['provincia']]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Sucursal no encontrada.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Error al obtener la provincia: ' . $e->getMessage()]);
    }
?>