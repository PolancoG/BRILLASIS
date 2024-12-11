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

   /* if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($usuario);
    } */
    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    
        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID de usuario no especificado.']);
            exit;
        }
    
        try {
            $stmt = $conn->prepare("SELECT id, username, role FROM usuarios WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($usuario) {
                echo json_encode(['success' => true, 'usuario' => $usuario]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Usuario no encontrado.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error al obtener el usuario: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'ID de usuario no especificado.']);
    }
    
?>
