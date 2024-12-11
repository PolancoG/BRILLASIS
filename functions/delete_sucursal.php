<?php
    session_start();
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];

        try {
            $stmt = $conn->prepare("DELETE FROM sucursal WHERE id = ?");
            $stmt->execute([$id]);
            echo "Sucursal eliminada correctamente";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>
