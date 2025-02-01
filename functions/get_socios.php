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
    exit;
}

$compania_id = $_POST['compania_id'] ?? null;

if (!$compania_id) {
    echo json_encode(['success' => false, 'message' => 'El ID de la compañía es obligatorio.']);
    exit;
}

try {
    // Unir tablas: cliente -> sucursal -> compañía
    $stmt = $conn->prepare("
        SELECT cliente.id, cliente.nombre, cliente.apellido, ahorro.monto AS ahorro 
        FROM cliente
        JOIN ahorro ON cliente.id = ahorro.cliente_id
        JOIN sucursal ON cliente.sucursal_id = sucursal.id
        JOIN compania ON sucursal.compania_id = compania.id
        WHERE compania.id = :compania_id
    ");
    $stmt->execute([':compania_id' => $compania_id]);
    $socios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'socios' => $socios]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error al obtener los socios: ' . $e->getMessage()]);
}
?>

