<?php
    session_start();

    include('db.php');

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
        .dataTables_filter {
            margin-bottom: 30px; /* Espacio entre el buscador y la tabla */
        }
    </style>

    <title>BRILLASIS Compañías</title> 
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
                        <a href="#">
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
                    <?php }else ?>
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
            <img class="imglogo" src="imgs/logo.png" alt="image logo"> Modulo de Compañías
        </div>
        <br>

         <!-- ===========    CRUD de companies  =========== -->
         <br>
        <div class="card mx-auto" style="max-width: 1100px; min-height: auto;">
            <div class="card-header" style="background-color: #198754;"><h2 style="color: white;">Administración de las Compañias</h2></div>
            <div class="card-body">
                <!-- <h2 class="card-title text-center">Datos de los Préstamos</h2><br><br> -->
                <br>
                <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalAgregarCompania">Agregar Compañía</button>
                <div class="d-flex justify-content-end ">
                    <a href="sucursales" style="text-decoration: none;">
                        <button class="btn btn-secondary" id="btnAccion">
                            <span style="color: white;">Administrar Sucursales</span> 
                        </button>
                    </a>
                </div>
                <br>
                <table id="tablaCompanias" class="display table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>RNC</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Interés fijo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM compania");
                        $stmt->execute();
                        $companias = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($companias as $compania) {
                            echo "<tr>
                                    <td>{$compania['id']}</td>
                                    <td>{$compania['nombre']}</td>
                                    <td>{$compania['rnc']}</td>
                                    <td>{$compania['direccion']}</td>
                                    <td>{$compania['telefono']}</td>
                                    <td>{$compania['correo']}</td>
                                    <td>{$compania['interes_fijo']}%</td>
                                    <td>
                                        <button class='btn btn-warning btnEditarCompania' data-id='{$compania['id']}'><i class='bx bxs-edit'></i></button>
                                        <button class='btn btn-danger btnEliminarCompania' data-id='{$compania['id']}'><i class='bx bxs-trash' ></i></button> 
                                    </td>
                                </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modales de agregar y editar -->
        <?php include './functions/modales_companies.php' ?>
        <br><br><br>
        
        </div>
        <br><br><br><br>           
    </section>
    <script src="js/companies.js"></script>
    <script src="js/script.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="./js/keyboard.js"></script>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script> 
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('#telefono').mask('(000)-000-0000'); 
        $('#editarTelefono').mask('(000)-000-0000');

        $(document).ready(function () {
            $('#tablaCompanias').DataTable({
                //lengthMenu: [ [5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "Todos"] ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                }
            });

            // Eliminar Compañía
            $('.btnEliminarCompania').on('click', function () {
                const id = $(this).data('id');
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "No podrás revertir esto",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post('/functions/delete_compania.php', { id: id }, function (response) {
                            Swal.fire(
                                '¡Eliminado!',
                                'La compañía ha sido eliminada.',
                                'success'
                            ).then(() => location.reload());
                        });
                    }
                });
            });
        });
    </script>
    <script>
        // Mostrar datos en el modal de edición
        $('.btnEditarCompania').on('click', function () {
            const id = $(this).data('id');

            $.ajax({
                url: '/functions/get_compania.php',
                type: 'POST',
                data: { id },
                success: function (data) {
                    const compania = JSON.parse(data);
                    $('#editarCompaniaId').val(compania.id);
                    $('#editarNombre').val(compania.nombre);
                    $('#editarRNC').val(compania.rnc);
                    $('#editarDireccion').val(compania.direccion);
                    $('#editarTelefono').val(compania.telefono);
                    $('#editarCorreo').val(compania.correo);
                    $('#editarInteresFijo').val(compania.interes_fijo);
                    
                    $('#modalEditarCompania').modal('show');
                }
            });
        });

        // Procesar la edición de la compañía
        $('#formEditarCompania').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: '/functions/edit_compania.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function (data) {
                    const response = JSON.parse(data);

                    if (response.success) {
                        Swal.fire('¡Éxito!', 'Compañía actualizada correctamente.', 'success').then(() => location.reload());
                    // $('#modalEditarCompania').modal('hide');
                        //$('#tablaSucursales').DataTable().ajax.reload();
                        //cargarTablaCompanias(); // Recargar la tabla
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                }
            });
        });

        $('#formAgregarCompania').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: '/functions/create_compania.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    const data = JSON.parse(response);

                    if (data.success) {
                        Swal.fire('¡Éxito!', 'Compañía agregada correctamente.', 'success').then(() => location.reload());
                        //$('#modalAgregarCompania').modal('hide');
                        //cargarTablaCompanias(); // Recargar la tabla
                    } else {
                        Swal.fire('Error', data.message || 'No se pudo agregar la compañía.', 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Hubo un problema con la solicitud.', 'error');
                }
            });
        });
    </script>
</body>
</html>