<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
// edit.php
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
    $stmt = $conn->prepare("SELECT * FROM cliente WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $numero_socio = $_POST['numero_socio'];
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $lugar_trabajo = $_POST['lugar_trabajo'];
    $telefono1 = $_POST['telefono1'];
    $telefono2 = $_POST['telefono2'];
    $correo_personal = $_POST['correo_personal'];
    $correo_institucional = $_POST['correo_institucional'];

    $sql = "UPDATE cliente SET numero_socio = :numero_socio, cedula = :cedula, nombre = :nombre, direccion = :direccion, lugar_trabajo = :lugar_trabajo,
            telefono1 = :telefono1, telefono2 = :telefono2, correo_personal = :correo_personal, correo_institucional = :correo_institucional
            WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':id' => $id,
        ':numero_socio' => $numero_socio,
        ':cedula' => $cedula,
        ':nombre' => $nombre,
        ':direccion' => $direccion,
        ':lugar_trabajo' => $lugar_trabajo,
        ':telefono1' => $telefono1,
        ':telefono2' => $telefono2,
        ':correo_personal' => $correo_personal,
        ':correo_institucional' => $correo_institucional
    ]);

    $_SESSION['mensaje'] = [
        'texto' => 'Socio actualizado correctamente!',
        'tipo' => 'success'
    ];

    header("Location: ../clientes.php");
    exit();
}
?>

