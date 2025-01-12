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
            // Eliminar el préstamo
            $stmt = $conn->prepare("DELETE FROM prestamo WHERE id = :id");
            $stmt->execute([':id' => $id]);

            $_SESSION['alerta'] = [
                'icon' => 'success',
                'title' => 'Ahorro eliminado',
                'text' => 'El ahorro ha sido eliminado correctamente.'
            ];
            
            // Redirigir con éxito
            //echo "<script>Swal.fire('Éxito', 'Préstamo eliminado correctamente.', 'success').then(() => { window.location.href = '../prestamos.php'; });</script>";

        } catch (PDOException $e) {
            echo "<script>Swal.fire('Error', 'Error al eliminar el préstamo: " . $e->getMessage() . "', 'error');</script>";
        }
    }
?>
