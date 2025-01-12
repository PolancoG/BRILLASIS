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
            <th>ID</th>
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
        $stmt = $conn->query("SELECT prestamo.id, cliente.nombre AS cliente_nombre, prestamo.monto, prestamo.interes, prestamo.plazo, prestamo.estado
                            FROM prestamo
                            JOIN cliente ON prestamo.cliente_id = cliente.id");
        while ($prestamo = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $prestamo['id'] . "</td>";
            echo "<td>" . $prestamo['cliente_nombre'] . "</td>";
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
                <button class='btn btn-info btn-sm' data-id='" . $prestamo['id'] . "' onclick='cargarTablaAmortizacion(" . $prestamo['id'] . ")'>
                    <i class='bx bxs-user-detail'></i> Amortización
                </button>
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
        
        <div id="modal-amortizacion" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tabla de Amortización</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Aquí se renderizará la tabla -->
            </div>
        </div>
    </div>
</div>

        <!-- Modal para la tabla de amortización -->
         <!--
<div class="modal fade" id="modalTablaAmortizacion" tabindex="-1" role="dialog" aria-labelledby="modalAmortizacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAmortizacionLabel">Tabla de Amortización</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="tablaAmortizacion" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fecha de Pago</th>
                            <th>Monto Cuota</th>
                            <th>Interés</th>
                            <th>Capital</th>
                            <th>Saldo Restante</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                         Aquí se cargan dinámicamente las cuotas con AJAX 
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
-->

        <!-- Modales de agregar y editar -->
        <?php include './functions/modales_prestamos.php' ?>

        <!-- ===========    Hasta aqui el crud CRUD de prestamos   =========== -->

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
                        $('#editClienteId').val(response.cliente_id);
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
        function verAmortizacion(button) {
            const prestamoId = $(button).data('id');

            fetch(`/functions/get_amortizacion.php?prestamo_id=${prestamoId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        mostrarModalAmortizacion(data.amortizacion);
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'No se pudo obtener la tabla de amortización.', 'error');
                    console.error(error);
                });
        }

       /* function mostrarModalAmortizacion(amortizacion) {
            let tableRows = amortizacion.map(row => `
                <tr>
                    <td>${row.cuota}</td>
                    <td>${row.fecha_pago}</td>
                    <td>RD$${row.cuota_mensual}</td>
                    <td>RD$${row.interes}</td>
                    <td>RD$${row.capital}</td>
                    <td>RD$${row.saldo_restante}</td>
                </tr>
            `).join('');

            const modalHtml = `
                <div class="modal" id="modalAmortizacion" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #198754;">
                                <h4 class="modal-title" style="color: white">Tabla de Amortización</h4>
                                <button type="button" class="btn-close cerrarModal" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Cuota</th>
                                            <th>Fecha de Pago</th>
                                            <th>Cuota Mensual</th>
                                            <th>Interés</th>
                                            <th>Capital</th>
                                            <th>Saldo Restante</th>
                                        </tr>
                                    </thead>
                                    <tbody>${tableRows}</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('body').append(modalHtml);
            $('#modalAmortizacion').modal('show');
        } */

        function mostrarModalAmortizacion(amortizacion, prestamo_id) {
            let tableRows = amortizacion.map(row => `
                <tr>
                    <td>${row.cuota_numero}</td>
                    <td>${row.fecha_pago}</td>
                    <td>RD$${row.monto_cuota}</td>
                    <td>RD$${row.interes}</td>
                    <td>RD$${row.capital}</td>
                    <td>RD$${row.saldo_restante}</td>
                    <td>
                        <button class="btn btn-primary btn-sm"> 
                            Abonar capital
                        </button>
                        <button class="btn btn-warning btn-sm"> 
                            Pagar interes
                        </button>
                        <button class="btn btn-success btn-sm" 
                            onclick="abrirModalPago(${prestamo_id}, ${row.cuota}, ${row.saldo_restante}, ${row.monto_cuota})">
                            Pagar cuota
                        </button>
                        
                    <!--    <button type="button" 
                                class="btn btn-primary btn-pagar" 
                                data-prestamo_id="1" 
                                data-cuota_monto="2000" 
                                data-toggle="modal" 
                                data-target="#modalPagarCuota">
                            Pagar
                        </button> -->

                    </td>
                </tr>
            `).join('');

            const modalHtml = `
                <div class="modal" id="modalAmortizacion" tabindex="-1" data-bs-backdrop="static">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #198754;">
                                <h4 class="modal-title" style="color: white">Tabla de Amortización</h4>
                                <button type="button" class="btn-close cerrarModal" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Cuota</th>
                                            <th>Fecha de Pago</th>
                                            <th>Cuota Mensual</th>
                                            <th>Interés</th>
                                            <th>Capital</th>
                                            <th>Saldo Restante</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>${tableRows}</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('body').append(modalHtml);
            $('#modalAmortizacion').modal('show');
        }

       /* function abrirModalPago(prestamoId, cuotaNumero, saldoRestante) {
            const modalHtml = `
                <div class="modal" id="modalPago" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #ffc107;">
                                <h4 class="modal-title" style="color: white">Registrar Pago</h4>
                                <button type="button" class="btn-close cerrarModal" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formPago">
                                    <input type="hidden" name="prestamo_id" value="${prestamoId}">
                                    <input type="hidden" name="cuota_numero" value="${cuotaNumero}">
                                    <div class="mb-3">
                                        <label for="saldoRestante" class="form-label">Saldo Restante</label>
                                        <input type="text" id="saldoRestante" class="form-control" value="RD$${saldoRestante}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="metodoPago" class="form-label">Método de Pago</label>
                                        <select id="metodoPago" name="metodo_pago" class="form-select">
                                            <option value="efectivo">Efectivo</option>
                                            <option value="ahorro">Ahorro</option>
                                            <option value="transferencia">Transferencia</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="montoPago" class="form-label">Monto a Pagar</label>
                                        <input type="number" id="montoPago" name="monto_pago" class="form-control" min="1" required>
                                    </div>
                                    <button type="button" class="btn btn-primary" onclick="registrarPago()">Registrar Pago</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('body').append(modalHtml);
            $('#modalPago').modal('show');
        }*/

        function abrirModalPago(prestamoId, cuotaNumero, saldoRestante, montoCuota) {
           // console.log('montoCuota:', montoCuota); // Verifica el valor de montoCuota
            //console.log('Prestamo ID:', prestamoId, 'Cuota Número:', cuotaNumero);

              // Mostrar valores en la consola para verificar
            console.log('Abrir modal - Prestamo ID:', prestamoId, 'Cuota Número:', cuotaNumero, 'Monto Cuota:', montoCuota);

            const modalHtml = `
                <div class="modal" id="modalPago" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:rgb(7, 85, 255);">
                                <h4 class="modal-title" style="color: white">Registrar Pago</h4>
                                <button type="button" class="btn-close cerrarModal" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formPago">
                                    <input type="hidden" name="prestamo_id" value="${prestamoId}">
                                    <input type="hidden" name="cuota_numero" value="${cuotaNumero}"> 
                                   <!--  <input type="hidden" name="prestamo_id" id="prestamoId" value="${prestamoId}">
                                     <input type="hidden" name="cuota_numero" id="cuotaNumero" value="${cuotaNumero}"> -->
                                    <div class="mb-3">
                                        <label for="saldoRestante" class="form-label">Saldo Restante</label>
                                        <input type="text" id="saldoRestante" class="form-control" value="RD$${saldoRestante}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="metodoPago" class="form-label">Método de Pago</label>
                                        <select id="metodoPago" name="metodo_pago" class="form-select">
                                            <option value="efectivo">Efectivo</option>
                                            <option value="ahorro">Ahorro</option>
                                            <option value="transferencia">Transferencia</option>
                                        </select>
                                    </div> 
                                    <div class="mb-3">
                                        <label for="montoPago" class="form-label">Monto a Pagar</label>
                                        <input type="number" id="montoPago" name="monto_pago" class="form-control" min="1" value="${montoCuota}" readonly required>
                                    </div>
                                    <button type="button" class="btn btn-primary" onclick="registrarPago()">Registrar Pago</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#modalPago').remove(); // Elimina cualquier modal existente antes de agregar uno nuevo
            $('body').append(modalHtml);
            $('#modalPago').modal('show');
        }


       /* function registrarPago() {
            const formData = $('#formPago').serialize();

            $.ajax({
                url: '/functions/registrar_pago.php',
                method: 'POST',
                data: formData,
                success: function (response) {
                    const res = JSON.parse(response);
                    Swal.fire({
                        icon: res.success ? 'success' : 'error',
                        title: res.success ? 'Éxito' : 'Error',
                        text: res.message,
                    });

                    if (res.success) {
                        $('#modalPago').modal('hide');
                        $('#modalAmortizacion').modal('hide');
                        // Recargar la tabla de amortización (puedes ajustar esta lógica según tu flujo)
                        cargarAmortizacion(formData.prestamo_id);
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo procesar el pago.',
                    });
                }
            });
        } */

        function registrarPago() {
            const formData = $('#formPago').serialize();
            console.log('FormData enviado:', formData); // Agrega esta línea para depuración.

            $.ajax({
                url: '/functions/registrar_pago.php',
                method: 'POST',
                data: formData,
                success: function (response) {
                    const res = JSON.parse(response);
                    console.log('Respuesta del servidor:', res); // Agrega esta línea para ver la respuesta.
                    Swal.fire({
                        icon: res.success ? 'success' : 'error',
                        title: res.success ? 'Éxito' : 'Error',
                        text: res.message,
                    });

                    if (res.success) {
                        $('#modalPago').modal('hide');
                        $('#modalAmortizacion').modal('hide');
                        cargarAmortizacion(formData.prestamo_id);
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo procesar el pago.',
                    });
                }
            });
        } 

        function cargarTablaAmortizacion(prestamoId) {
    $.ajax({
        url: '/functions/cargar_amortizacion.php', // Backend para obtener la tabla de amortización
        type: 'POST',
        data: { prestamo_id: prestamoId },
        success: function (response) {
            const data = JSON.parse(response);
            if (data.success) {
                const tablaBody = $("#tablaAmortizacion tbody");
                tablaBody.empty();
                data.cuotas.forEach((cuota) => {
                    const estadoCuota = cuota.estado_cuota === 'pagada' ? 'Pagada' : 'Pendiente';
                    const btnAccion = cuota.estado_cuota === 'pagada'
                        ? '<button class="btn btn-secondary btn-sm" disabled>Pagada</button>'
                        : `<button class="btn btn-success btn-sm" onclick="pagarCuota(${prestamoId}, ${cuota.cuota_numero}, ${cuota.monto_cuota})">Pagar</button>`;
                    
                    const fila = `
                        <tr>
                            <td>${cuota.cuota_numero}</td>
                            <td>${cuota.fecha_pago}</td>
                            <td>RD$${cuota.monto_cuota.toFixed(2)}</td>
                            <td>RD$${cuota.interes.toFixed(2)}</td>
                            <td>RD$${cuota.capital.toFixed(2)}</td>
                            <td>RD$${cuota.saldo_restante.toFixed(2)}</td>
                            <td>${btnAccion}</td>
                        </tr>
                    `;
                    tablaBody.append(fila);
                });
                $("#modalTablaAmortizacion").modal("show");
            } else {
                Swal.fire("Error", data.message, "error");
            }
        },
        error: function () {
            Swal.fire("Error", "No se pudo cargar la tabla de amortización.", "error");
        }
    });
}

/*function pagarCuota(prestamoId, cuotaNumero, montoCuota) {
    Swal.fire({
        title: 'Confirmar Pago',
        text: `¿Desea pagar la cuota #${cuotaNumero} por RD$${montoCuota.toFixed(2)}?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, pagar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/functions/pagar_cuota.php',
                type: 'POST',
                data: { prestamo_id: prestamoId, cuota_numero: cuotaNumero, monto_pago: montoCuota },
                success: function (response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        Swal.fire("Éxito", data.message, "success").then(() => {
                            cargarTablaAmortizacion(prestamoId);
                        });
                    } else {
                        Swal.fire("Error", data.message, "error");
                    }
                },
                error: function () {
                    Swal.fire("Error", "No se pudo procesar el pago.", "error");
                }
            });
        }
    });
} */

$('#datatable').on('click', '.btn-amortizacion', function () {
    const prestamoId = $(this).data('prestamo-id');

    $.ajax({
        url: '/functions/cargar_amortizacion.php',
        type: 'POST',
        data: { prestamo_id: prestamoId },
        success: function (response) {
            if (response.success) {
                // Renderizar la tabla de cuotas con los datos recibidos
                renderTablaAmortizacion(response.cuotas);
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        },
        error: function () {
            Swal.fire('Error', 'No se pudo cargar la amortización.', 'error');
        }
    });
});

function renderTablaAmortizacion(cuotas) {
    let html = `
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha de Pago</th>
                    <th>Cuota</th>
                    <th>Interés</th>
                    <th>Capital</th>
                    <th>Saldo Restante</th>
                </tr>
            </thead>
            <tbody>
    `;

    cuotas.forEach(cuota => {
        html += `
            <tr>
                <td>${cuota.cuota_numero}</td>
                <td>${cuota.fecha_pago}</td>
                <td>${cuota.monto_cuota}</td>
                <td>${cuota.interes}</td>
                <td>${cuota.capital}</td>
                <td>${cuota.saldo_restante}</td>
            </tr>
        `;
    });

    html += `
            </tbody>
        </table>
    `;

    $('#modal-amortizacion .modal-body').html(html);
    $('#modal-amortizacion').modal('show');
}

/*// Función para cargar la tabla de amortización
function cargarTablaAmortizacion(prestamoId) {
    $.ajax({
        url: '/functions/get_amortizacion.php', // Archivo backend para obtener datos de amortización
        type: 'POST',
        data: { prestamo_id: prestamoId },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                mostrarModalAmortizacion(response.data);
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        },
        error: function () {
            Swal.fire('Error', 'No se pudo cargar la tabla de amortización.', 'error');
        }
    });
} 


// Función para mostrar la tabla de amortización en un modal
function mostrarModalAmortizacion(amortizacion) {
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
        const estadoClase = cuota.estado === 'pagada' ? 'bg-success' : 'bg-warning';
        const botonPagar = cuota.estado === 'pendiente' 
            ? `<button class="btn btn-primary btn-sm" onclick="pagarCuota(${cuota.id})">Pagar</button>` 
            : '';

        contenido += `
            <tr>
                <td>${cuota.cuota_numero}</td>
                <td>${cuota.fecha_pago}</td>
                <td>RD$${cuota.monto_cuota}</td>
                <td>RD$${cuota.interes}</td>
                <td>RD$${cuota.capital}</td>
                <td>RD$${cuota.saldo_restante}</td>
                <td><span class="badge ${estadoClase}">${cuota.estado || 'Desconocido'}</span></td>
                <td>${botonPagar}</td>
            </tr>
        `;
    });


    contenido += `
            </tbody>
        </table>
    `;

    Swal.fire({
        title: 'Tabla de Amortización',
        html: contenido,
        width: '80%',
        showCloseButton: true,
        confirmButtonText: 'Cerrar'
    });
}

function pagarCuota(cuotaId) {
    // Modal con el formulario de pago
    Swal.fire({
        title: 'Pagar Cuota',
        html: `
            <form id="formPagoCuota">
                <div class="form-group">
                    <label for="monto_pago">Monto a Pagar</label>
                    <input type="number" class="form-control" id="monto_pago" name="monto_pago" placeholder="Ingrese el monto" required>
                </div>
                <div class="form-group">
                    <label for="metodo_pago">Método de Pago</label>
                    <select class="form-control" id="metodo_pago" name="metodo_pago" required>
                        <option value="efectivo">Efectivo</option>
                        <option value="tarjeta">Tarjeta</option>
                        <option value="transferencia">Transferencia</option>
                    </select>
                </div>
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Pagar',
        preConfirm: () => {
            const montoPago = document.getElementById('monto_pago').value;
            const metodoPago = document.getElementById('metodo_pago').value;

            if (!montoPago || !metodoPago) {
                Swal.showValidationMessage('Todos los campos son obligatorios');
            }

            return { monto_pago: montoPago, metodo_pago: metodoPago };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            realizarPagoCuota(cuotaId, result.value);
        }
    });
}
*/

// Función para cargar la tabla de amortización
function cargarTablaAmortizacion(prestamoId) {
    $.ajax({
        url: '/functions/get_amortizacion.php', // Archivo backend para obtener datos de amortización
        type: 'POST',
        data: { prestamo_id: prestamoId },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                // Llamar a la función mostrarModalAmortizacion con los datos obtenidos
                mostrarModalAmortizacion(response.data);
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        },
        error: function () {
            Swal.fire('Error', 'No se pudo cargar la tabla de amortización.', 'error');
        }
    });
}

// Función para mostrar la tabla de amortización en un modal
function mostrarModalAmortizacion(amortizacion) {
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
        const estadoClase = cuota.estado === 'pagada' ? 'bg-success' : 'bg-warning';
        const botonPagar = cuota.estado === 'pendiente' 
            ? `<button class="btn btn-primary btn-sm" onclick="pagarCuota(${cuota.id})">Pagar</button>` 
            : '';

        contenido += `
            <tr>
                <td>${cuota.cuota_numero}</td>
                <td>${cuota.fecha_pago}</td>
                <td>RD$${parseFloat(cuota.monto_cuota).toFixed(2)}</td>
                <td>RD$${parseFloat(cuota.interes).toFixed(2)}</td>
                <td>RD$${parseFloat(cuota.capital).toFixed(2)}</td>
                <td>RD$${parseFloat(cuota.saldo_restante).toFixed(2)}</td>
                <td><span class="badge ${estadoClase}">${cuota.estado || 'Desconocido'}</span></td>
                <td>${botonPagar}</td>
            </tr>
        `;
    });

    contenido += `
            </tbody>
        </table>
    `;

    Swal.fire({
        title: 'Tabla de Amortización',
        html: contenido,
        width: '80%',
        showCloseButton: true,
        confirmButtonText: 'Cerrar'
    });
}

// Función para manejar el pago de una cuota
function pagarCuota(cuotaId) {
    Swal.fire({
        title: 'Confirmar Pago',
        text: `¿Deseas pagar la cuota seleccionada?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Pagar',
        cancelButtonText: 'Cancelar'
    }).then(result => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/functions/pagar_cuota.php',
                type: 'POST',
                data: { cuota_id: cuotaId },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Swal.fire('Éxito', 'La cuota ha sido pagada.', 'success');
                        // Recargar la tabla de amortización
                        cargarTablaAmortizacion(response.prestamo_id);
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'No se pudo procesar el pago.', 'error');
                }
            });
        }
    });
}


function realizarPagoCuota(cuotaId, datosPago) {
    $.ajax({
        url: '/functions/pagar_cuota.php', // Endpoint backend
        type: 'POST',
        data: { 
            cuota_id: cuotaId, 
            monto_pago: datosPago.monto_pago, 
            metodo_pago: datosPago.metodo_pago 
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                Swal.fire('Éxito', 'El pago se ha registrado correctamente.', 'success').then(() => {
                    // Actualizar la tabla de amortización
                    cargarTablaAmortizacion(response.prestamo_id);
                });
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        },
        error: function () {
            Swal.fire('Error', 'No se pudo procesar el pago.', 'error');
        }
    });
}


    </script>
    
</body>
</html>