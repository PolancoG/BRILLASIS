<?php
   /* session_start();
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
    } */

   /* if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $cliente_id = $_POST['cliente_id'];
        $monto = $_POST['monto'];
        $interes = $_POST['interes'];
        $plazo = $_POST['plazo'];
        $estado = $_POST['estado'];

        try {
            // Verificar que el cliente tenga un ahorro mayor a 200
            $stmt = $conn->prepare("SELECT monto FROM ahorro WHERE cliente_id = :cliente_id AND monto >= 200");
            $stmt->execute([':cliente_id' => $cliente_id]);
            $ahorro = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$ahorro) {
                // Si el cliente no tiene un ahorro mayor a 200
                $_SESSION['alerta'] = [
                    'icon' => 'error',
                    'title' => 'Error al registrar',
                    'text' => 'El cliente debe tener un ahorro mayor o igual a $200 para poder registrar un préstamo.',
                ];
                //echo "<script>Swal.fire('Error', 'El cliente debe tener un ahorro mayor o igual a 200 para poder registrar un préstamo.', 'error');</script>";
                header('Location: ../prestamos.php');
                exit();
            }

            // Verificar si el cliente tiene préstamos pendientes
            $stmt = $conn->prepare("SELECT * FROM prestamo WHERE cliente_id = :cliente_id AND estado != 'cancelado'");
            $stmt->execute([':cliente_id' => $cliente_id]);
            $prestamoExistente = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($prestamoExistente) {
                // Si el cliente tiene un préstamo pendiente
                $_SESSION['alerta'] = [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'El cliente ya tiene un préstamo registrado!.',
                ];
                //echo "<script>Swal.fire('Error', 'El cliente ya tiene un préstamo pendiente o activo.', 'error');</script>";
                header('Location: ../prestamos.php');
                exit();
            }

            // Insertar el nuevo préstamo
            $stmt = $conn->prepare("INSERT INTO prestamo (cliente_id, monto, interes, plazo, estado) VALUES (:cliente_id, :monto, :interes, :plazo, :estado)");
            $stmt->execute([
                ':cliente_id' => $cliente_id,
                ':monto' => $monto,
                ':interes' => $interes,
                ':plazo' => $plazo,
                ':estado' => $estado
            ]);

            // Redirigir con éxito
            $_SESSION['alerta'] = [
                'icon' => 'success',
                'title' => 'Éxito',
                'text' => 'Préstamo registrado correctamente.',
            ];

            header('Location: ../prestamos.php');
            exit();

            //echo "<script>Swal.fire('Éxito', 'Préstamo registrado correctamente.', 'success').then(() => { window.location.href = '../prestamos.php'; });</script>";

        } catch (PDOException $e) {
            echo "<script>Swal.fire('Error', 'Error al registrar el préstamo: " . $e->getMessage() . "', 'error');</script>";
            exit();
        }
    } 

$cliente_id = $_POST['cliente_id'] ?? null;
$monto = $_POST['monto'] ?? null;
$interes = $_POST['interes'] ?? null;
$plazo = $_POST['plazo'] ?? null;
$estado = $_POST['estado'] ?? null;

if (empty($cliente_id) || empty($monto) || empty($interes) || empty($plazo) || empty($estado)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
    exit;
}

try {
    $stmt = $conn->prepare("
        INSERT INTO prestamo (cliente_id, monto, interes, plazo, estado) 
        VALUES (:cliente_id, :monto, :interes, :plazo, :estado)
    ");
    $stmt->execute([
        ':cliente_id' => $cliente_id,
        ':monto' => $monto,
        ':interes' => $interes,
        ':plazo' => $plazo,
        ':estado' => $estado
    ]);

    echo json_encode(['success' => true, 'message' => 'Préstamo agregado exitosamente.']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error al agregar el préstamo: ' . $e->getMessage()]);
} */
/*
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cliente_id = $_POST['cliente_id'] ?? null;
    $monto = $_POST['monto'] ?? null;
    $interes = $_POST['interes'] ?? null;
    $plazo = $_POST['plazo'] ?? null;
    $estado = $_POST['estado'] ?? null;

    if (empty($cliente_id) || empty($monto) || empty($interes) || empty($plazo) || empty($estado)) {
        echo json_encode([
            'success' => false,
            'message' => 'Todos los campos son obligatorios.'
        ]);
        exit;
    }

    try {
        // Verificar que el cliente tenga un ahorro mayor o igual a $200
        $stmt = $conn->prepare("SELECT monto FROM ahorro WHERE cliente_id = :cliente_id AND monto >= 200");
        $stmt->execute([':cliente_id' => $cliente_id]);
        $ahorro = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$ahorro) {
            echo json_encode([
                'success' => false,
                'message' => 'El cliente debe tener un ahorro mayor o igual a $200 para poder registrar un préstamo.'
            ]);
            exit;
        }

        // Verificar si el cliente tiene préstamos pendientes
        $stmt = $conn->prepare("SELECT * FROM prestamo WHERE cliente_id = :cliente_id AND estado != 'cancelado'");
        $stmt->execute([':cliente_id' => $cliente_id]);
        $prestamoExistente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($prestamoExistente) {
            echo json_encode([
                'success' => false,
                'message' => 'El cliente ya tiene un préstamo registrado.'
            ]);
            exit;
        }

        // Insertar el nuevo préstamo
        $stmt = $conn->prepare("
            INSERT INTO prestamo (cliente_id, monto, interes, plazo, estado) 
            VALUES (:cliente_id, :monto, :interes, :plazo, :estado)
        ");
        $stmt->execute([
            ':cliente_id' => $cliente_id,
            ':monto' => $monto,
            ':interes' => $interes,
            ':plazo' => $plazo,
            ':estado' => $estado
        ]);

        echo json_encode([
            'success' => true,
            'message' => 'Préstamo registrado correctamente.'
        ]);
        exit;
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error al registrar el préstamo: ' . $e->getMessage()
        ]);
        exit;
    }
}
*/
?>

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

    require '/laragon/www/cooplight/functions/amortizacion_helper.php'; // Archivo con la función de cálculo de amortización

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $cliente_id = $_POST['cliente_id'] ?? null;
        $monto = $_POST['monto'] ?? null;
        $interes = $_POST['interes'] ?? null;
        $plazo = $_POST['plazo'] ?? null;
        $estado = $_POST['estado'] ?? null;

        if (empty($cliente_id) || empty($monto) || empty($interes) || empty($plazo) || empty($estado)) {
            echo json_encode([
                'success' => false,
                'message' => 'Todos los campos son obligatorios.'
            ]);
            exit;
        }

        try {
            // Verificar que el cliente tenga un ahorro mayor o igual a $200
            $stmt = $conn->prepare("SELECT monto FROM ahorro WHERE cliente_id = :cliente_id AND monto >= 200");
            $stmt->execute([':cliente_id' => $cliente_id]);
            $ahorro = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$ahorro) {
                echo json_encode([
                    'success' => false,
                    'message' => 'El cliente debe tener un ahorro mayor o igual a $200 para poder registrar un préstamo.'
                ]);
                exit;
            }

            // Verificar si el cliente tiene préstamos pendientes
            $stmt = $conn->prepare("
                SELECT * 
                FROM prestamo 
                WHERE cliente_id = :cliente_id 
                AND estado NOT IN ('cancelado', 'activo_terminado')
            ");
            $stmt->execute([':cliente_id' => $cliente_id]);
            $prestamoExistente = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($prestamoExistente) {
                echo json_encode([
                    'success' => false,
                    'message' => 'El cliente ya tiene un préstamo activo o pendiente.'
                ]);
                exit;
            }

           /* $stmt = $conn->prepare("SELECT * FROM prestamo WHERE cliente_id = :cliente_id AND estado != 'cancelado'");
            $stmt->execute([':cliente_id' => $cliente_id]);
            $prestamoExistente = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($prestamoExistente) {
                echo json_encode([
                    'success' => false,
                    'message' => 'El cliente ya tiene un préstamo registrado.'
                ]);
                exit;
            } */

            // Iniciar transacción
            $conn->beginTransaction();

            // Insertar el nuevo préstamo
            $stmt = $conn->prepare("
                INSERT INTO prestamo (cliente_id, monto, interes, plazo, estado) 
                VALUES (:cliente_id, :monto, :interes, :plazo, :estado)
            ");
            $stmt->execute([
                ':cliente_id' => $cliente_id,
                ':monto' => $monto,
                ':interes' => $interes,
                ':plazo' => $plazo,
                ':estado' => $estado
            ]);
            $prestamo_id = $conn->lastInsertId();

            // Calcular amortización
            $amortizacion = calcularAmortizacion($monto, $interes, $plazo);

            // Guardar amortización en la tabla
            $stmt = $conn->prepare("
                INSERT INTO tabla_amortizacion (prestamo_id, cuota_numero, fecha_pago, monto_cuota, interes, capital, saldo_restante)
                VALUES (:prestamo_id, :cuota_numero, :fecha_pago, :monto_cuota, :interes, :capital, :saldo_restante)
            ");
            foreach ($amortizacion as $cuota) {
                $stmt->execute([
                    ':prestamo_id' => $prestamo_id,
                    ':cuota_numero' => $cuota['cuota'],
                    ':fecha_pago' => $cuota['fecha_pago'],
                    ':monto_cuota' => $cuota['cuota_mensual'],
                    ':interes' => $cuota['interes'],
                    ':capital' => $cuota['capital'],
                    ':saldo_restante' => $cuota['saldo_restante']
                ]);
            }

            // Confirmar transacción
            $conn->commit();

            echo json_encode([
                'success' => true,
                'message' => 'Préstamo registrado correctamente, incluyendo la tabla de amortización.'
            ]);
            exit;

        } catch (PDOException $e) {
            // Revertir transacción en caso de error
            $conn->rollBack();
            echo json_encode([
                'success' => false,
                'message' => 'Error al registrar el préstamo: ' . $e->getMessage()
            ]);
            exit;
        }
    }
?>
