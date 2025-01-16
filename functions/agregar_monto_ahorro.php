<?php
    // Conexión a la base de datos
   /* $host = 'localhost';
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

    $cliente_id = $_POST['cliente_id'] ?? null;
    $monto = $_POST['monto'] ?? null;

    if (!$cliente_id || !$monto) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
        exit;
    }

    try {
        // Sumar el nuevo monto al ahorro existente
        $stmt = $conn->prepare("
            UPDATE ahorro 
            SET monto = monto + :monto, fecha_ahorro = NOW()
            WHERE cliente_id = :cliente_id
        ");
        $stmt->execute([':monto' => $monto, ':cliente_id' => $cliente_id]);

        echo json_encode(['success' => true, 'message' => 'Monto agregado al ahorro exitosamente.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al agregar el monto: ' . $e->getMessage()]);
    } */
?>

<?php
    session_start(); 
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

    $cliente_id = $_POST['cliente_id'] ?? null;
    $monto = $_POST['monto'] ?? null;
    $comentario = $_POST['comentario'] ?? null;
    $usuario_id = $_SESSION['user_id'] ?? null; // Supongo que el usuario actual está almacenado en la sesión

    if (!$cliente_id || !$monto || !$usuario_id) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
        exit;
    }

    try {
        $conn->beginTransaction();

        // Obtener el número de socio del cliente
        $stmt = $conn->prepare("SELECT numero_socio FROM cliente WHERE id = :cliente_id");
        $stmt->execute([':cliente_id' => $cliente_id]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$cliente) {
            echo json_encode(['success' => false, 'message' => 'Cliente no encontrado.']);
            $conn->rollBack();
            exit;
        }

        $numero_socio = $cliente['numero_socio'];

        // Actualizar el monto total en la tabla de ahorros
        $stmt = $conn->prepare("
            UPDATE ahorro 
            SET monto = monto + :monto, fecha_ahorro = NOW()
            WHERE cliente_id = :cliente_id
        ");
        $stmt->execute([':monto' => $monto, ':cliente_id' => $cliente_id]);

        // Insertar un registro en la tabla registro_ahorros
        $stmt = $conn->prepare("
            INSERT INTO registro_ahorros (cliente_id, numero_socio, monto_agregado, usuario_id, comentario, fecha_agregado)
            VALUES (:cliente_id, :numero_socio, :monto, :usuario_id, :comentario, NOW())
        ");
        $stmt->execute([
            ':cliente_id' => $cliente_id,
            ':numero_socio' => $numero_socio,
            ':monto' => $monto,
            ':usuario_id' => $usuario_id,
            ':comentario' => $comentario
        ]);

        $conn->commit();

        echo json_encode(['success' => true, 'message' => 'Monto agregado al ahorro exitosamente.']);
    } catch (PDOException $e) {
        $conn->rollBack();
        echo json_encode(['success' => false, 'message' => 'Error al agregar el monto: ' . $e->getMessage()]);
    }
?>
