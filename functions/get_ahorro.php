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

        try {
            // Consulta para obtener los datos del ahorro y el nombre del cliente
          /*  $stmt = $conn->prepare("SELECT *
                                    FROM ahorro
                                    WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $ahorro = $stmt->fetch(PDO::FETCH_ASSOC); */

            // Consulta para obtener los datos del ahorro y el número de socio del cliente
            $stmt = $conn->prepare("SELECT ahorro.*, cliente.numero_socio 
                                    FROM ahorro
                                    JOIN cliente ON ahorro.cliente_id = cliente.id
                                    WHERE ahorro.id = :id");
            $stmt->execute([':id' => $id]);
            $ahorro = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($ahorro) {
                // Enviar los datos en formato JSON
                echo json_encode($ahorro);
            } else {
                // Si no se encuentra el ahorro, devolver un mensaje de error
                echo json_encode(['error' => 'Ahorro no encontrado']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error al obtener los datos: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'ID no proporcionado']);
    }
?>