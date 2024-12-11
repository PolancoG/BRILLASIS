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
        $stmt = $conn->prepare("
            SELECT c.id, c.numero_socio, c.cedula, c.nombre, s.nombre AS sucursal_nombre
            FROM cliente c
            LEFT JOIN sucursal s ON c.sucursal_id = s.id
        ");
        $stmt->execute();
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($clientes);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error al obtener la lista de clientes: ' . $e->getMessage()]);
    }
?>