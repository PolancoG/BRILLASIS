<?php
    // Configuración para manejar solicitudes JSON
    header("Content-Type: application/json");

    // Conexión a la base de datos
    include './db.php'; // Asegúrate de tener este archivo configurado con tu conexión a la base de datos

    // Obtener los datos enviados desde el frontend
    $data = json_decode(file_get_contents("php://input"), true);

    // Verificar que se haya enviado el ID del cliente
    if (!isset($data['clienteId'])) {
        echo json_encode(['error' => 'No se proporcionó el ID del cliente']);
        exit;
    }

    $clienteId = (int)$data['clienteId'];

    try {
        // Consultar los préstamos asociados al cliente
        $query = $conn->prepare("SELECT id, monto, interes, plazo, fecha_aprobacion, estado 
                                FROM prestamo 
                                WHERE cliente_id = ?");
        $query->bind_param("i", $clienteId);
        $query->execute();
        $result = $query->get_result();

        $prestamos = [];

        // Recorrer los resultados y construir la respuesta
        while ($row = $result->fetch_assoc()) {
            $prestamos[] = [
                'id' => $row['id'],
                'monto' => $row['monto'],
                'interes' => $row['interes'],
                'plazo' => $row['plazo'],
                'fecha_aprobacion' => $row['fecha_aprobacion'],
                'estado' => $row['estado']
            ];
        }

        // Enviar los préstamos en formato JSON
        echo json_encode($prestamos);
    } catch (Exception $e) {
        echo json_encode(['error' => 'Error al consultar los préstamos: ' . $e->getMessage()]);
        exit;
    }
?>