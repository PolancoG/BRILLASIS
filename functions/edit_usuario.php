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
        $username = $_POST['username'];
        $role = $_POST['role'];

        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $sql = "UPDATE usuarios SET username = :username, password = :password, role = :role WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':username' => $username, ':password' => $password, ':role' => $role, ':id' => $id]);
        } else {
            $sql = "UPDATE usuarios SET username = :username, role = :role WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':username' => $username, ':role' => $role, ':id' => $id]);
        }

        $_SESSION['mensaje'] = [
            'texto' => 'El usuario se ha actualizado correctamente.',
            'tipo' => 'success'
        ];

        header("Location: ../usuarios.php");
        exit();
    }
?>
