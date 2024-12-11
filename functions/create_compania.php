<?php
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $rnc = $_POST['rnc'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $correo = $_POST['correo'];
        $interes_fijo = $_POST['interes_fijo'];
        

      /*  try {
            $stmt = $conn->prepare("INSERT INTO compania (nombre, rnc, direccion, telefono, correo) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nombre, $rnc, $direccion, $telefono, $correo]);
            header("Location: ../companies");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        } */
        try {
            $stmt = $conn->prepare("INSERT INTO compania (nombre, rnc, direccion, telefono, correo, interes_fijo) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nombre, $rnc, $direccion, $telefono, $correo, $interes_fijo]);
        
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }

    }


?>
