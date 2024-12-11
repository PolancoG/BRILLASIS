<?php
    //var_dump($_POST);
   // exit;
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
/*
   if (!isset($_GET['id']) || empty($_GET['id'])) {
       echo json_encode(['error' => 'ID del cliente no especificado']);
       exit;
   }

    $id = $_POST['id'] ?? null;
    $cliente_id = $_POST['cliente_id'];
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $relacion = $_POST['relacion'];
    $telefono = $_POST['telefono'] ?? null;
    $correo_electronico = $_POST['correo_electronico'] ?? null;
    $nombre_hijos = $_POST['nombre_hijos'] ?? null;

    try {
        if ($id) {
            $stmt = $conn->prepare("
                UPDATE familia_cliente
                SET cliente_id = :cliente_id, cedula = :cedula, nombre = :nombre, relacion = :relacion, 
                    telefono = :telefono, correo_electronico = :correo_electronico, nombre_hijos = :nombre_hijos
                WHERE id = :id
            ");
            $stmt->execute([
                ':cliente_id' => $cliente_id,
                ':cedula' => $cedula,
                ':nombre' => $nombre,
                ':relacion' => $relacion,
                ':telefono' => $telefono,
                ':correo_electronico' => $correo_electronico,
                ':nombre_hijos' => $nombre_hijos,
                ':id' => $id
            ]);
            echo json_encode(['success' => true, 'message' => 'Familiar actualizado exitosamente.']);
        } else {
            $stmt = $conn->prepare("
                INSERT INTO familia_cliente (cliente_id, cedula, nombre, relacion, telefono, correo_electronico, nombre_hijos)
                VALUES (:cliente_id, :cedula, :nombre, :relacion, :telefono, :correo_electronico, :nombre_hijos)
            ");
            $stmt->execute([
                ':cliente_id' => $cliente_id,
                ':cedula' => $cedula,
                ':nombre' => $nombre,
                ':relacion' => $relacion,
                ':telefono' => $telefono,
                ':correo_electronico' => $correo_electronico,
                ':nombre_hijos' => $nombre_hijos
            ]);
            echo json_encode(['success' => true, 'message' => 'Familiar agregado exitosamente.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    } */
   // Validar que cliente_id esté definido y no esté vacío
if (!isset($_POST['cliente_id']) || trim($_POST['cliente_id']) === '') {
    echo json_encode(['error' => 'ID del cliente no especificado']);
    exit;
}

// Recibir los datos del formulario
$id = $_POST['id'] ?? null; // Puede ser nulo en caso de ser un registro nuevo
$cliente_id = $_POST['cliente_id'];
$cedula = $_POST['cedula'];
$nombre = $_POST['nombre'];
$relacion = $_POST['relacion'];
$telefono = $_POST['telefono'] ?? null;
$correo_electronico = $_POST['correo_electronico'] ?? null;
$nombre_hijos = $_POST['nombre_hijos'] ?? null;

try {
    if ($id && trim($id) !== '') {
        // Actualizar familiar existente
        $stmt = $conn->prepare("
            UPDATE familia_cliente
            SET cliente_id = :cliente_id, cedula = :cedula, nombre = :nombre, relacion = :relacion, 
                telefono = :telefono, correo_electronico = :correo_electronico, nombre_hijos = :nombre_hijos
            WHERE id = :id
        ");
        $stmt->execute([
            ':cliente_id' => $cliente_id,
            ':cedula' => $cedula,
            ':nombre' => $nombre,
            ':relacion' => $relacion,
            ':telefono' => $telefono,
            ':correo_electronico' => $correo_electronico,
            ':nombre_hijos' => $nombre_hijos,
            ':id' => $id
        ]);
        echo json_encode(['success' => true, 'message' => 'Familiar actualizado exitosamente.']);
    } else {
        // Insertar nuevo familiar
        $stmt = $conn->prepare("
            INSERT INTO familia_cliente (cliente_id, cedula, nombre, relacion, telefono, correo_electronico, nombre_hijos)
            VALUES (:cliente_id, :cedula, :nombre, :relacion, :telefono, :correo_electronico, :nombre_hijos)
        ");
        $stmt->execute([
            ':cliente_id' => $cliente_id,
            ':cedula' => $cedula,
            ':nombre' => $nombre,
            ':relacion' => $relacion,
            ':telefono' => $telefono,
            ':correo_electronico' => $correo_electronico,
            ':nombre_hijos' => $nombre_hijos
        ]);
        echo json_encode(['success' => true, 'message' => 'Familiar agregado exitosamente.']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
}
?>