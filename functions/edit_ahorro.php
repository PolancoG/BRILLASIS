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
        echo "Error de conexión: " . $e->getMessage();
        die();
    } 

    if (isset($_POST['id'], $_POST['cliente_id'], $_POST['monto'], $_POST['fecha'])) {
        $id = $_POST['id'];
        $cliente_id = $_POST['cliente_id'];
        $monto = $_POST['monto'];
        $fecha = $_POST['fecha'];

        if ($monto < 200) {
            echo json_encode([
                'success' => false,
                'message' => 'El monto mínimo de ahorro debe ser $200.00'
            ]);
            exit;
        }        

        try {
            $sql = "UPDATE ahorro SET cliente_id = :cliente_id, monto = :monto, fecha = :fecha WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':cliente_id' => $cliente_id, ':monto' => $monto, ':fecha' => $fecha, ':id' => $id]);

            $_SESSION['alerta'] = [
                'icon' => 'success',
                'title' => 'Datos actualizados',
                'text' => 'Los datos han sido actualizado correctamente.',
            ];
        } catch (PDOException $e) {
            $_SESSION['alerta'] = [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Hubo un problema al actualizar: ' . $e->getMessage()
            ];
        }
    }

    header('Location: ../ahorros.php');
    exit();
?>