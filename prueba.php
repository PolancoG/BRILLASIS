<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Préstamos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"> 
    <style>
        .card-table {
            margin: 20px auto;
            width: 90%;
        }
        .badge-activo {
            background-color: #28a745;
            color: white;
        }
        .badge-pendiente {
            background-color: #ffc107;
            color: black;
        }
        .badge-cancelado {
            background-color: #dc3545;
            color: white;
        }
        .btn-modulo {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="position-relative">
            <button class="btn btn-primary btn-modulo" onclick="window.location.href='prestamos.php';">Ir al Módulo de Préstamos</button>
        </div>

        <div class="card card-table">
            <div class="card-header bg-primary text-white text-center">
                <h4>Listado de Préstamos</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Monto</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Conexión a la base de datos
                        include 'db.php';

                        try {
                            // Consulta para obtener los préstamos con el nombre del cliente
                            $stmt = $conn->prepare("SELECT p.monto, p.estado, c.nombre AS cliente 
                                                    FROM prestamo p
                                                    JOIN cliente c ON p.cliente_id = c.id");
                            $stmt->execute();
                            $prestamos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($prestamos as $prestamo) {
                                // Asignar clase según el estado
                                $estadoClase = '';
                                if ($prestamo['estado'] === 'activo') {
                                    $estadoClase = 'badge-activo';
                                } elseif ($prestamo['estado'] === 'pendiente') {
                                    $estadoClase = 'badge-pendiente';
                                } elseif ($prestamo['estado'] === 'cancelado') {
                                    $estadoClase = 'badge-cancelado';
                                }
                                echo "<tr>
                                        <td>{$prestamo['cliente']}</td>
                                        <td>\${$prestamo['monto']}</td>
                                        <td><span class='badge $estadoClase'>" . ucfirst($prestamo['estado']) . "</span></td>
                                      </tr>";
                            }
                        } catch (PDOException $e) {
                            echo "<tr><td colspan='3' class='text-center'>Error al cargar los datos: {$e->getMessage()}</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
