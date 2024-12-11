<?php
   session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    } 
    
    require 'db.php';

    $role = $_SESSION['role'];
    // Obtener la lista de clientes 
    $stmt = $conn->query("
        SELECT c.id, c.numero_socio, c.cedula, c.nombre, s.nombre AS sucursal_nombre
        FROM cliente c
        LEFT JOIN sucursal s ON c.sucursal_id = s.id
    ");
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Obtener la lista de sucursales
    $stmt_s = $conn->query("SELECT id, nombre FROM sucursal");
    $sucursales = $stmt_s->fetchAll(PDO::FETCH_ASSOC);

    try {
        // Consultar la lista de familiares junto con el nombre del cliente asociado
        $stmt = $conn->query("
            SELECT f.id, f.cedula, f.nombre, f.relacion, f.telefono, f.correo_electronico, f.nombre_hijos, cl.nombre AS cliente_nombre, cl.id AS cliente_id
            FROM familia_cliente f
            JOIN cliente cl ON f.cliente_id = cl.id
        ");
        $familiares = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // En caso de error, inicializar $familiares como un arreglo vacío para evitar el error
        $familiares = [];
        error_log('Error al obtener familiares: ' . $e->getMessage());
    } 
    
?>
<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="imgs/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="css/logo.css">
    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <!----===== Data Table CSS ===== -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!--SWEET ALERT CDN CSS-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> 

   <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>  -->
   <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>  -->
   
   <style>
        .dataTables_filter {
            margin-bottom: 30px; /* Espacio entre el buscador y la tabla */
        }
    </style>
    
</head> 
    <title>BRILLASIS Socios</title> 
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
                    <?php if($role == 'admin' || $role == 'cajerop' ) { ?>
                    <li class="nav-link">
                        <a href="prestamos">
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
            <img class="imglogo" src="imgs/logo.png" alt="image logo"> Modulo para Familiares
        </div>
        <br>
       
            <!-- Familiares -->
            <br>
            <div class="card mx-auto" style="max-width: 1150px; min-height: auto;">
                <div class="card-header" style="background-color: #198754;"><h2 style="color: white;">Administración de los Familiares de los Socios</h2></div>
                <div class="card-body">
                <br>
                <!--<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarCliente">Agregar Socio</button>-->
                <button class="btn btn-success mb-3" id="btnAgregarFamiliar" data-toggle="modal" data-target="#modalFamiliar">Agregar Familiar</button>
                <br>
                
                <div class="d-flex justify-content-end mb-3">
                </div>
                <!-- Datatable -->
                <table id="tablaFamiliares" class="table table-striped table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Cédula</th>
                        <th>Nombre</th>
                        <th>Relación</th>
                        <th>Teléfono</th>
                        <th>Socio</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($familiares as $familiar): ?>
                        <tr>
                            <td><?php echo $familiar['id']; ?></td>
                            <td><?php echo $familiar['cedula']; ?></td>
                            <td><?php echo $familiar['nombre']; ?></td>
                            <td><?php echo $familiar['relacion']; ?></td>
                            <td><?php echo $familiar['telefono']; ?></td>
                            <td><?php echo $familiar['cliente_nombre']; ?></td>
                            <?php if($role == 'admin') { ?>
                                <td>
                                    <button class="btn btn-primary btn-sm btnEditar" 
                                            data-id="<?php echo $familiar['id']; ?>"
                                            data-cedula="<?php echo $familiar['cedula']; ?>"
                                            data-nombre="<?php echo $familiar['nombre']; ?>"
                                            data-relacion="<?php echo $familiar['relacion']; ?>"
                                            data-telefono="<?php echo $familiar['telefono']; ?>"
                                            data-correo="<?php echo $familiar['correo_electronico']; ?>"
                                            data-hijos="<?php echo $familiar['nombre_hijos']; ?>"
                                            data-cliente="<?php echo $familiar['cliente_id']; ?>">
                                        <i class='bx bxs-edit'></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm btnEliminar" 
                                            data-id="<?php echo $familiar['id']; ?>"><i class='bx bxs-trash' ></i></button>
                                </td>
                            <?php } else { ?>
                                <td>
                                    <button class="btn btn-primary btn-sm btnEditar" 
                                            data-id="<?php echo $familiar['id']; ?>"
                                            data-cedula="<?php echo $familiar['cedula']; ?>"
                                            data-nombre="<?php echo $familiar['nombre']; ?>"
                                            data-relacion="<?php echo $familiar['relacion']; ?>"
                                            data-telefono="<?php echo $familiar['telefono']; ?>"
                                            data-correo="<?php echo $familiar['correo_electronico']; ?>"
                                            data-hijos="<?php echo $familiar['nombre_hijos']; ?>"
                                            data-cliente="<?php echo $familiar['cliente_id']; ?>" disabled>
                                        <i class='bx bxs-edit'></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm btnEliminar" 
                                            data-id="<?php echo $familiar['id']; ?>" disabled><i class='bx bxs-trash' ></i></button>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php require './functions/clientes/modal_familiar.php'; ?>
            <!-- End Familiares -->
        </div>
        <br><br><br><br>
    </section>
    
    <!-- ====== Muestra el mensaje del sweetalert ======= -->

    <script src="js/script.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="js/clientesf.js"></script>
   <script src="./js/keyboard.js"></script>
    <!-- ====== ionicons ======= -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script> 
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>--> 
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Script de familiar -->
    <script>

        $(document).ready(function() {
            // Aplicar la máscara de Cédula
            $('#cedula').mask('000-0000000-0');

            // Aplicar la máscara de Teléfono
            $('#telefono').mask('(000)-000-0000');
        }); 

        // y por supuesto este carga los datos
        $(document).ready(function() {
            $('#tablaFamiliares').DataTable({
                //lengthMenu: [ [5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "Todos"] ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                }
            });

            //este estaba funcionando tambien
            // Botón Eliminar
            $('.btnEliminar').click(function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: '¿Está seguro?',
                    text: "Esta acción eliminará al familiar.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post('/functions/clientes/delete_familiar.php', { id: id }, function(response) {
                            if (response.success) {
                                Swal.fire('Eliminado', response.message, 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error', response.message, 'error');
                            }
                        }, 'json');
                    }
                });
            });
        });


        $(document).ready(function() {
            // Evento para abrir el modal de "Agregar Familiar"
            $('#btnAgregarFamiliar').on('click', function() {
                $('#formFamiliar')[0].reset(); // Limpiar el formulario
                $('#familiar_id').val(''); // Limpiar el campo oculto del ID
                $('#modalFamiliarLabel').text('Agregar Familiar'); // Cambiar el título del modal
                $('#modalFamiliar').modal('show'); // Mostrar el modal
            }); 

            // Evento para abrir el modal de "Editar Familiar" usando delegación de eventos
            $(document).on('click', '.btnEditar', function() {
                const id = $(this).data('id');
                console.log("ID del Familiar:", id); // Depuración: Verificar el ID del familiar

                // Obtener los datos del familiar desde el backend
                fetch(`/functions/clientes/get_familiar.php?id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            Swal.fire('Error', data.error, 'error');
                        } else {
                            const f = data.familiar;

                            // Llenar el formulario con los datos del familiar
                            $('#familiar_id').val(f.id);
                            $('#cliente_id').val(f.cliente_id); // Seleccionar el cliente relacionado
                            $('#cedula').val(f.cedula);
                            $('#nombre').val(f.nombre);
                            $('#relacion').val(f.relacion);
                            $('#telefono').val(f.telefono);
                            $('#correo_electronico').val(f.correo_electronico);
                            $('#nombre_hijos').val(f.nombre_hijos);

                            // Cambiar el título del modal y mostrarlo
                            $('#modalFamiliarLabel').text('Editar Familiar');
                            $('#modalFamiliar').modal('show');
                        }
                    })
                    .catch(() => {
                        Swal.fire('Error', 'No se pudo cargar la información del familiar.', 'error');
                    });
            });

            // Evento al cerrar el modal (asegura limpieza del modal y capa de fondo)
            $('#modalFamiliar').on('hidden.bs.modal', function() {
                $('#formFamiliar')[0].reset(); // Limpiar el formulario
                $('#familiar_id').val(''); // Limpiar el campo oculto del ID
                $('body').removeClass('modal-open'); // Asegurar que la clase modal-open sea eliminada
                $('.modal-backdrop').remove(); // Eliminar cualquier capa residual de fondo
            });
        });



        $(document).ready(function() {
            // Interceptar el envío del formulario
            $('#formFamiliar').on('submit', function(e) {
                e.preventDefault(); // Prevenir el envío tradicional del formulario

                // Obtener los datos del formulario
                const formData = new FormData(this);

                // Enviar los datos usando fetch()
                fetch('/functions/clientes/save_familiar.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mostrar alerta de éxito con SweetAlert2
                        Swal.fire('Éxito', data.message, 'success').then(() => {
                            // Cerrar el modal y recargar la página
                            $('#modalFamiliar').modal('hide');
                            location.reload();
                        });
                    } else {
                        // Mostrar alerta de error con SweetAlert2
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    // Manejar errores de red u otros problemas
                    Swal.fire('Error', 'No se pudo procesar la solicitud.', 'error');
                });
            });
        });

    </script>

</body>
</html>