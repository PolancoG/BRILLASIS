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
        echo json_encode(['success' => false, 'message' => 'Error de conexión: ' . $e->getMessage()]);
        die();
    }

    // Función para generar el número de socio
    function generarNumeroSocio($conn) {
        $añoActual = date('Y'); // Obtener el año actual
        $prefijo = $añoActual . '-'; // Prefijo con el año actual

        // Consulta para obtener el último número de socio generado en el año actual
        $stmt = $conn->prepare("SELECT numero_socio FROM cliente WHERE numero_socio LIKE :prefijo ORDER BY numero_socio DESC LIMIT 1");
        $stmt->execute([':prefijo' => $prefijo . '%']);
        $ultimoSocio = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($ultimoSocio) {
            $ultimoIncremento = (int)substr($ultimoSocio['numero_socio'], -5);
            $nuevoIncremento = $ultimoIncremento + 1;
        } else {
            $nuevoIncremento = 1; // Si no hay registros para el año actual, empezar desde 1
        }

        return $prefijo . str_pad($nuevoIncremento, 5, '0', STR_PAD_LEFT);
    }

    // Funciones auxiliares
    function guardarArchivo($file, $directorioDestino) {
        if (!is_dir($directorioDestino)) {
            mkdir($directorioDestino, 0777, true);
        }

        $nombreArchivo = uniqid() . '_' . basename($file['name']);
        $rutaArchivo = $directorioDestino . '/' . $nombreArchivo;

        if (move_uploaded_file($file['tmp_name'], $rutaArchivo)) {
            return $rutaArchivo;
        }
        return null;
    }

    // Validación del método
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Método no permitido']);
        exit;
    }

    // Recepción de datos del formulario
    $id = $_POST['id'] ?? null;
    $numeroSocio = empty($id) ? generarNumeroSocio($conn) : null;
    $cedula = $_POST['cedula'] ?? null;
    $nombre = $_POST['nombre'] ?? null;
    $apellido = $_POST['apellido'] ?? null;
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

    // Manejo de archivos
    $imageCedula = $_FILES['image_cedula'] ?? null;
    $contrato = $_FILES['contrato'] ?? null;
    $rutaCedula = null;
    $rutaContrato = null;
    $maxFileSize = 1048576; // 1MB en bytes

    $estado = $_POST['estado'] ?? 'activo'; // Por defecto 'activo' si no se envía

    // Validación de campos obligatorios
    if (!$cedula || !$nombre || !$direccion || !$telefono1 || !$sexo || !$estado_civil || !$nacionalidad || !$sucursal_id || !$imageCedula || !$contrato) {
        echo json_encode(['success' => false, 'message' => 'Por favor complete todos los campos obligatorios.']);
        exit;
    }

    try {
        // Validar cédula única
        $stmt = $conn->prepare("SELECT id FROM cliente WHERE cedula = :cedula AND id != :id");
        $stmt->execute([':cedula' => $cedula, ':id' => $id ?? 0]);
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => false, 'message' => 'La cédula ingresada ya está registrada en otro cliente.']);
            exit;
        }

        if (empty($id)) {
            // Subir archivos solo si es un nuevo cliente
            if ($imageCedula && $imageCedula['error'] === UPLOAD_ERR_OK) {
                if ($imageCedula['size'] > $maxFileSize) {
                    echo json_encode(['success' => false, 'message' => 'La imagen de la cédula no debe exceder 1MB.']);
                    exit;
                }
                $rutaCedula = guardarArchivo($imageCedula, '../uploads/cedulas');
            }

            if ($contrato && $contrato['error'] === UPLOAD_ERR_OK) {
                if ($contrato['size'] > $maxFileSize) {
                    echo json_encode(['success' => false, 'message' => 'El formulario no debe exceder 1MB.']);
                    exit;
                }
                $rutaContrato = guardarArchivo($contrato, '../uploads/contratos');
            }

            $stmt = $conn->prepare("
                INSERT INTO cliente (
                    numero_socio, cedula, nombre, apellido, direccion, lugar_trabajo, telefono1, telefono2, correo_personal, correo_institucional, 
                    sucursal_id, sexo, estado_civil, nacionalidad, ingresos_mensuales, otros_ingresos, descripcion, image_cedula, contrato, estado
                ) VALUES (
                    :numero_socio, :cedula, :nombre, :apellido, :direccion, :lugar_trabajo, :telefono1, :telefono2, :correo_personal, :correo_institucional, 
                    :sucursal_id, :sexo, :estado_civil, :nacionalidad, :ingresos_mensuales, :otros_ingresos, :descripcion, :image_cedula, :contrato, :estado
                )
            ");

            $stmt->execute([
                ':numero_socio' => $numeroSocio,
                ':cedula' => $cedula,
                ':nombre' => $nombre,
                ':apellido' => $apellido,
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
                ':image_cedula' => $rutaCedula,
                ':contrato' => $rutaContrato,
                ':estado' => $estado, 
            ]);

            echo json_encode(['success' => true, 'message' => 'El Número del Socio es: ' . '<b>' . $numeroSocio . '</b>']);
        } else {
            // Subir archivos solo si existen y actualizar
            if ($imageCedula && $imageCedula['error'] === UPLOAD_ERR_OK) {
                $rutaCedula = guardarArchivo($imageCedula, '../uploads/cedulas');
            }

            if ($contrato && $contrato['error'] === UPLOAD_ERR_OK) {
                $rutaContrato = guardarArchivo($contrato, '../uploads/contratos');
            }

            $stmt = $conn->prepare("
                UPDATE cliente SET 
                    cedula = :cedula, nombre = :nombre, apellido = :apellido, direccion = :direccion, 
                    lugar_trabajo = :lugar_trabajo, telefono1 = :telefono1, telefono2 = :telefono2, 
                    correo_personal = :correo_personal, correo_institucional = :correo_institucional, 
                    sucursal_id = :sucursal_id, sexo = :sexo, estado_civil = :estado_civil, nacionalidad = :nacionalidad, 
                    ingresos_mensuales = :ingresos_mensuales, otros_ingresos = :otros_ingresos, descripcion = :descripcion,
                    image_cedula = COALESCE(:image_cedula, image_cedula), contrato = COALESCE(:contrato, contrato),
                    estado = :estado
                WHERE id = :id
            ");

            $stmt->execute([
                ':cedula' => $cedula,
                ':nombre' => $nombre,
                ':apellido' => $apellido,
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
                ':image_cedula' => $rutaCedula,
                ':contrato' => $rutaContrato,
                ':estado' => $estado,
                ':id' => $id,
            ]);

            echo json_encode(['success' => true, 'message' => 'Socio actualizado exitosamente.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
?>
