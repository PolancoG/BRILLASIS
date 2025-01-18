<?php
      session_start();
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

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        try {
            // Consulta para obtener los datos del préstamo
            //$stmt = $conn->prepare("SELECT * FROM prestamo WHERE id = :id");
            $stmt = $conn->prepare("SELECT prestamo.*, cliente.numero_socio 
                                    FROM prestamo
                                    JOIN cliente ON prestamo.cliente_id = cliente.id
                                    WHERE prestamo.id = :id");
            $stmt->execute([':id' => $id]);
            $prestamo = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($prestamo) {
                // Enviar datos del préstamo como JSON
                echo json_encode($prestamo);
            } else {
                // Si no se encuentra el préstamo
                echo json_encode(['error' => 'Préstamo no encontrado']);
            }
        } catch (PDOException $e) {
            // En caso de error en la consulta
            echo json_encode(['error' => 'Error al obtener el préstamo: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'ID del préstamo no especificado']);
    }
?>
