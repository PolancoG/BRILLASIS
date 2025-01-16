<?php
/*
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
*/
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

    $stmt = $conn->prepare("SELECT image_cedula FROM cliente WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cliente && file_exists('../uploads/cedulas/' . $cliente['image_cedula'])) {
        $imagePath = '../uploads/cedulas/' . $cliente['image_cedula']; //../uploads/cedulas/ 
        header('Content-Type: image/jpeg');
        readfile($imagePath);
        exit;
    } else {
        http_response_code(404);
        echo 'Imagen no encontrada.';
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

$stmt = $conn->prepare("SELECT image_cedula FROM cliente WHERE id = :id");
$stmt->execute([':id' => $id]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if ($cliente && file_exists('../uploads/cedulas/' . $cliente['image_cedula'])) {
    $rutaImagen = '../uploads/cedulas/' . $cliente['image_cedula'];
    header('Content-Type: image/jpeg'); // Cambia el tipo MIME según el formato
    readfile($rutaImagen);
    exit;
} else {
    http_response_code(404);
    echo 'Imagen no encontrada.';
    exit;
}
?>
