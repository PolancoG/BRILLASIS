<?php
    if (isset($_POST['prestamoId'])) {
        $prestamoId = (int)$_POST['prestamoId'];

        // Consultar el préstamo en la base de datos
        $query = $conn->prepare("SELECT monto, interes, plazo FROM prestamos WHERE id = ?");
        $query->bind_param("i", $prestamoId);
        $query->execute();
        $result = $query->get_result()->fetch_assoc();

        if ($result) {
            echo json_encode(calcularTablaAmortizacion($result['monto'], $result['interes'], $result['plazo']));
        } else {
            echo json_encode(['error' => 'Préstamo no encontrado']);
        }
    }
?>