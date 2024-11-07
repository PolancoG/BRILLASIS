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
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $role = $_POST['role'];

        $sql = "INSERT INTO usuarios (username, password, role) VALUES (:username, :password, :role)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':username' => $username, 
            ':password' => $password, 
            ':role' => $role
        ]);

        $_SESSION['mensaje'] = [
            'texto' => 'Usuario agregado exitosamente.',
            'tipo' => 'success'
        ];

        header("Location: ../usuarios.php");
        exit();
    }
?>
