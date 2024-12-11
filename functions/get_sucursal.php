<?php
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
           // Consulta para obtener los datos de la sucursal
           $stmt = $conn->prepare("SELECT * FROM sucursal WHERE id = :id");
           $stmt->execute([':id' => $id]);
           $sucursal = $stmt->fetch(PDO::FETCH_ASSOC);
   
           if ($sucursal) {
               // Consulta para obtener todas las compañías
               $stmtCompanias = $conn->prepare("SELECT id, nombre FROM compania");
               $stmtCompanias->execute();
               $companias = $stmtCompanias->fetchAll(PDO::FETCH_ASSOC);
   
               // Enviar datos de la sucursal y las compañías como JSON
               echo json_encode([
                   'success' => true,
                   'sucursal' => $sucursal,
                   'companias' => $companias
               ]);
           } else {
               // Si no se encuentra la sucursal
               echo json_encode(['success' => false, 'error' => 'Sucursal no encontrada']);
           }
       } catch (PDOException $e) {
           // En caso de error en la consulta
           echo json_encode(['success' => false, 'error' => 'Error al obtener la sucursal: ' . $e->getMessage()]);
       }
   } else {
       echo json_encode(['success' => false, 'error' => 'ID de la sucursal no especificado']);
   }
   
?>
