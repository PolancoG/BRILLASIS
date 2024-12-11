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

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Método no permitido']);
        exit;
    }
    
    $id = $_POST['id'] ?? null;
    $numero_socio = $_POST['numero_socio'] ?? null;
    $cedula = $_POST['cedula'] ?? null;
    $nombre = $_POST['nombre'] ?? null;
    $direccion = $_POST['direccion'] ?? null;
    $lugar_trabajo = $_POST['lugar_trabajo'] ?? null;
    $telefono1 = $_POST['telefono1'] ?? null;
    $telefono2 = $_POST['telefono2'] ?? null;
    $correo_personal = $_POST['correo_personal'] ?? null;
    $correo_institucional = $_POST['correo_institucional'] ?? null;
    $sucursal_id = $_POST['sucursal_id'] ?? null;
    $sexo = $_POST['sexo'] ?? null;
    $estado_civil = $_POST['estado_civil'] ?? null;
    $nacionalidad = $_POST['nacionalidad'] ?? null;
    $ingresos_mensuales = $_POST['ingresos_mensuales'] ?? null;
    $otros_ingresos = $_POST['otros_ingresos'] ?? null;
    $descripcion = $_POST['descripcion'] ?? null;
    
    // Validar campos obligatorios
    if (!$numero_socio || !$cedula || !$nombre || !$direccion || !$telefono1 || !$sexo || !$estado_civil || !$nacionalidad || !$sucursal_id) {
        echo json_encode(['success' => false, 'message' => 'Por favor complete todos los campos obligatorios.']);
        exit;
    }
    
    try {
        if (empty($id)) {
            // Insertar nuevo cliente
            $stmt = $conn->prepare("
                INSERT INTO cliente (numero_socio, cedula, nombre, direccion, lugar_trabajo, telefono1, telefono2, correo_personal, correo_institucional, sucursal_id, sexo, estado_civil, nacionalidad, ingresos_mensuales, otros_ingresos, descripcion) 
                VALUES (:numero_socio, :cedula, :nombre, :direccion, :lugar_trabajo, :telefono1, :telefono2, :correo_personal, :correo_institucional, :sucursal_id, :sexo, :estado_civil, :nacionalidad, :ingresos_mensuales, :otros_ingresos, :descripcion)
            ");
            $stmt->execute([
                ':numero_socio' => $numero_socio,
                ':cedula' => $cedula,
                ':nombre' => $nombre,
                ':direccion' => $direccion,
                ':lugar_trabajo' => $lugar_trabajo,
                ':telefono1' => $telefono1,
                ':telefono2' => $telefono2,
                ':correo_personal' => $correo_personal,
                ':correo_institucional' => $correo_institucional,
                ':sucursal_id' => $sucursal_id,
                ':sexo' => $sexo,
                ':estado_civil' => $estado_civil,
                ':nacionalidad' => $nacionalidad,
                ':ingresos_mensuales' => $ingresos_mensuales,
                ':otros_ingresos' => $otros_ingresos,
                ':descripcion' => $descripcion
            ]);
            echo json_encode(['success' => true, 'message' => 'Cliente agregado exitosamente.']);
        } else {
            // Actualizar cliente existente
            $stmt = $conn->prepare("
                UPDATE cliente SET 
                    numero_socio = :numero_socio, cedula = :cedula, nombre = :nombre, direccion = :direccion, lugar_trabajo = :lugar_trabajo, 
                    telefono1 = :telefono1, telefono2 = :telefono2, correo_personal = :correo_personal, 
                    correo_institucional = :correo_institucional, sucursal_id = :sucursal_id, 
                    sexo = :sexo, estado_civil = :estado_civil, nacionalidad = :nacionalidad, 
                    ingresos_mensuales = :ingresos_mensuales, otros_ingresos = :otros_ingresos, descripcion = :descripcion
                WHERE id = :id
            ");
            $stmt->execute([
                ':numero_socio' => $numero_socio,
                ':cedula' => $cedula,
                ':nombre' => $nombre,
                ':direccion' => $direccion,
                ':lugar_trabajo' => $lugar_trabajo,
                ':telefono1' => $telefono1,
                ':telefono2' => $telefono2,
                ':correo_personal' => $correo_personal,
                ':correo_institucional' => $correo_institucional,
                ':sucursal_id' => $sucursal_id,
                ':sexo' => $sexo,
                ':estado_civil' => $estado_civil,
                ':nacionalidad' => $nacionalidad,
                ':ingresos_mensuales' => $ingresos_mensuales,
                ':otros_ingresos' => $otros_ingresos,
                ':descripcion' => $descripcion,
                ':id' => $id
            ]);
            echo json_encode(['success' => true, 'message' => 'Cliente actualizado exitosamente.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
?>