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

    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $rnc = $_POST['rnc'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $interes_fijo = $_POST['interes_fijo'];
    $estado = $_POST['estado'] ?? 'activo'; // Si no se envía, por defecto es "activo"

    try {
        $stmt = $conn->prepare("UPDATE compania SET nombre = ?, rnc = ?, direccion = ?, telefono = ?, correo = ?, interes_fijo = ?, estado = ? WHERE id = ?");
        $stmt->execute([$nombre, $rnc, $direccion, $telefono, $correo, $interes_fijo, $estado, $id]);
    
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

?>
