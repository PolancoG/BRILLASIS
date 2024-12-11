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

   /* if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $monto = $_POST['monto'];
        $interes = $_POST['interes'];
        $plazo = $_POST['plazo'];
        $estado = $_POST['estado'];

        try {
            // Actualizar los datos del préstamo
            $stmt = $conn->prepare("UPDATE prestamo SET monto = :monto, interes = :interes, plazo = :plazo, estado = :estado WHERE id = :id");
            $stmt->execute([
                ':monto' => $monto,
                ':interes' => $interes,
                ':plazo' => $plazo,
                ':estado' => $estado,
                ':id' => $id
            ]);

            $_SESSION['alerta'] = [
                'icon' => 'success',
                'title' => 'Datos actualizados',
                'text' => 'Los datos han sido actualizado correctamente.',
            ];
            header('Location: ../prestamos.php');
            exit();
            // Redirigir con éxito
            //echo "<script>Swal.fire('Éxito', 'Préstamo actualizado correctamente.', 'success').then(() => { window.location.href = '/prestamos.php'; });</script>";

        } catch (PDOException $e) {
            echo "<script>Swal.fire('Error', 'Error al actualizar el préstamo: " . $e->getMessage() . "', 'error');</script>";
        }
    } */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $monto = $_POST['monto'] ?? null;
    $interes = $_POST['interes'] ?? null;
    $plazo = $_POST['plazo'] ?? null;
    $estado = $_POST['estado'] ?? null;

    if (empty($id) || empty($monto) || empty($interes) || empty($plazo) || empty($estado)) {
        echo json_encode([
            'success' => false,
            'message' => 'Todos los campos son obligatorios.'
        ]);
        exit;
    }

    try {
        $stmt = $conn->prepare("
            UPDATE prestamo 
            SET monto = :monto, interes = :interes, plazo = :plazo, estado = :estado 
            WHERE id = :id
        ");
        $stmt->execute([
            ':id' => $id,
            ':monto' => $monto,
            ':interes' => $interes,
            ':plazo' => $plazo,
            ':estado' => $estado
        ]);

        echo json_encode([
            'success' => true,
            'message' => 'Préstamo actualizado correctamente.'
        ]);
        exit;
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error al actualizar el préstamo: ' . $e->getMessage()
        ]);
        exit;
    }
} 
?>
