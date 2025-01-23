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
    <link rel="stylesheet" href="css/prestamos.css">
    <link rel="stylesheet" href="css/cards.css">
    <link rel="shortcut icon" href="imgs/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="css/logo.css">

    <!----===== Boxicons CSS and FontAwesome Icons ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <!--SWEET ALERT CDN CSS-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!----===== Data Table CSS ===== -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!--SWEET ALERT CDN CSS-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
   <style>
     .badge {
        padding: 0.5em 0.8em;
        font-size: 0.9em;
        border-radius: 0.5rem;
        color: #fff;
        display: inline-block;
        width: fit-content;
    }

    .bg-success {
        background-color: #28a745; /* Verde */
    }

    .bg-warning {
        background-color: #ffc107; /* Amarillo */
        color: #212529; /* Contraste para amarillo */
    }

    .bg-danger {
        background-color: #dc3545; /* Rojo */
    }
   </style>
   <style>
        .dataTables_filter {
            margin-bottom: 30px; /* Espacio entre el buscador y la tabla */
        }
    </style>

    <title>BRILLASIS Prestamos</title> 
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
                        <a href="#">
                            <i class='bx icon'><ion-icon name="cash-outline"></ion-icon></i>
                            <span class="text nav-text">Prestamos</span>
                        </a>
                    </li>
                    <?php } else ?>
                    <?php if($role == 'admin' || $role == 'cajeroa') { ?>
                    <li class="nav-link">
                        <a href="ahorros">
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
            <img class="imglogo" src="imgs/logo.png" alt="image logo"> PRESTAMOS 
        </div>
        <br>

        <!-- ===========    CRUD de prestamos   =========== -->
        <br>
        <div class="card mx-auto" style="max-width: 1100px; min-height: auto;">
            <div class="card-header" style="background-color: #198754;"><h2 style="color: white;">Administración de los Préstamos</h2></div>
            <div class="card-body">
                <!-- <h2 class="card-title text-center">Datos de los Préstamos</h2><br><br> -->
                 <br>
                <button class="btn" data-toggle="modal" data-target="#modalAgregarPrestamo" style="background-color: #198754; color: white;">Agregar Préstamo</button>
                <div class="d-grid d-md-flex justify-content-md-end">
                    <!-- boton para reporte -->
                    <button id="btnReporte" class="btn btn-secondary" hidden>Reporte</button>
                </div>
                <br><br>

                <table id="tablaPrestamos" class="display table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th># Socio</th>
                            <th>Socio</th>
                            <th>Monto</th>
                            <th>Interés</th>
                            <th>Plazo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require 'db.php';
                        // Consulta para obtener los datos de los préstamos con el cliente relacionado
                        $stmt = $conn->query("SELECT prestamo.id, cliente.numero_socio, cliente.apellido, 
                                                    cliente.nombre AS cliente_nombre, prestamo.monto, prestamo.interes, 
                                                    prestamo.plazo, prestamo.estado
                                            FROM prestamo
                                            JOIN cliente ON prestamo.cliente_id = cliente.id");
                        while ($prestamo = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . $prestamo['numero_socio'] . "</td>";
                            echo "<td>" . $prestamo['cliente_nombre'] .''. $prestamo['apellido']."</td>";
                            echo "<td>RD$" . number_format($prestamo['monto'], 2, '.', ',') . "</td>";
                            echo "<td>" . $prestamo['interes'] . "%</td>";
                            echo "<td>" . $prestamo['plazo'] . "</td>";

                            // Estado con estilos dinámicos
                            $estadoClase = '';
                            if ($prestamo['estado'] == 'activo_bien') $estadoClase = 'bg-success';
                            elseif ($prestamo['estado'] == 'activo_problemas') $estadoClase = 'bg-warning';
                            elseif ($prestamo['estado'] == 'activo_terminado') $estadoClase = 'bg-danger';
                            elseif ($prestamo['estado'] == 'pendiente') $estadoClase = 'bg-warning';
                            elseif ($prestamo['estado'] == 'cancelado') $estadoClase = 'bg-danger';

                            echo "<td><span class='badge $estadoClase'>" . ucfirst(str_replace('_', ' ', $prestamo['estado'])) . "</span></td>";

                            // Acciones con botones dinámicos
                            echo "<td>
                                <button class='btn btn-primary btn-sm btnAmortizacion' data-prestamo-id='{$prestamo['id']}'><i class='bx bxs-user-detail'></i></button>
                                <button class='btn btn-warning btn-sm' data-id='" . $prestamo['id'] . "' onclick='editarPrestamo(this)'>
                                    <i class='bx bxs-edit'></i>
                                </button>
                                <button class='btn btn-danger btn-sm' onclick='eliminarPrestamo(" . $prestamo['id'] . ")'>
                                    <i class='bx bxs-trash'></i>
                                </button>
                            </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    
        <!-- Modal para mostrar la tabla de amortizacion -->
        <div class="modal fade" id="modalAmortizacion" tabindex="-1" aria-labelledby="modalAmortizacionLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl"> <!-- Cambiado a modal-xl para mayor ancho -->
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #198754;">
                        <h4 class="modal-title" id="modalAmortizacionLabel" style="color: white">Tabla de Amortización</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="tablaAmortizacionContainer" class="table-responsive">
                            <!-- Aquí se inyectará la tabla de amortización dinámicamente -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnDescargarPDF" class="btn btn-primary">Descargar Tabla</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para Pago de Cuota -->
        <div class="modal fade" id="modalPagarCuota" tabindex="-1" role="dialog" aria-labelledby="modalPagarCuotaLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:rgb(25, 85, 135);">
                        <h5 class="modal-title" id="modalPagarCuotaLabel" style="color: white">Pagar Cuota</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="limpiarForm()"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formPagarCuota">
                            <input type="hidden" id="cuotaId" name="cuota_id">

                            <div class="row">
                                <!-- Monto del Préstamo -->
                                <div class="form-group col-md-6">
                                    <label for="montoPrestamo">Monto Total del Préstamo</label>
                                    <input type="text" class="form-control" id="montoPrestamo" readonly>
                                </div>

                                <!-- Monto de la Cuota -->
                                <div class="form-group col-md-6">
                                    <label for="montoCuota">Monto de la Cuota</label>
                                    <input type="text" class="form-control" id="montoCuota" readonly>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <!-- Método de Pago -->
                                <div class="form-group col-md-6">
                                    <label for="metodoPago">Método de Pago</label>
                                    <select class="form-control" id="metodoPago" name="metodo_pago" required>
                                        <option value="" disabled selected>Seleccione un método</option>
                                        <option value="efectivo">Efectivo</option>
                                        <option value="ahorro">Ahorro</option>
                                    </select>
                                </div>

                                <!-- Saldo de Ahorro -->
                                <div class="form-group col-md-6" id="saldoAhorroContainer" style="display: none;">
                                    <strong><label for="saldoAhorro">Saldo Actual de Ahorro</label></strong> 
                                    <input type="text" class="form-control" id="saldoAhorro" style="font-weight: bold;" readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="limpiarForm()">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="procesarPagoCuota()">Pagar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal abonar capital -->
        <!--<div class="modal fade" id="modalAbonarCapital" tabindex="-1" aria-labelledby="modalAbonarCapitalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:rgb(47, 186, 204);">
                        <h5 class="modal-title" id="modalAbonarCapitalLabel" style="color: white">Abono al Capital</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAbonarCapital">
                            <input type="hidden" id="capitalCuotaId">
                            <div class="form-group mb-3">
                                <label for="saldoRestante">Saldo Restante del Préstamo</label>
                                <input type="text" class="form-control" id="saldoRestante" readonly>
                            </div>
                            <div class="form-group mb-3">
                                <label for="montoAbonoCapital">Monto a Abonar</label>
                                <input type="number" class="form-control" id="montoAbonoCapital" placeholder="Ingrese el monto a abonar" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="procesarAbonoCapital()">Abonar</button>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="modal fade" id="modalAbonarCapital" tabindex="-1" aria-labelledby="modalAbonarCapitalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:rgb(47, 186, 204);">
                        <h5 class="modal-title" id="modalAbonarCapitalLabel" style="color: white">Abono al Capital</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAbonarCapital">
                            <input type="hidden" id="capitalCuotaId">
                            <div class="form-group mb-3">
                                <label for="saldoRestante">Saldo Restante del Préstamo</label>
                                <input type="text" class="form-control" id="saldoRestante" readonly>
                            </div>
                            <div class="form-group mb-3">
                                <label for="montoAbonoCapital">Monto a Abonar</label>
                                <input type="number" class="form-control" id="montoAbonoCapital" placeholder="Ingrese el monto a abonar" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="cuotasRestantes">Cuotas Restantes del Préstamo</label>
                                <input type="number" class="form-control" id="cuotasRestantes" readonly>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="procesarAbonoCapital()">Abonar</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal pago interes -->

        <div class="modal fade" id="modalPagoInteres" tabindex="-1" aria-labelledby="modalPagoInteresLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:rgb(231, 79, 79);">
                        <h5 class="modal-title" id="modalPagoInteresLabel" style="color: white">Pago de Interés</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formPagoInteres">
                            <input type="hidden" id="interesCuotaId">
                            <div class="form-group mb-3">
                                <label for="montoPagoInteres">Monto del Interés</label>
                                <input type="text" class="form-control" id="montoPagoInteres" readonly>
                            </div>
                            <div class="form-group mb-3">
                                <label for="montoConfirmarInteres">Confirmar Monto a Pagar</label>
                                <input type="number" class="form-control" id="montoConfirmarInteres" placeholder="Ingrese el monto del interés" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="companiaCliente">Compañía del Cliente</label>
                                <input type="text" class="form-control" id="companiaCliente" readonly>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="realizarPagoInteres()">Pagar</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modales de agregar y editar -->
        <?php include './functions/modales_prestamos.php' ?>

        <!-- ===========    Hasta aqui el crud CRUD de prestamos    =========== -->

        <br><br><br><br>           
    </section>
    <script src="js/prestamos.js"></script>
    <script src="js/script.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="./js/keyboard.js"></script>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        function limpiarForm() {
            const form = document.getElementById('formPagarCuota');
            form.reset(); // Limpia todos los campos del formulario
            $('#saldoAhorroContainer').hide();
        }

        $(document).ready(function() {
            $('#tablaPrestamos').DataTable({
                //lengthMenu: [ [5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "Todos"] ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                }
            });
        });

        $(".cerrarModal").click(function(){
            $("#modalEditarPrestamo").modal('hide')
        });

        // Función para eliminar préstamo
        function eliminarPrestamo(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esta acción",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/functions/delete_prestamo.php?id=' + id;
                }
            });
        }
   
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

        $(document).ready(function() {
            // Cambiar el interés dinámicamente al seleccionar un cliente
            $('#cliente_id').on('change', function() {
                const clienteId = $(this).val();

                // Obtener información del cliente y su compañía
                fetch(`/functions/get_cliente_compania.php?cliente_id=${clienteId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            Swal.fire('Error', data.error, 'error');
                        } else {
                            if (data.compania_nombre === 'Brillacoop') {
                                // Permitir edición manual del interés para Brillacoop
                                $('#interes').prop('readonly', false).val('');
                            } else {
                                // Fijar el interés según la compañía
                                $('#interes').prop('readonly', true).val(data.interes_fijo);
                            }
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'No se pudo obtener la información del cliente.', 'error');
                        console.error(error);
                    });
            });

            // Enviar formulario de préstamo
            $('#formAgregarPrestamo').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                fetch('/functions/create_prestamo.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Éxito', data.message, 'success').then(() => {
                            $('#formAgregarPrestamo')[0].reset();
                            $('#modalAgregarPrestamo').modal('hide');
                            //location.reload();
                        }).then(() => location.reload());
                    } else {
                        Swal.fire('Error', data.message, 'error').then(() => location.reload());
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'No se pudo procesar la solicitud.', 'error');
                    console.error(error);
                });
            });
        });

    </script>
    <script>
         // SweetAlert para confirmar las acciones de agregar, editar y eliminar
         <?php if (isset($_SESSION['alerta'])): ?>
            Swal.fire({
                icon: "<?php echo $_SESSION['alerta']['icon']; ?>",
                title: "<?php echo $_SESSION['alerta']['title']; ?>",
                text: "<?php echo $_SESSION['alerta']['text']; ?>",
                // showConfirmButton: false,
                // timer: 2000,
            });
        <?php unset($_SESSION['alerta']); endif; ?>
    </script>
    <script>
      function editarPrestamo(button) {
            var prestamoId = $(button).data('id');

            // Obtener datos del préstamo
            $.ajax({
                url: './functions/get_prestamo.php',
                type: 'GET',
                data: { id: prestamoId },
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        Swal.fire('Error', response.error, 'error');
                    } else {
                        // Llenar los campos del formulario con los datos del préstamo
                        $('#editPrestamoId').val(response.id);
                        $('#editClienteId').val(response.numero_socio);
                        $('#editMonto').val(response.monto);
                        $('#editInteres').val(response.interes);
                        $('#editPlazo').val(response.plazo);
                        $('#editEstado').val(response.estado);

                        // Verificar la compañía del cliente
                        $.ajax({
                            url: './functions/get_cliente_compania.php',
                            type: 'GET',
                            data: { cliente_id: response.cliente_id },
                            dataType: 'json',
                            success: function(clienteData) {
                                if (clienteData.error) {
                                    Swal.fire('Error', clienteData.error, 'error');
                                } else {
                                    // Determinar si el interés es editable
                                    if (clienteData.compania_nombre === 'Brillacoop') {
                                        $('#editInteres').prop('readonly', false); // Editable para Brillacoop
                                    } else {
                                        $('#editInteres').prop('readonly', true); // Solo lectura para otras compañías
                                    }

                                    // Mostrar el modal de edición
                                    $('#modalEditarPrestamo').modal('show');
                                }
                            },
                            error: function() {
                                Swal.fire('Error', 'No se pudo obtener la información de la compañía.', 'error');
                            }
                        });
                    }
                },
                error: function() {
                    Swal.fire('Error', 'No se pudo obtener los datos del préstamo.', 'error');
                }
            });
        }


$(document).ready(function() {
    // Manejar la actualización del préstamo
    $('#formEditarPrestamo').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('/functions/edit_prestamo.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire('Éxito', data.message, 'success').then(() => {
                    $('#formEditarPrestamo')[0].reset();
                    $('#modalEditarPrestamo').modal('hide');
                    //location.reload();
                }).then(() => location.reload());
            } else {
                Swal.fire('Error', data.message, 'error').then(() => location.reload());
            }
        })
        .catch(error => {
            Swal.fire('Error', 'No se pudo actualizar el préstamo.', 'error');
            console.error('Error:', error);
        });
    });
});

    </script>
    <script>
       function cambiarEstadoActivo(select, prestamoId) {
    const nuevoEstado = select.value;

    Swal.fire({
        title: '¿Está seguro?',
        text: '¿Desea cambiar el estado del préstamo?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, cambiar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/functions/update_estado_prestamo.php',
                type: 'POST',
                data: { id: prestamoId, estado: nuevoEstado },
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        Swal.fire('Éxito', data.message, 'success').then(() => {
                            // Cambiar dinámicamente la clase de estilo
                            const estadoClase = getEstadoClase(nuevoEstado);
                            $(select).parent().html(`<span class="badge ${estadoClase}">${formatEstado(nuevoEstado)}</span>`);
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                        // Restaurar el valor anterior si hay error
                        select.value = select.getAttribute('data-prev-value');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'No se pudo actualizar el estado del préstamo.', 'error');
                    select.value = select.getAttribute('data-prev-value');
                }
            });
        } else {
            // Restaurar el valor anterior si se cancela
            select.value = select.getAttribute('data-prev-value');
        }
    });
}

function getEstadoClase(estado) {
    switch (estado) {
        case 'activo_bien':
            return 'bg-success';
        case 'activo_problemas':
            return 'bg-warning';
        case 'activo_terminado':
            return 'bg-danger';
        case 'pendiente':
            return 'bg-warning';
        case 'cancelado':
            return 'bg-danger';
        default:
            return '';
    }
}

function formatEstado(estado) {
    switch (estado) {
        case 'activo_bien':
            return 'Activo';
        case 'activo_problemas':
            return 'Activo';
        case 'activo_terminado':
            return 'Activo';
        default:
            return estado.charAt(0).toUpperCase() + estado.slice(1);
    }
}
    </script>

    <script>

        $(document).on('click', '.btnAmortizacion', function () {
            const prestamoId = $(this).data('prestamo-id');

            // Llamar al backend para obtener la tabla de amortización
            $.ajax({
                url: '/functions/prestamos/obtener_amortizacion.php',
                type: 'GET',
                data: { prestamo_id: prestamoId },
                success: function (response) {
                    const data = JSON.parse(response);

                    if (data.success) {
                        const amortizacion = data.amortizacion;

                        // Si la tabla de amortización está vacía, mostrar alerta
                        if (amortizacion.length === 0) {
                            Swal.fire('Error', 'El préstamo seleccionado no tiene tabla de amortización.', 'error');
                            return;
                        }

                        // Generar la tabla
                        let contenido = `
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Cuota</th>
                                        <th>Fecha Pago</th>
                                        <th>Monto Cuota</th>
                                        <th>Interés</th>
                                        <th>Capital</th>
                                        <th>Saldo Restante</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                        `;

                        amortizacion.forEach(cuota => {
                            const estadoClase = cuota.estado === 'pagada' ? 'badge bg-success' : 'badge bg-warning';
                            const acciones = cuota.estado === 'pendiente' ? `
                                <button class="btn btn-primary btn-sm" onclick="pagarCuota(${cuota.id}, 'cuota')">Pagar</button>
                                <button class="btn btn-info btn-sm" onclick="procesarAbonoCapital(${cuota.id})">Abonar Capital</button>
                                <button class="btn btn-danger btn-sm" onclick="procesarPago(${cuota.id}, 'interes')">Pago Interés</button>

                            ` : '';

                            contenido += `
                                <tr>
                                    <td>${cuota.cuota_numero}</td>
                                    <td>${cuota.fecha_pago}</td>
                                    <td>RD$${parseFloat(cuota.monto_cuota).toFixed(2)}</td>
                                    <td>RD$${parseFloat(cuota.interes).toFixed(2)}</td>
                                    <td>RD$${parseFloat(cuota.capital).toFixed(2)}</td>
                                    <td>RD$${parseFloat(cuota.saldo_restante).toFixed(2)}</td>
                                    <td><span class="${estadoClase}">${cuota.estado}</span></td>
                                    <td>${acciones}</td>
                                </tr>
                            `;
                        });

                        contenido += `
                                </tbody>
                            </table>
                        `;

                        // Asignar dinámicamente el prestamo_id al botón de descarga
                        $('#btnDescargarPDF').attr('data-prestamo-id', prestamoId);

                        // Mostrar la tabla en el modal
                        $('#tablaAmortizacionContainer').html(contenido);
                        $('#modalAmortizacion').modal('show');
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'No se pudo cargar la tabla de amortización.', 'error');
                }
            });
        });

        $('#modalAmortizacion').on('show.bs.modal', function (event) {
            const prestamoId = $(event.relatedTarget).data('prestamo-id');
            $('#btnDescargarPDF').data('prestamo-id', prestamoId);
        });


        $(document).on('click', '#btnDescargarPDF', function () {
            const prestamoId = $(this).data('prestamo-id');

            if (!prestamoId) {
                Swal.fire('Error', 'No se pudo identificar el préstamo.', 'error');
                return;
            }

            // Redirigir al archivo PHP con el ID del préstamo como parámetro
            window.open(`/functions/prestamos/generar_pdf_amortizacion.php?prestamo_id=${prestamoId}`, '_blank');
        });

        // Abrir el modal con los datos de la cuota seleccionada
        function pagarCuota(cuotaId) {
            $.ajax({
                url: '/functions/prestamos/obtener_datos_cuota.php',
                type: 'GET',
                data: { cuota_id: cuotaId },
                success: function (response) {
                    const data = JSON.parse(response);

                    if (data.success) {
                        // Rellenar los datos en el modal
                        $('#cuotaId').val(data.cuota.id);
                        $('#montoPrestamo').val(`RD$${parseFloat(data.prestamo.monto).toFixed(2)}`);
                        $('#montoCuota').val(`RD$${parseFloat(data.cuota.monto_cuota).toFixed(2)}`);

                        if (data.ahorro) {
                            $('#saldoAhorro').val(`RD$${parseFloat(data.ahorro.monto).toFixed(2)}`);
                        } else {
                            $('#saldoAhorroContainer').hide();
                        }

                        $('#modalPagarCuota').modal('show');
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'No se pudieron cargar los datos de la cuota.', 'error');
                }
            });
        }

        // Procesar el pago de la cuota
        function procesarPagoCuota() {
            const cuotaId = $('#cuotaId').val();
            const metodoPago = $('#metodoPago').val();
            const montoCuota = parseFloat($('#montoCuota').val().replace('RD$', '').replace(',', ''));
            const saldoAhorro = parseFloat($('#saldoAhorro').val().replace('RD$', '').replace(',', '') || 0);

            if (!metodoPago) {
                Swal.fire('Error', 'Seleccione un método de pago.', 'error');
                return;
            }

            if (metodoPago === 'ahorro' && saldoAhorro < montoCuota) {
                Swal.fire('Error', 'El saldo de ahorro es insuficiente para realizar el pago.', 'error');
                return;
            }

            $.ajax({
                url: '/functions/prestamos/procesar_pago_cuota.php',
                type: 'POST',
                data: { cuota_id: cuotaId, metodo_pago: metodoPago },
                success: function (response) {
                    const data = JSON.parse(response);

                    if (data.success) {
                        Swal.fire('Éxito', 'Pago procesado correctamente.', 'success').then(() => {
                            $('#modalPagarCuota').modal('hide');
                            location.reload(); // Recargar la página o actualizar la tabla de amortización
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'No se pudo procesar el pago.', 'error');
                }
            });
        }

        // Mostrar/ocultar el saldo de ahorro dependiendo del método seleccionado
        $('#metodoPago').on('change', function () {
            const metodo = $(this).val();
            if (metodo === 'ahorro') {
                $('#saldoAhorroContainer').show();
            } else {
                $('#saldoAhorroContainer').hide();
            }
        });


        //Aqui empieza la logica de pago de interes y de abono capital. 
        function procesarAbonoCapital(cuotaId) {
            $('#capitalCuotaId').val(cuotaId); // Asignar cuotaId al modal
            $('#modalAbonarCapital').modal('show');
        }

        function procesarPago(cuotaId, tipoPago) {
            if (tipoPago === 'interes') {
                $.ajax({
                    url: '/functions/prestamos/obtener_datos_cliente.php',
                    type: 'GET',
                    data: { cuota_id: cuotaId },
                    success: function (response) {
                        const data = JSON.parse(response);

                        if (data.success) {
                            $('#interesCuotaId').val(cuotaId);
                            $('#montoPagoInteres').val(data.interes);
                            $('#companiaCliente').val(data.compania);
                            $('#modalPagoInteres').modal('show');

                            // Log para depuración
                            console.log('Datos cargados en el modal:', data);
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'No se pudo cargar la información del cliente.', 'error');
                    },
                });
            }
        }

       /* function procesarPago(cuotaId, tipo) {
            if (tipo === 'interes') {
                $('#interesCuotaId').val(cuotaId); // Asignar cuotaId al modal
                $.ajax({
                    url: '/functions/prestamos/obtener_cuota_interes.php', // Endpoint para obtener información de la cuota
                    type: 'GET',
                    data: { cuota_id: cuotaId },
                    success: function (response) {
                        const data = JSON.parse(response);
                        if (data.success) {
                            $('#montoPagoInteres').val(data.interes); // Mostrar el monto del interés
                            $('#modalPagoInteres').modal('show');
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'No se pudo cargar el monto del interés.', 'error');
                    }
                });
            }
        } */

        function realizarAbonoCapital() {
            const cuotaId = $('#capitalCuotaId').val();
            const montoAbono = $('#montoAbonoCapital').val();

            if (!montoAbono || montoAbono <= 0) {
                Swal.fire('Error', 'Debe ingresar un monto válido.', 'error');
                return;
            }

            $.ajax({
                url: '/functions/prestamos/abonar_capital.php', // Endpoint para procesar el abono
                type: 'POST',
                data: { cuota_id: cuotaId, monto_abono: montoAbono },
                success: function (response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        Swal.fire('Éxito', 'Abono al capital realizado correctamente.', 'success')
                            .then(() => location.reload()); // Recargar tabla
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'No se pudo realizar el abono al capital.', 'error');
                }
            });
        }

      /*  function realizarPagoInteres() {
            const cuotaId = $('#interesCuotaId').val();
            const montoInteres = $('#montoPagoInteres').val();

            $.ajax({
                url: '/functions/prestamos/pagar_interes.php', // Endpoint para procesar el pago de interés
                type: 'POST',
                data: { cuota_id: cuotaId, monto_interes: montoInteres },
                success: function (response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        Swal.fire('Éxito', 'Pago de interés realizado correctamente.', 'success')
                            .then(() => location.reload()); // Recargar tabla
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'No se pudo realizar el pago de interés.', 'error');
                }
            });
        } */

        function realizarPagoInteres() {
    const cuotaId = $('#interesCuotaId').val();
    const montoConfirmarInteres = $('#montoConfirmarInteres').val();

    // Log para depuración
    console.log({ cuotaId, montoConfirmarInteres });

    if (!cuotaId || !montoConfirmarInteres) {
        Swal.fire('Error', 'Por favor complete todos los campos.', 'error');
        return;
    }

    // Enviar datos al backend
    $.ajax({
        url: '/functions/prestamos/pagar_interes.php',
        type: 'POST',
        data: {
            cuota_id: cuotaId,
            monto_interes: montoConfirmarInteres,
        },
        success: function (response) {
            console.log('Respuesta del servidor:', response); // Log para depuración
            const data = JSON.parse(response);

            if (data.success) {
                Swal.fire('Éxito', 'Pago realizado correctamente.', 'success').then(() => {
                    $('#modalPagoInteres').modal('hide');
                    location.reload();
                });
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        },
        error: function () {
            Swal.fire('Error', 'No se pudo procesar el pago.', 'error');
        },
    });
}


    </script>
</body>
</html>