<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
// delete.php
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
    $sql = "DELETE FROM cliente WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    
    $_SESSION['mensaje'] = [
        'texto' => 'Socio eliminado correctamente!',
        'tipo' => 'success'
    ];

    header("Location: ../clientes.php");
    exit();
}
?>
