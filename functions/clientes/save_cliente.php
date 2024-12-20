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
    $image_cedula = $_FILES['image_cedula']['name'] ?? null;
    $contrato = $_FILES['contrato']['name'] ?? null;

    // Validar campos obligatorios
    if (!$numero_socio || !$cedula || !$nombre || !$direccion || !$telefono1 || !$sexo || !$estado_civil || !$nacionalidad || !$sucursal_id) {
        echo json_encode(['success' => false, 'message' => 'Por favor complete todos los campos obligatorios.']);
        exit;
    }
    
    try {
        if (empty($id)) {

         /*   if (!empty($_FILES['image_cedula']['tmp_name'])) {
                $image_cedula = file_get_contents($_FILES['image_cedula']['tmp_name']); // Leer archivo en binario
                $image_cedula_type = $_FILES['image_cedula']['type']; // Tipo MIME
            }
            
            if (!empty($_FILES['contrato']['tmp_name'])) {
                $contrato = file_get_contents($_FILES['contrato']['tmp_name']);
                $contrato_type = $_FILES['contrato']['type'];
            } */

            //Esto lo quite de al lado de descripcion 
            //image_cedula, image_cedula_type, contrato, contrato_type
            //:image_cedula, :image_cedula_type, :contrato, :contrato_type
            $stmt = $conn->prepare("
                INSERT INTO cliente (
                    numero_socio, cedula, nombre, direccion, lugar_trabajo, telefono1, telefono2, correo_personal, correo_institucional, 
                    sucursal_id, sexo, estado_civil, nacionalidad, ingresos_mensuales, otros_ingresos, descripcion
                    
                ) VALUES (
                    :numero_socio, :cedula, :nombre, :direccion, :lugar_trabajo, :telefono1, :telefono2, :correo_personal, :correo_institucional, 
                    :sucursal_id, :sexo, :estado_civil, :nacionalidad, :ingresos_mensuales, :otros_ingresos, :descripcion
                    
                )
            ");

            // $stmt = $conn->prepare("
            //     INSERT INTO cliente (numero_socio, cedula, nombre, direccion, lugar_trabajo, telefono1, telefono2, correo_personal, correo_institucional, sucursal_id, sexo, estado_civil, nacionalidad, ingresos_mensuales, otros_ingresos, descripcion, image_cedula, contrato) 
            //     VALUES (:numero_socio, :cedula, :nombre, :direccion, :lugar_trabajo, :telefono1, :telefono2, :correo_personal, :correo_institucional, :sucursal_id, :sexo, :estado_civil, :nacionalidad, :ingresos_mensuales, :otros_ingresos, :descripcion, :image_cedula, :contrato)
            // ");
           /* $stmt->execute([
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
                ':image_cedula' => $image_cedula,
                ':contrato' => $contrato
            ]); */

            //Esto lo saque de mas abajo
           /* ':image_cedula' => $image_cedula,
                ':image_cedula_type' => $image_cedula_type,
                ':contrato' => $contrato,
                ':contrato_type' => $contrato_type */

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
                
            ]);
            echo json_encode(['success' => true, 'message' => 'Cliente agregado exitosamente.']);
        } else {
            $updateFields = "
                numero_socio = :numero_socio, cedula = :cedula, nombre = :nombre, direccion = :direccion, lugar_trabajo = :lugar_trabajo, 
                telefono1 = :telefono1, telefono2 = :telefono2, correo_personal = :correo_personal, 
                correo_institucional = :correo_institucional, sucursal_id = :sucursal_id, 
                sexo = :sexo, estado_civil = :estado_civil, nacionalidad = :nacionalidad, 
                ingresos_mensuales = :ingresos_mensuales, otros_ingresos = :otros_ingresos, descripcion = :descripcion
            ";

           // if ($image_cedula) $updateFields .= ", image_cedula = :image_cedula";
           // if ($contrato) $updateFields .= ", contrato = :contrato";

            $stmt = $conn->prepare("
                UPDATE cliente SET $updateFields WHERE id = :id
            ");
            $params = [
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
            ];
        
           // if ($image_cedula) $params[':image_cedula'] = $image_cedula;
            //if ($contrato) $params[':contrato'] = $contrato;
        
            $stmt->execute($params);
        
            echo json_encode(['success' => true, 'message' => 'Cliente actualizado exitosamente.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
?>