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
        echo json_encode(['error' => 'ID del cliente no especificado']);
        exit;
    }

    $id = $_GET['id'];

    try {
        // Información del cliente
        $stmt = $conn->prepare("
            SELECT 
                c.id, c.numero_socio, c.cedula, c.nombre, c.apellido, 
                c.direccion, c.lugar_trabajo, c.telefono1, c.telefono2, 
                c.correo_personal, c.correo_institucional, c.sucursal_id, 
                c.sexo, c.estado_civil, c.nacionalidad, 
                c.ingresos_mensuales, c.otros_ingresos, c.descripcion,
                s.nombre AS sucursal_nombre,
                co.nombre AS compania_nombre
            FROM cliente c
            LEFT JOIN sucursal s ON c.sucursal_id = s.id
            LEFT JOIN compania co ON s.compania_id = co.id
            WHERE c.id = :id
        ");
        $stmt->execute([':id' => $id]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        // Información de ahorros
        $stmt = $conn->prepare("SELECT SUM(monto) AS total_ahorros FROM ahorro WHERE cliente_id = :id");
        $stmt->execute([':id' => $id]);
        $ahorros = $stmt->fetch(PDO::FETCH_ASSOC)['total_ahorros'] ?? 0;

        // Información de préstamos
        $stmt = $conn->prepare("SELECT SUM(monto) AS total_prestamos FROM prestamo WHERE cliente_id = :id");
        $stmt->execute([':id' => $id]);
        $prestamos = $stmt->fetch(PDO::FETCH_ASSOC)['total_prestamos'] ?? 0;

        if ($cliente) {
            echo json_encode([
                'cliente' => $cliente,
                'ahorros' => $ahorros,
                'prestamos' => $prestamos
            ]);
        } else {
            echo json_encode(['error' => 'Cliente no encontrado.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error al obtener el detalle del cliente: ' . $e->getMessage()]);
    }
?>