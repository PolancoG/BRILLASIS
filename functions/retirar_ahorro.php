<?php
    /*session_start();
    //conexion database
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
    $data = json_decode(file_get_contents('php://input'), true);

    $ahorro_id = $data['ahorro_id'];
    $cliente_id = $data['cliente_id'];

    // Validar si el estado del préstamo del cliente es 'activo_terminado'
    $stmt = $conn->prepare("SELECT estado FROM prestamos WHERE cliente_id = :cliente_id ORDER BY id DESC LIMIT 1");
    $stmt->bindParam(':cliente_id', $cliente_id);
    $stmt->execute();
    $prestamo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($prestamo && $prestamo['estado'] === 'activo_terminado') {
        // Proceder a retirar el ahorro
        $stmt = $conn->prepare("DELETE FROM ahorro WHERE id = :ahorro_id");
        $stmt->bindParam(':ahorro_id', $ahorro_id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se pudo retirar el ahorro.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'El cliente tiene un préstamo en proceso.']);
    } */
?>

<?php
    session_start();
    header('Content-Type: application/json');

    //conexion database
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

    $data = json_decode(file_get_contents('php://input'), true);

    $cliente_id = $data['cliente_id'] ?? null;
    $ahorro_id = $data['ahorro_id'] ?? null;

    if (!$cliente_id || !$ahorro_id) {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
        exit;
    }

    // Validar el estado del préstamo
    $stmt = $conn->prepare("SELECT estado FROM prestamo WHERE cliente_id = :cliente_id");
    $stmt->bindParam(':cliente_id', $cliente_id);
    $stmt->execute();
    $estado = $stmt->fetchColumn();

    if ($estado !== 'activo_terminado') {
        echo json_encode(['success' => false, 'message' => 'El cliente tiene un préstamo en proceso o no tiene préstamo registrado.']);
        exit;
    }

    // Realizar el retiro del ahorro
    $stmt = $conn->prepare("DELETE FROM ahorro WHERE id = :ahorro_id");
    $stmt->bindParam(':ahorro_id', $ahorro_id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Ahorro retirado exitosamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se pudo retirar el ahorro.']);
    }
?>
