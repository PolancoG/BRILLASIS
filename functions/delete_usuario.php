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

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        $_SESSION['mensaje'] = [
            'texto' => 'El usuario ha sido eliminado correctamente.',
            'tipo' => 'success'
        ];

        header("Location: ../usuarios.php");
        exit();
    }
?>
