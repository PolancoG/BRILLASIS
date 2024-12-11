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
/*
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $compania_id = $_POST['compania_id'];

        try {
            $stmt = $conn->prepare("INSERT INTO sucursal (nombre, direccion, telefono, compania_id) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nombre, $direccion, $telefono, $compania_id]);
            echo json_encode(['success' => true, 'message' => 'Sucursal agregada exitosamente.']);
            //header("Location: ../sucursales");
        } catch (PDOException $e) {
            $_SESSION['alerta'] = [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Hubo un problema al agregar la sucursal: ' . $e->getMessage()
            ];
        }
    }
        */

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $direccion = $_POST['direccion'];
            $telefono = $_POST['telefono'];
            $provincia = $_POST['provincia'];
            $compania_id = $_POST['compania_id'];
        
            try {
                $stmt = $conn->prepare("
                    INSERT INTO sucursal (nombre, direccion, telefono, provincia, compania_id)
                    VALUES (:nombre, :direccion, :telefono, :provincia, :compania_id)
                ");
                $stmt->execute([
                    ':nombre' => $nombre,
                    ':direccion' => $direccion,
                    ':telefono' => $telefono,
                    ':provincia' => $provincia,
                    ':compania_id' => $compania_id
                ]);
        
                echo json_encode(['success' => true, 'message' => 'Sucursal agregada exitosamente.']);
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'message' => 'Error al agregar la sucursal: ' . $e->getMessage()]);
            }
        }
        
?>
