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
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($usuario);
    }
?>
