<?php
    // Conexión a la base de datos
  /*  $host = 'localhost';
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

    // Método permitido
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Método no permitido']);
        exit;
    }

    // Recibir datos del formulario
    $id = $_POST['id'] ?? null;
    $numeroSocio = empty($id) ? generarNumeroSocio($conn) : null; // Generar solo si es nuevo
    $cedula = $_POST['cedula'] ?? null;
    $nombre = $_POST['nombre'] ?? null;
    $apellido = $_POST['apellido'] ?? null;
    $direccion = $_POST['direccion'] ?? null;
    $telefono1 = $_POST['telefono1'] ?? null;
    $sucursal_id = $_POST['sucursal_id'] ?? null;
    $sexo = $_POST['sexo'] ?? null;
    $estado_civil = $_POST['estado_civil'] ?? null;
    $nacionalidad = $_POST['nacionalidad'] ?? null;

    // Validación de campos obligatorios
    if (!$cedula || !$nombre || !$direccion || !$telefono1 || !$sexo || !$estado_civil || !$nacionalidad || !$sucursal_id) {
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
            // Insertar nuevo cliente
            $stmt = $conn->prepare("
                INSERT INTO cliente (
                    numero_socio, cedula, nombre, apellido, direccion, telefono1, sucursal_id, sexo, estado_civil, nacionalidad
                ) VALUES (
                    :numero_socio, :cedula, :nombre, :apellido, :direccion, :telefono1, :sucursal_id, :sexo, :estado_civil, :nacionalidad
                )
            ");
            $stmt->execute([
                ':numero_socio' => $numeroSocio,
                ':cedula' => $cedula,
                ':nombre' => $nombre,
                ':apellido' => $apellido,
                ':direccion' => $direccion,
                ':telefono1' => $telefono1,
                ':sucursal_id' => $sucursal_id,
                ':sexo' => $sexo,
                ':estado_civil' => $estado_civil,
                ':nacionalidad' => $nacionalidad,
            ]);
            echo json_encode(['success' => true, 'message' => 'Cliente agregado exitosamente.']);
        } else {
            // Actualizar cliente existente
            $stmt = $conn->prepare("
                UPDATE cliente SET 
                    cedula = :cedula, nombre = :nombre, apellido = :apellido, direccion = :direccion, 
                    telefono1 = :telefono1, sucursal_id = :sucursal_id, sexo = :sexo, 
                    estado_civil = :estado_civil, nacionalidad = :nacionalidad
                WHERE id = :id
            ");
            $stmt->execute([
                ':cedula' => $cedula,
                ':nombre' => $nombre,
                ':apellido' => $apellido,
                ':direccion' => $direccion,
                ':telefono1' => $telefono1,
                ':sucursal_id' => $sucursal_id,
                ':sexo' => $sexo,
                ':estado_civil' => $estado_civil,
                ':nacionalidad' => $nacionalidad,
                ':id' => $id
            ]);
            echo json_encode(['success' => true, 'message' => 'Cliente actualizado exitosamente.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    } */
?>
 

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

// Validación del método
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Recepción de datos del formulario
$id = $_POST['id'] ?? null;
$numeroSocio = empty($id) ? generarNumeroSocio($conn) : null; // Generar solo si es nuevo
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
//$image_cedula = $_FILES['image_cedula']['tmp_name'] ?? null;
//$contrato = $_FILES['contrato']['tmp_name'] ?? null;

// Validación de campos obligatorios
if (!$cedula || !$nombre || !$direccion || !$telefono1 || !$sexo || !$estado_civil || !$nacionalidad || !$sucursal_id) {
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
        // Insertar nuevo cliente  ; , image_cedula, contrato ;   , :image_cedula, :contrato
        $stmt = $conn->prepare("
            INSERT INTO cliente (
                numero_socio, cedula, nombre, apellido, direccion, lugar_trabajo, telefono1, telefono2, correo_personal, correo_institucional, 
                sucursal_id, sexo, estado_civil, nacionalidad, ingresos_mensuales, otros_ingresos, descripcion 
            ) VALUES (
                :numero_socio, :cedula, :nombre, :apellido, :direccion, :lugar_trabajo, :telefono1, :telefono2, :correo_personal, :correo_institucional, 
                :sucursal_id, :sexo, :estado_civil, :nacionalidad, :ingresos_mensuales, :otros_ingresos, :descripcion
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
            //':image_cedula' => file_get_contents($image_cedula),
            //':contrato' => file_get_contents($contrato),
        ]);

        echo json_encode(['success' => true, 'message' => 'El Número del Socio es: ' . '<b>'.$numeroSocio.'</b>']);
    } else {
        // Actualizar cliente existente ; image_cedula = :image_cedula, contrato = :contrato
        $stmt = $conn->prepare("
            UPDATE cliente SET 
                cedula = :cedula, nombre = :nombre, apellido = :apellido, direccion = :direccion, 
                lugar_trabajo = :lugar_trabajo, telefono1 = :telefono1, telefono2 = :telefono2, 
                correo_personal = :correo_personal, correo_institucional = :correo_institucional, 
                sucursal_id = :sucursal_id, sexo = :sexo, estado_civil = :estado_civil, nacionalidad = :nacionalidad, 
                ingresos_mensuales = :ingresos_mensuales, otros_ingresos = :otros_ingresos, descripcion = :descripcion
                
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
           // ':image_cedula' => file_get_contents($image_cedula),
            //':contrato' => file_get_contents($contrato),
            ':id' => $id,
        ]);

        echo json_encode(['success' => true, 'message' => 'Socio actualizado exitosamente.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
