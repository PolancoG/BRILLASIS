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

    /*if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $username = $_POST['username'];
        $role = $_POST['role'];

        if($id){
            if (!empty($_POST['password'])) {
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $sql = "UPDATE usuarios SET username = :username, password = :password, role = :role WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->execute([':username' => $username, ':password' => $password, ':role' => $role, ':id' => $id]);

                $_SESSION['mensaje'] = [
                    'texto' => 'El usuario se ha actualizado correctamente.',
                    'tipo' => 'success'
                ];

            } else {
                $sql = "UPDATE usuarios SET username = :username, role = :role WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->execute([':username' => $username, ':role' => $role, ':id' => $id]);

                $_SESSION['mensaje'] = [
                    'texto' => 'El usuario se ha actualizado correctamente.',
                    'tipo' => 'success'
                ];
            }
        }

        $_SESSION['mensaje'] = [
            'texto' => 'Error al actualizar el usuario.',
            'tipo' => 'error'
        ];

        header("Location: ../usuarios.php");
        exit();
    } */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $role = $_POST['role'];
    $password = $_POST['password'] ?? null;

    if (!$id || !$username || !$role) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
        exit;
    }

    try {
        if (!empty($password)) {
            // Si se proporciona una nueva contraseña
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            $sql = "UPDATE usuarios SET username = :username, password = :password, role = :role WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':username' => $username,
                ':password' => $passwordHash,
                ':role' => $role,
                ':id' => $id
            ]);
        } else {
            // Si no se proporciona una nueva contraseña
            $sql = "UPDATE usuarios SET username = :username, role = :role WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':username' => $username,
                ':role' => $role,
                ':id' => $id
            ]);
        }

        echo json_encode(['success' => true, 'message' => 'Usuario actualizado exitosamente.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el usuario: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}

?>
