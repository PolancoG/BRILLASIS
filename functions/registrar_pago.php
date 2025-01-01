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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $prestamo_id = $_POST['prestamo_id'] ?? null;
        $cuota_numero = $_POST['cuota_numero'] ?? null;
        $monto_pago = $_POST['monto_pago'] ?? null;
        $metodo_pago = $_POST['metodo_pago'] ?? null;

        if (empty($prestamo_id) || empty($cuota_numero) || empty($monto_pago) || empty($metodo_pago)) {
            echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
            exit;
        }

        try {
            // Obtener información de la cuota
            $stmt = $conn->prepare("SELECT monto_cuota, saldo_restante FROM tabla_amortizacion WHERE prestamo_id = ? AND cuota_numero = ?");
            $stmt->execute([$prestamo_id, $cuota_numero]);
            $cuota = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$cuota) {
                echo json_encode(['success' => false, 'message' => 'La cuota no existe.']);
                //file_put_contents('debug.txt', print_r($_POST, true));
                exit;
            } 

            if ($prestamo_id === 'undefined' || $cuota_numero === 'undefined') {
                echo json_encode(['success' => false, 'message' => 'Error: Prestamo ID o Cuota Número no definidos.']);
                exit;
            }

            // Verificar si el cliente tiene suficiente ahorro para pagar
            if ($metodo_pago === 'ahorro') {
                $stmt = $conn->prepare("SELECT monto FROM ahorro WHERE cliente_id = (SELECT cliente_id FROM prestamo WHERE id = ?)");
                $stmt->execute([$prestamo_id]);
                $ahorro = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$ahorro || $ahorro['monto'] < $monto_pago) {
                    echo json_encode(['success' => false, 'message' => 'El cliente no tiene suficiente ahorro para pagar esta cuota.']);
                    exit;
                }

                // Limitar a pagar solo una cuota con ahorro si debe más de una
                $stmt = $conn->prepare("SELECT COUNT(*) AS cuotas_pendientes FROM tabla_amortizacion WHERE prestamo_id = ? AND saldo_restante > 0");
                $stmt->execute([$prestamo_id]);
                $cuotasPendientes = $stmt->fetch(PDO::FETCH_ASSOC)['cuotas_pendientes'];

                if ($cuotasPendientes > 1) {
                    echo json_encode(['success' => false, 'message' => 'El cliente solo puede pagar una cuota con ahorro si tiene más de una pendiente.']);
                    exit;
                }
            }

            // Registrar el pago
            $stmt = $conn->prepare("INSERT INTO pagos_cuotas (prestamo_id, cuota_numero, monto_pago, metodo_pago) VALUES (?, ?, ?, ?)");
            $stmt->execute([$prestamo_id, $cuota_numero, $monto_pago, $metodo_pago]);

            // Actualizar saldo restante de la cuota
            $nuevoSaldo = $cuota['saldo_restante'] - $monto_pago;
            $stmt = $conn->prepare("UPDATE tabla_amortizacion SET saldo_restante = ? WHERE prestamo_id = ? AND cuota_numero = ?");
            $stmt->execute([$nuevoSaldo, $prestamo_id, $cuota_numero]);

            // Si se pagó con ahorro, descuéntalo del monto ahorrado
            if ($metodo_pago === 'ahorro') {
                $stmt = $conn->prepare("UPDATE ahorro SET monto = monto - ? WHERE cliente_id = (SELECT cliente_id FROM prestamo WHERE id = ?)");
                $stmt->execute([$monto_pago, $prestamo_id]);
            }

            echo json_encode(['success' => true, 'message' => 'Pago registrado correctamente.']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error al registrar el pago: ' . $e->getMessage()]);
        }
    }
?>
