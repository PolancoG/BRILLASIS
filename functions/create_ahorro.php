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

    if (isset($_POST['cliente_id'], $_POST['monto'], $_POST['fecha'])) {
        $cliente_id = $_POST['cliente_id'];
        $monto = $_POST['monto'];
        $fecha = $_POST['fecha'];

        if ($monto < 200) {
            echo json_encode([
                'success' => false,
                'message' => 'El monto mínimo para aperturar el ahorro debe ser $200.00'
            ]);
            exit;
        }

        try {
            $sql = "INSERT INTO ahorro (cliente_id, monto, fecha) VALUES (:cliente_id, :monto, :fecha)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':cliente_id' => $cliente_id, ':monto' => $monto, ':fecha' => $fecha]);

            $_SESSION['alerta'] = [
                'icon' => 'success',
                'title' => 'Ahorro agregado',
                'text' => 'El ahorro ha sido agregado correctamente.'
            ];
        } catch (PDOException $e) {
            $_SESSION['alerta'] = [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Hubo un problema al agregar el ahorro: ' . $e->getMessage()
            ];
        }
    }

    header('Location: ../ahorros.php');
    exit();
?>
