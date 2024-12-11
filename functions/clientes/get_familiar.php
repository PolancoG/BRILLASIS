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

   
    // Validar si se proporcionó el ID del familiar
   /* $id = $_GET['id'] ?? null;

    if (!$id) {
        echo json_encode(['error' => 'ID del familiar no especificado']);
        exit;
    }

    try {
        // Consulta para obtener los datos del familiar junto con el cliente relacionado
        $stmt = $conn->prepare("
            SELECT f.*, c.nombre AS cliente_nombre
            FROM familia_cliente f
            JOIN cliente c ON f.cliente_id = c.id
            WHERE f.id = :id
        ");
        $stmt->execute([':id' => $id]);
        $familiar = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($familiar) {
            // Devolver los datos del familiar
            echo json_encode(['familiar' => $familiar]);
        } else {
            // Si no se encuentra el familiar
            echo json_encode(['error' => 'Familiar no encontrado.']);
        }
    } catch (PDOException $e) {
        // En caso de error en la consulta
        echo json_encode(['error' => 'Error al obtener el familiar: ' . $e->getMessage()]);
    } */
   
   /* 
    $id = $_GET['id'] ?? null;
    
    if (!$id) {
        echo json_encode(['error' => 'ID del familiar no especificado']);
        exit;
    }
    
    try {
        // Registro para depurar qué ID se recibió
        error_log("ID recibido: $id");
    
        $stmt = $conn->prepare("
            SELECT f.*, c.nombre AS cliente_nombre
            FROM familia_cliente f
            JOIN cliente c ON f.cliente_id = c.id
            WHERE f.id = :id
        ");
        $stmt->execute([':id' => $id]);
        $familiar = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($familiar) {
            // Registrar la respuesta en el log para depuración
            error_log("Datos obtenidos: " . print_r($familiar, true));
            echo json_encode(['familiar' => $familiar]);
        } else {
            error_log("Familiar con ID $id no encontrado.");
            echo json_encode(['error' => 'Familiar no encontrado.']);
        }
    } catch (PDOException $e) {
        error_log("Error en get_familiar.php: " . $e->getMessage());
        echo json_encode(['error' => 'Error al obtener el familiar: ' . $e->getMessage()]);
    }
    */
    // Verificar que se haya enviado el ID del familiar
$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode(['error' => 'ID del familiar no especificado']);
    exit;
}

try {
    // Consulta para obtener los datos del familiar y del cliente relacionado
    $stmt = $conn->prepare("
        SELECT f.*, c.nombre AS cliente_nombre
        FROM familia_cliente f
        JOIN cliente c ON f.cliente_id = c.id
        WHERE f.id = :id
    ");
    $stmt->execute([':id' => $id]);
    $familiar = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($familiar) {
        echo json_encode(['familiar' => $familiar]);
    } else {
        echo json_encode(['error' => 'Familiar no encontrado.']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al obtener el familiar: ' . $e->getMessage()]);
}
?>