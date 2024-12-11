<?php
    session_start();
    $role = $_SESSION['role'];

    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }
// create.php
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
    $numero_socio = $_POST['numero_socio'];
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $lugar_trabajo = $_POST['lugar_trabajo'];
    $telefono1 = $_POST['telefono1'];
    $telefono2 = $_POST['telefono2'];
    $correo_personal = $_POST['correo_personal'];
    $correo_institucional = $_POST['correo_institucional'];

    $sql = "INSERT INTO cliente (numero_socio, cedula, nombre, direccion, lugar_trabajo, telefono1, telefono2, correo_personal, correo_institucional)
            VALUES (:numero_socio, :cedula, :nombre, :direccion, :lugar_trabajo, :telefono1, :telefono2, :correo_personal, :correo_institucional)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
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
        'texto' => 'Socio agregado exitosamente!',
        'tipo' => 'success'
    ];
    header("Location: ../clientes.php");
    exit(); 
}

/*
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $lugar_trabajo = $_POST['lugar_trabajo'];
    $telefono1 = $_POST['telefono1'];
    $telefono2 = $_POST['telefono2'];
    $correo_personal = $_POST['correo_personal'];
    $correo_institucional = $_POST['correo_institucional'];

    $sql = "INSERT INTO cliente (cedula, nombre, direccion, lugar_trabajo, telefono1, telefono2, correo_personal, correo_institucional)
            VALUES (:cedula, :nombre, :direccion, :lugar_trabajo, :telefono1, :telefono2, :correo_personal, :correo_institucional)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':cedula' => $cedula,
        ':nombre' => $nombre,
        ':direccion' => $direccion,
        ':lugar_trabajo' => $lugar_trabajo,
        ':telefono1' => $telefono1,
        ':telefono2' => $telefono2,
        ':correo_personal' => $correo_personal,
        ':correo_institucional' => $correo_institucional
    ]);

    header("Location: ../clientes.php");
    exit(); 
} */
?>
<!--<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Cliente</title>
</head>
<body>
    <h2>Agregar Cliente</h2>
    <form method="POST">
        <label>Cédula:</label><input type="text" name="cedula" required><br>
        <label>Nombre:</label><input type="text" name="nombre" required><br>
        <label>Dirección:</label><input type="text" name="direccion"><br>
        <label>Lugar de Trabajo:</label><input type="text" name="lugar_trabajo"><br>
        <label>Teléfono 1:</label><input type="text" name="telefono1"><br>
        <label>Teléfono 2:</label><input type="text" name="telefono2"><br>
        <label>Correo Personal:</label><input type="email" name="correo_personal"><br>
        <label>Correo Institucional:</label><input type="email" name="correo_institucional"><br>
        <button type="submit">Guardar</button>
    </form>
</body>
</html> -->
