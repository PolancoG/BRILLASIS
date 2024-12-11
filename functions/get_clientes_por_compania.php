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

    $compania_id = $_GET['compania_id'] ?? null;

    if (!$compania_id) {
        echo json_encode([]);
        exit;
    }

    try {
        $stmt = $conn->prepare("
            SELECT c.id, c.nombre 
            FROM cliente c
            JOIN ahorro a ON c.id = a.cliente_id
            JOIN sucursal s ON c.sucursal_id = s.id
            JOIN compania co ON s.compania_id = co.id
            WHERE co.id = :compania_id
        ");
        $stmt->execute([':compania_id' => $compania_id]);
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($clientes);
    } catch (PDOException $e) {
        echo json_encode([]);
    }
?>