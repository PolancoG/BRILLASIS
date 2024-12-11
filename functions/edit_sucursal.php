<?php
  session_start();
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
/*
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $compania_id = $_POST['compania_id'];

        try {
            $stmt = $conn->prepare("UPDATE sucursal SET nombre = ?, direccion = ?, telefono = ?, compania_id = ? WHERE id = ?");
            $stmt->execute([$nombre, $direccion, $telefono, $compania_id, $id]);
            echo json_encode(['success' => true, 'message' => 'Sucursal actualizada correctamente']);

        } catch (PDOException $e) {
            $_SESSION['alerta'] = [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Hubo un problema al actualizar: ' . $e->getMessage()
            ];
        }

        header("Location: ../companies.php");
        exit();
    } */

    // Obtener datos del formulario
/*$id = $_POST['id'] ?? null;
$nombre = $_POST['nombre'] ?? '';
$direccion = $_POST['direccion'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$compania_id = $_POST['compania_id'] ?? '';

if (empty($id) || empty($nombre) || empty($direccion) || empty($telefono) || empty($compania_id)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
    exit;
}

try {
    $stmt = $conn->prepare("
        UPDATE sucursal
        SET nombre = :nombre, direccion = :direccion, telefono = :telefono, compania_id = :compania_id
        WHERE id = :id
    ");
    $stmt->execute([
        ':id' => $id,
        ':nombre' => $nombre,
        ':direccion' => $direccion,
        ':telefono' => $telefono,
        ':compania_id' => $compania_id
    ]);

    echo json_encode(['success' => true, 'message' => 'Sucursal actualizada exitosamente.']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar la sucursal: ' . $e->getMessage()]);
}*/

$id = $_POST['id'] ?? null;
$nombre = $_POST['nombre'] ?? '';
$direccion = $_POST['direccion'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$provincia = $_POST['provincia'] ?? '';
$compania_id = $_POST['compania_id'] ?? '';

if (empty($id) || empty($nombre) || empty($direccion) || empty($telefono) || empty($provincia) || empty($compania_id)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
    exit;
}

try {
    $stmt = $conn->prepare("
        UPDATE sucursal
        SET nombre = :nombre, direccion = :direccion, telefono = :telefono, provincia = :provincia, compania_id = :compania_id
        WHERE id = :id
    ");
    $stmt->execute([
        ':id' => $id,
        ':nombre' => $nombre,
        ':direccion' => $direccion,
        ':telefono' => $telefono,
        ':provincia' => $provincia,
        ':compania_id' => $compania_id
    ]);

    echo json_encode(['success' => true, 'message' => 'Sucursal actualizada exitosamente.']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar la sucursal: ' . $e->getMessage()]);
}

?>
