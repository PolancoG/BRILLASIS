<?php
     //conexion database
  /*   $host = 'localhost';
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

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT contrato, contrato_type FROM cliente WHERE id = :id");
$stmt->execute([':id' => $id]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if ($cliente && $cliente['contrato']) {
    header('Content-Type: ' . $cliente['contrato_type']);
    header('Content-Disposition: attachment; filename="contrato_' . $id . '.pdf"');
    echo $cliente['contrato'];
    exit;
} else {
    http_response_code(404);
    echo 'Archivo no encontrado.';
    exit;
} */
?>

<?php
    //conexion database
   /*  $host = 'localhost';
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

    $id = $_GET['id'] ?? null;

    $stmt = $conn->prepare("SELECT contrato FROM cliente WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cliente && file_exists('../uploads/contratos/' . $cliente['contrato'])) {
        $filePath = '../uploads/contratos/' . $cliente['contrato'];
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="contrato.pdf"');
        readfile($filePath);
        exit;
    } else {
        http_response_code(404);
        echo 'Archivo no encontrado.';
    } */
?>


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

    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT contrato FROM cliente WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cliente && file_exists('../uploads/contratos/' . $cliente['contrato'])) {
        $rutaContrato = '../uploads/contratos/' . $cliente['contrato'];
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($rutaContrato) . '"');
        readfile($rutaContrato);
        exit;
    } else {
        http_response_code(404);
        echo 'Archivo no encontrado.';
        exit;
    }

?>
