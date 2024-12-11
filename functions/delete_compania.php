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

    $id = $_POST['id'];

    try {
        // Verificar si la compañía tiene sucursales asociadas
        $stmt = $conn->prepare("SELECT COUNT(*) FROM sucursal WHERE compania_id = ?");
        $stmt->execute([$id]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            echo json_encode(['success' => false, 'message' => 'No se puede eliminar, existen sucursales asociadas.']);
        } else {
            // Eliminar la compañía
            $stmt = $conn->prepare("DELETE FROM compania WHERE id = ?");
            $stmt->execute([$id]);

            echo json_encode(['success' => true]);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
?>
