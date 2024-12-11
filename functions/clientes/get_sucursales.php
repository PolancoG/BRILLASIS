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

    try {
        $stmt = $conn->prepare("SELECT id, nombre FROM sucursal");
        $stmt->execute();
        $sucursales = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($sucursales);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error al obtener las sucursales: ' . $e->getMessage()]);
    }
?>