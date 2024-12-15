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

    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo json_encode(['error' => 'ID de cliente no especificado']);
        exit;
    }

    $id = $_GET['id'];

    try {

        $stmt = $conn->prepare("
            SELECT 
                c.id, c.numero_socio, c.cedula, c.nombre, c.direccion, 
                c.lugar_trabajo, c.telefono1, c.telefono2, 
                c.correo_personal, c.correo_institucional, c.sucursal_id, 
                c.sexo, c.estado_civil, c.nacionalidad, c.descripcion,
                c.ingresos_mensuales, c.otros_ingresos, c.image_cedula, c.contrato,
                s.nombre AS sucursal_nombre
            FROM cliente c
            LEFT JOIN sucursal s ON c.sucursal_id = s.id
            WHERE c.id = :id
        ");

        $stmt->execute([':id' => $id]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cliente) {
            echo json_encode(['cliente' => $cliente]);
        } else {
            echo json_encode(['error' => 'Cliente no encontrado.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error al obtener el cliente: ' . $e->getMessage()]);
    }
?>