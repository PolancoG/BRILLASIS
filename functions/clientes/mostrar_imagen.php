<?php

include './db.php';
 
$id = $_GET['id'];

$stmt = $conn->prepare("SELECT image_cedula, image_cedula_type FROM cliente WHERE id = :id");
$stmt->execute([':id' => $id]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if ($cliente && $cliente['image_cedula']) {
    header('Content-Type: ' . $cliente['image_cedula_type']);
    echo $cliente['image_cedula'];
    exit;
} else {
    http_response_code(404);
    echo 'Imagen no encontrada.';
    exit;
}

?>