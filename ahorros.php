<?php
    session_start();

    $role = $_SESSION['role'];

    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="imgs/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="css/logo.css">

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link href='https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css' rel='stylesheet'>
    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    
    <!----===== Data Table CSS ===== -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!--SWEET ALERT CDN CSS-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        .dataTables_filter {
            margin-bottom: 30px; /* Espacio entre el buscador y la tabla */
        }
    </style>

    
    <title>BRILLASIS Ahorro</title> 
</head>
<body style="background-color: #E4E9F7;">
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="imgs/logo.png" alt="">
                </span>

                <div class="text logo-text">
                    <span class="name">BRILLASIS</span>
                    <span class="profession"></span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                 <!--   
                <li class="search-box">
                    <i class='bx bx-search icon'></i>
                    <input type="text" placeholder="Search..."> 
                </li> 

                <ul class="menu-links"> -->
                    <li class="nav-link">
                        <a href="dashboard">
                            <i class='bx bx-home-alt icon' ></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    <?php if($role == 'admin') { ?>
                    <li class="nav-link">
                        <a href="usuarios">
                            <i class='bx bx-user icon' ></i>
                            <span class="text nav-text">Usuarios</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="companies">
                            <i class='bx bx-building-house icon'></i>
                            <span class="text nav-text">Compañias</span>
                        </a>
                    </li>
                    <?php } ?>
                    <li class="nav-link">
                        <a href="clientes">
                            <!--Identficador del icono sacado del i: bx-bar-chart-alt-2-->
                            <i class='bx icon' ><ion-icon name="people-outline"></ion-icon></i>
                            <span class="text nav-text">Socios</span>
                        </a>
                    </li>
                    <?php if($role == 'admin' || $role == 'cajerop') { ?>
                    <li class="nav-link">
                        <a href="prestamos">
                            <i class='bx icon'><ion-icon name="cash-outline"></ion-icon></i>
                            <span class="text nav-text">Prestamos</span>
                        </a>
                    </li>
                    <?php } else?>
                    <?php if($role == 'admin' || $role == 'cajeroa') { ?>
                    <li class="nav-link">
                        <a href="#">
                            <i class='bx icon' ><ion-icon name="wallet-outline"></ion-icon></i>
                            <span class="text nav-text">Ahorro</span>
                        </a>
                    </li>
                    <?php } ?>
                    <!--
                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-heart icon' ></i>
                            <span class="text nav-text">Likes</span>
                        </a>
                    </li>
                    
                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-wallet icon' ></i>
                            <span class="text nav-text">Wallets</span>
                        </a>
                    </li> -->

              <!-- </ul> -->
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="logout.php">
                        <i class='bx bx-log-out icon' ></i>
                        <span class="text nav-text">Cerrar sesion</span>
                    </a>
                </li>
                <!--
                <li class="mode">
                    <div class="sun-moon">
                        <i class='bx bx-moon icon moon'></i>
                        <i class='bx bx-sun icon sun'></i>
                    </div>
                    <span class="mode-text text">Dark mode</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li> -->
                
            </div>
        </div>

    </nav>

    <section class="home"> 
        <br>
        <div class="text">
            <img class="imglogo" src="imgs/logo.png" alt="image logo"> AHORROS
        </div>
        <br>
        <div class="card mx-auto" style="max-width: 970px; min-height: auto;">
            <div class="card-header" style="background-color: #198754;"><h2 style="color: white;">Administración de Ahorros</h2></div>
            <div class="card-body">
            <br>
                <button class="btn btn-success mb-2" data-toggle="modal" data-target="#modalAgregarAhorro" >Agregar Ahorrante</button>
                <br>
                <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalAgregarMontoAhorro" >Agregar Ahorro</button>
                <br>
                <button class="btn btn-warning mb-2" data-toggle="modal" data-target="#modalRetirarAhorro">Retirar Ahorro</button>
                <br>
                <br>
                <table id="tablaAhorros" class="display table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th># Socio</th>
                            <th>Socio</th> <!-- Cambiamos el encabezado de Cliente ID a Cliente -->
                            <th>Ahorrado</th> 
                            <th>Fecha de emision</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Modificación de la consulta para unir las tablas ahorro y cliente
                        include 'db.php';
                        
                        $stmt = $conn->query("SELECT ahorro.id, ahorro.cliente_id, cliente.numero_socio, cliente.apellido, 
                                                    cliente.nombre AS cliente_nombre, ahorro.monto, ahorro.fecha
                                            FROM ahorro
                                            JOIN cliente ON ahorro.cliente_id = cliente.id");
                  
                        
                        while ($ahorro = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                                echo "<td>" . $ahorro['numero_socio']. "</td>";
                                echo "<td>" . $ahorro['cliente_nombre'] . ' '. $ahorro['apellido'] ."</td>"; // Mostrar el nombre del cliente 
                                // echo "<td>" .  . "</td>";
                                echo "<td> RD$" . number_format($ahorro['monto'], 2, '.', ',') . "</td>";
                                echo "<td>" . $ahorro['fecha'] . "</td>";
                                if($role == 'admin') { 
                                    echo "<td>
                                        <button class='btn btn-warning btn-sm' data-id='" . $ahorro['id'] . "' onclick='editarAhorro(this)' hidden><i class='bx bxs-edit'></i></button>
                                        <button class='btn btn-info btn-sm' data-id='" . $ahorro['cliente_id'] . "' onclick='verAhorros(this)'>
                                            <i class='bx bx-search'></i>
                                        </button>
                                        <button class='btn btn-danger btn-sm' onclick='eliminarAhorro(" . $ahorro['id'] . ")'><i class='bx bxs-trash'></i></button>
                                    </td>";
                                } else {
                                    echo "<td>
                                        <button class='btn btn-warning btn-sm' data-id='" . $ahorro['id'] . "' onclick='editarAhorro(this)' disabled><i class='bx bxs-edit'></i></button>
                                        <button class='btn btn-danger btn-sm' onclick='eliminarAhorro(" . $ahorro['id'] . ")' disabled><i class='bx bxs-trash'></i></button>
                                    </td>"; 
                                }
                            echo "</tr>";
                        }
                        ?>  <!--Boton antiguo de retirar ahorro-->
                    </tbody> <!--<button class='btn btn-primary btn-sm' data-id='" . $ahorro['id'] . "' data-cliente-id='" . $ahorro['cliente_id'] . "' onclick='retirarAhorro(this)'><i class='bx bxs-wallet'></i> Retirar</button>-->
                </table>
            </div>
        </div>

        <!-- Modal para Agregar Ahorro -->
        <div class="modal fade" id="modalAgregarAhorro" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalAgregarAhorroLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="./functions/create_ahorro.php" method="POST" id="formAgregarAhorro">
                        <div class="modal-header" style="background-color: #198754;">
                            <h4 class="modal-title" style="color: white;">Agregar Ahorro</h4>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" onclick="limpiarFormulario()"></button>
                        </div>
                        <div class="modal-body">
                            <h5><strong>Nota:</strong><i> todos los campos con * son obligatorios.</i></h5>
                            <br>
                            <div class="form-group">
                                <label for="cliente_id">Socio <i class="text-danger">*</i></label>
                                <select name="cliente_id" class="form-control" required>
                                    <option selected disabled value="">Seleccione una Opción</option>
                                    <?php
                                    $stmt = $conn->query("SELECT cliente.id, cliente.nombre, cliente.apellido FROM cliente WHERE cliente.id NOT IN (SELECT cliente_id FROM ahorro WHERE monto IS NOT NULL)");
                                    while ($cliente = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='{$cliente['id']}'>{$cliente['nombre']} {$cliente['apellido']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="monto">Monto <i class="text-danger">*</i></label>
                                <input type="text" class="form-control" name="monto" id="montoAgregar" placeholder="Digite el monto aquí" onkeyPress='return isNumber(event.key);' required> <!--min="200"-->
                            </div>
                            <div class="form-group">
                                <label for="fecha">Fecha <i class="text-danger">*</i></label>
                                <input type="date" class="form-control" name="fecha" placeholder="Elija la fecha" required>
                            </div>
                        </div>
                        <div class="modal-footer" style="background-color: #c8c8c8;">
                            <button type="submit" class="btn btn-success">Guardar Ahorro</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiarFormulario()">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal para Editar Ahorro -->
        <div class="modal fade" id="modalEditarAhorro" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditarAhorroLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="./functions/edit_ahorro.php" method="POST" id="formEditarAhorro">
                        <div class="modal-header" style="background-color: #198754; color: white;">
                            <h4 class="modal-title">Editar Ahorro</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h5><strong>Nota:</strong><i> todos los campos con * son obligatorios.</i></h5>
                            <br>
                            <input type="hidden" name="id" id="edit_id">
                            <div class="form-group">
                                <label for="edit_cliente_id">Numero del Socio <i class="text-danger">*</i></label>
                                <input type="number" class="form-control" name="cliente_id" id="edit_cliente_id" readonly>
                            </div>
                            <div class="form-group">
                                <label for="edit_monto">Monto <i class="text-danger">*</i></label>
                                <input type="text" class="form-control" name="monto" id="edit_monto" onkeyPress='return isNumber(event.key);' required> <!-- min="200" -->
                            </div>
                            <div class="form-group">
                                <label for="edit_fecha">Fecha <i class="text-danger">*</i></label>
                                <input type="date" class="form-control" name="fecha" id="edit_fecha" required>
                            </div>
                        </div>
                        <div class="modal-footer" style="background-color: #c8c8c8;">
                            <button type="submit" class="btn btn-success">Guardar Cambios</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modalAgregarMontoAhorro" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalAgregarMontoAhorroLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="formAgregarMontoAhorro">
                        <div class="modal-header" style="background-color: #198754; color: white;">
                            <h4 class="modal-title" id="modalAgregarMontoAhorroLabel">Agregar Dinero al Ahorro</h4>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" onclick="limpiarFormulario()"></button>
                        </div>
                        <div class="modal-body">
                            <h5><strong>Nota:</strong><i> todos los campos con * son obligatorios.</i></h5>
                            <br>
                            <div class="form-group">
                                <label for="compania">Compañía <i class="text-danger">*</i></label>
                                <select id="compania" name="compania_id" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una Compañía</option>
                                    <?php
                                    $stmt = $conn->query("SELECT id, nombre FROM compania");
                                    while ($compania = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='{$compania['id']}'>{$compania['nombre']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cliente_id">Socio <i class="text-danger">*</i></label>
                                <select id="cliente_id" name="cliente_id" class="form-control" required>
                                    <option value="" selected disabled>Seleccione el socio de la compañía</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="monto">Monto a depositar: <i class="text-danger">*</i></label>
                                <input type="text" id="monto" name="monto" class="form-control" placeholder="Ingrese el monto adicional" onkeypress="return isNumber(event.key);" required>
                            </div>
                            <div class="form-group">
                                <label for="comentario">Comentario (opcional):</label>
                                <textarea id="comentario" name="comentario" class="form-control" placeholder="Escriba un comentario si es necesario"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Agregar Dinero</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiarFormulario()">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


<!-- Modal para ver los ahorros del cliente -->
<div class="modal fade" id="modalVerAhorros" tabindex="-1" aria-labelledby="modalVerAhorrosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:rgb(47, 186, 204);">
                <h5 class="modal-title" id="modalVerAhorrosLabel" style="color: white">Historial de Ahorros</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="clienteAhorrosId">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Fecha y hora</th>
                                <th>Monto</th>
                                <th>Número de Socio</th>
                                <th>Comentario</th>
                            </tr>
                        </thead>
                        <tbody id="tablaAhorrosBody">
                            <!-- Aquí se insertarán los registros dinámicamente -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>



        <div class="modal fade" id="modalRetirarAhorro" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalRetirarAhorroLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="formRetirarAhorro">
                        <div class="modal-header" style="background-color: #ffc107; color: white;">
                            <h4 class="modal-title" id="modalRetirarAhorroLabel">Retirar Dinero del Ahorro</h4>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" onclick="limpiarFormularioRetiro()"></button>
                        </div>
                        <div class="modal-body">
                            <h5><strong>Nota:</strong><i> todos los campos con * son obligatorios.</i></h5>
                            <br>
                            <div class="form-group">
                                <label for="companiaRetiro">Compañía <i class="text-danger">*</i></label>
                                <select id="companiaRetiro" name="compania_id" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una Compañía</option>
                                    <?php
                                    $stmt = $conn->query("SELECT id, nombre FROM compania");
                                    while ($compania = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='{$compania['id']}'>{$compania['nombre']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="clienteRetiro">Socio <i class="text-danger">*</i></label>
                                <select id="clienteRetiro" name="cliente_id" class="form-control" required>
                                    <option value="" selected disabled>Seleccione el socio de la compañía</option>
                                </select>
                            </div><br>
                            <div class="form-group">
                                <label for="ahorroTotal"><strong>Ahorro Total que puede retirar:</strong></label>
                                <input type="text" id="ahorroTotal" class="form-control" disabled>
                            </div><br>
                            <div class="form-group">
                                <label for="montoRetiro">Monto a retirar: <i class="text-danger">*</i></label>
                                <input type="text" id="montoRetiro" name="monto" class="form-control" placeholder="Ingrese el monto a retirar" onkeyPress='return isNumber(event.key);' required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-warning">Retirar Dinero</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiarFormularioRetiro()">Cerrar</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>


        <br><br><br><br>
    </section>
    <script src="./js/ahorro.js"></script>
    <script src="js/script.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="js/keyboard.js"></script>
   <!-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> -->
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
   <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
     <!-- ====== ionicons ======= -->
     <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function limpiarFormulario() {
            const form = document.getElementById('formAgregarAhorro');
            form.reset(); // Limpia todos los campos del formulario
            const f = document.getElementById('formAgregarMontoAhorro');
            f.reset(); 
        } 
    </script>
    <script>

         // Cargar DataTable
        $(document).ready(function() {
            $('#tablaAhorros').DataTable({
                //lengthMenu: [ [5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "Todos"] ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                }
            });

            // Validación al agregar ahorro
            $('#formAgregarAhorro').on('submit', function (e) {
                const monto = parseFloat($('#montoAgregar').val());
                if (monto < 200) {
                    e.preventDefault();
                    Swal.fire('Error', 'El monto mínimo para aperturar el ahorro debe ser de $200.00', 'error').then(() => location.reload());
                }
            });

            // Validación al editar ahorro
            $('#formEditarAhorro').on('submit', function (e) {
                const monto = parseFloat($('#edit_monto').val());
                if (monto < 200) {
                    e.preventDefault();
                    Swal.fire('Error', 'El monto mínimo de ahorro debe ser $200.', 'error').then(() => location.reload());
                }
            });

        });

        // SweetAlert para confirmar las acciones de agregar, editar y eliminar
        <?php if (isset($_SESSION['alerta'])): ?>
            Swal.fire({
                icon: "<?php echo $_SESSION['alerta']['icon']; ?>",
                title: "<?php echo $_SESSION['alerta']['title']; ?>",
                text: "<?php echo $_SESSION['alerta']['text']; ?>",
                showConfirmButton: false,
                timer: 2000,
            });
        <?php unset($_SESSION['alerta']); endif; ?>
    </script>
    <script>

function verAhorros(button) {
    const clienteId = $(button).data('id');

    $.ajax({
        url: '/functions/get_ahorros_info.php',
        type: 'GET',
        data: { cliente_id: clienteId },
        success: function (response) {
            const data = JSON.parse(response);

            if (data.success) {
                let contenido = '';
                data.ahorros.forEach(ahorro => {
                    contenido += `
                        <tr>
                            <td>${ahorro.fecha_agregado}</td>
                            <td>RD$${parseFloat(ahorro.monto_agregado).toFixed(2)}</td>
                            <td>${ahorro.numero_socio}</td>
                            <td>${ahorro.comentario || 'N/A'}</td>
                        </tr>
                    `;
                });

                $('#tablaAhorrosBody').html(contenido);
                $('#modalVerAhorros').modal('show');
            } else {
                Swal.fire('Error', 'No se encontraron registros de ahorros para este cliente.', 'error');
            }
        },
        error: function () {
            Swal.fire('Error', 'No se pudo obtener la información de los ahorros.', 'error');
        }
    });
}


      /*  $(document).ready(function () {
            // Cargar clientes al seleccionar una compañía
            $('#compania').on('change', function () {
                const companiaId = $(this).val();

                if (companiaId) {
                    $.ajax({
                        url: '/functions/get_clientes_por_compania.php',
                        type: 'GET',
                        data: { compania_id: companiaId },
                        success: function (response) {
                            const clientes = JSON.parse(response);
                            const clienteSelect = $('#cliente_id');
                            clienteSelect.empty().append('<option value="" selected disabled>Seleccione el socio</option>');
                            clientes.forEach(cliente => {
                                clienteSelect.append(`<option value="${cliente.id}">${cliente.nombre}</option>`);
                            });
                        },
                        error: function () {
                            Swal.fire('Error', 'No se pudo cargar los clientes de la compañía.', 'error');
                        }
                    });
                }
            });

            // Manejar el envío del formulario
            $('#formAgregarMontoAhorro').on('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);

                $.ajax({
                    url: '/functions/agregar_monto_ahorro.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        const data = JSON.parse(response);
                        if (data.success) {
                            Swal.fire('Éxito', data.message, 'success').then(() => {
                                $('#modalAgregarMontoAhorro').modal('hide');
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'No se pudo agregar el monto al ahorro.', 'error');
                    }
                });
            });
        }); */

        $(document).ready(function () {
            // Cargar clientes al seleccionar una compañía
            $('#compania').on('change', function () {
                const companiaId = $(this).val();

                if (companiaId) {
                    $.ajax({
                        url: '/functions/get_clientes_por_compania.php',
                        type: 'GET',
                        data: { compania_id: companiaId },
                        success: function (response) {
                            const clientes = JSON.parse(response);
                            const clienteSelect = $('#cliente_id');
                            clienteSelect.empty().append('<option value="" selected disabled>Seleccione el socio</option>');
                            clientes.forEach(cliente => {
                                clienteSelect.append(`<option value="${cliente.id}">${cliente.nombre} ${cliente.apellido}</option>`);
                            });
                        },
                        error: function () {
                            Swal.fire('Error', 'No se pudo cargar los clientes de la compañía.', 'error');
                        }
                    });
                }
            });

            // Manejar el envío del formulario
          /*  $('#formAgregarMontoAhorro').on('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);

                $.ajax({
                    url: '/functions/agregar_monto_ahorro.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        const data = JSON.parse(response);
                        if (data.success) {
                            Swal.fire('Éxito', data.message, 'success').then(() => {
                                $('#modalAgregarMontoAhorro').modal('hide');
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'No se pudo agregar el monto al ahorro.', 'error');
                    }
                });
            }); */

            // Manejar el envío del formulario de agregar ahorro
            $('#formAgregarMontoAhorro').on('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(this);

                $.ajax({
                    url: '/functions/agregar_monto_ahorro.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        const data = JSON.parse(response);
                        if (data.success) {
                            Swal.fire({
                                title: 'Depósito realizado con éxito',
                                text: 'El depósito ha sido registrado correctamente.',
                                icon: 'success',
                                showCancelButton: true,
                                allowOutsideClick: false, // Evita que la alerta se cierre automáticamente
                                allowEscapeKey: false,   // Evita que se cierre con la tecla ESC
                                confirmButtonText: 'Imprimir Recibo',
                                cancelButtonText: 'Cerrar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.open(`/functions/generar_recibo_deposito.php?ahorro_id=${data.ahorro_id}`, '_blank');
                                }
                                // Recargar la página después de cerrar la alerta
                                location.reload();
                            });

                            // Cerrar el modal manualmente después de mostrar la alerta
                            $('#modalAgregarMontoAhorro').modal('hide');

                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'No se pudo agregar el monto al ahorro.', 'error');
                    }
                });
            });


        });


            function retirarAhorro(button) {
                const ahorroId = button.getAttribute('data-id');
                const clienteId = button.getAttribute('data-cliente-id');

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: '¿Deseas retirar todo el ahorro de este Socio?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, retirar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Solicitud AJAX
                        fetch('/functions/retirar_ahorro.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ cliente_id: clienteId, ahorro_id: ahorroId })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Éxito', data.message, 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error al intentar retirar', data.message, 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error', 'Ocurrió un problema al procesar la solicitud.', 'error');
                        });
                    }
                });
            }

            function generarReciboAhorro(button) {
                const ahorroId = $(button).data('id');

                Swal.fire({
                    title: 'Generando recibo...',
                    text: 'Por favor, espere.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                window.open(`/functions/generar_recibo_ahorro.php?id=${ahorroId}`, '_blank');

                Swal.close();
            }

    </script>
    <script>

        function limpiarFormularioRetiro() {
            const form = document.getElementById('formRetirarAhorro');
            form.reset(); // Limpia todos los campos del formulario
        }

        $(document).ready(function () {
            // Cargar socios al seleccionar compañía
            $('#companiaRetiro').on('change', function () {
                const companiaId = $(this).val();
                $.ajax({
                    url: '/functions/get_socios.php',
                    type: 'POST',
                    data: { compania_id: companiaId },
                    success: function (response) {
                        const data = JSON.parse(response);
                        if (data.success) {
                            const socios = data.socios;
                            let options = '<option value="" selected disabled>Seleccione el socio</option>';
                            socios.forEach(socio => {
                                options += `<option value="${socio.id}" data-ahorro="${socio.ahorro}">${socio.nombre} ${socio.apellido}</option>`;
                            });
                            $('#clienteRetiro').html(options);
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'No se pudo cargar los socios.', 'error');
                    }
                });
            });

            // Mostrar ahorro total del socio seleccionado
            $('#clienteRetiro').on('change', function () {
                const ahorroTotal = $(this).find(':selected').data('ahorro');
                //$('#ahorroTotal').val(`RD$${parseFloat(ahorroTotal).toFixed(2)}`);
                $('#ahorroTotal').val(`RD$${parseFloat(ahorroTotal).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`);
            });

            // Manejar el envío del formulario de retiro
            $('#formRetirarAhorro').on('submit', function (e) {
                e.preventDefault();

                const clienteId = $('#clienteRetiro').val();
                const ahorroTotal = parseFloat($('#clienteRetiro').find(':selected').data('ahorro'));
                const montoRetiro = parseFloat($('#montoRetiro').val());

                if (montoRetiro > ahorroTotal) {
                    Swal.fire('Error', 'El monto a retirar no puede ser mayor al ahorro total del Socio.', 'error');
                    return;
                }

                if (montoRetiro < 100) {
                    Swal.fire('Error', 'El monto a retirar debe ser mayor o igual a RD$100.', 'error');
                    return;
                }

                $.ajax({
                    url: '/functions/retirar_ahorro.php',
                    type: 'POST',
                    data: { cliente_id: clienteId, monto: montoRetiro },
                    success: function (response) {
                        const data = JSON.parse(response);
                        if (data.success) {
                            Swal.fire({
                                title: 'Éxito',
                                text: 'El retiro se realizó con éxito.',
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonText: 'Imprimir Recibo',
                                cancelButtonText: 'Cerrar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.open(`/functions/generar_recibo.php?recibo_id=${data.recibo_id}`, '_blank');
                                    location.reload();
                                } else {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'No se pudo procesar el retiro.', 'error');
                    }
                });
            });

        });


    </script>
</body>
</html>