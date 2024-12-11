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

    $id = $_POST['id'] ?? null;
    $estado = $_POST['estado'] ?? null;

    if (!$id || !$estado) {
        echo json_encode(['success' => false, 'message' => 'ID y estado son obligatorios.']);
        exit;
    }

    try {
        $stmt = $conn->prepare("UPDATE prestamo SET estado = :estado WHERE id = :id");
        $stmt->execute([':estado' => $estado, ':id' => $id]);

        echo json_encode(['success' => true, 'message' => 'Estado del préstamo actualizado correctamente.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el estado: ' . $e->getMessage()]);
    }

?>