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

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        try {
            $sql = "DELETE FROM ahorro WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':id' => $id]);

            $_SESSION['alerta'] = [
                'icon' => 'success',
                'title' => 'Ahorro eliminado',
                'text' => 'El ahorro ha sido eliminado correctamente.'
            ];
        } catch (PDOException $e) {
            $_SESSION['alerta'] = [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Hubo un problema al eliminar el ahorro: ' . $e->getMessage()
            ];
        }
    }

    header('Location: ../ahorros.php');
    exit();
?>
