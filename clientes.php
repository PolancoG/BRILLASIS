<?php
   /* session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    } */
    require './functions/create.php'
    
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
    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <!----===== Data Table CSS ===== -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!--SWEET ALERT CDN CSS-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
    <title>COOPLIGHT Clientes</title> 
</head>
<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="imgs/logo.png" alt="">
                </span>

                <div class="text logo-text">
                    <span class="name">COOPLIGHT</span>
                    <span class="profession">Cooperativa Light</span>
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
                    <?php if($role == 'admin' || $role == 'socio') { ?>
                    <li class="nav-link">
                        <a href="usuarios">
                            <i class='bx bx-user icon' ></i>
                            <span class="text nav-text">Usuarios</span>
                        </a>
                    </li>
                    <?php } ?>
                    <li class="nav-link">
                        <a href="#">
                            <!--Identficador del icono sacado del i: bx-bar-chart-alt-2-->
                            <i class='bx icon' ><ion-icon name="people-outline"></ion-icon></i>
                            <span class="text nav-text">Clientes</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="prestamos">
                            <i class='bx icon'><ion-icon name="cash-outline"></ion-icon></i>
                            <span class="text nav-text">Prestamos</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="ahorros">
                            <i class='bx icon' ><ion-icon name="wallet-outline"></ion-icon></i>
                            <span class="text nav-text">Ahorro</span>
                        </a>
                    </li>
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
            Lista de Clientes
        </div>
        <br>
        <div class="container mt-4">
            <button class="btn btn-success" data-toggle="modal" data-target="#createModal">Agregar Cliente</button>
            <br>
            <br>
            <table id="clientesTable" class="table table-striped"> <!-- display mt-4 -->
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cédula</th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                       <!-- <th>Lugar Trabajo</th> -->
                        <th>Teléfono1</th>
                       <!-- <th>Teléfono2</th> -->
                        <th>Correo Personal</th>
                      <!--  <th>Correo Institucional</th> -->
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require 'db.php';
                    $sql = "SELECT * FROM cliente";
                    $stmt = $conn->query($sql);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>{$row['cedula']}</td>";
                        echo "<td>{$row['nombre']}</td>";
                        echo "<td>{$row['direccion']}</td>";
                        //echo "<td>{$row['lugar_trabajo']}</td>";
                        echo "<td>{$row['telefono1']}</td>";
                        //echo "<td>{$row['telefono2']}</td>";
                        echo "<td>{$row['correo_personal']}</td>";
                       // echo "<td>{$row['correo_institucional']}</td>";
                       if($role == 'admin' || $role == 'socio') { 
                        echo "<td>
                                <button class='btn btn-warning btn-sm' onclick='openEditModal(" . json_encode($row) . ")'>Editar</button>
                                <!--<a href='./functions/delete.php?id={$row['id']}' class='btn btn-danger btn-sm'>Eliminar</a>-->
                                <button class='btn btn-danger btn-sm btn-eliminar' data-id='" . $row['id'] . "'>Eliminar</button>
                            </td>";
                        echo "</tr>";
                       }
                       else{
                        echo "<td>
                                <button class='btn btn-warning' disabled >Editar</button>
                                <button class='btn btn-danger' disabled >Eliminar</button>
                            </td>";
                        echo "</tr>";
                       }
                    }
                    ?>
                </tbody>
            </table>
                    <!-- Modal para Agregar Cliente -->
            <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="./functions/create.php" method="POST">
                            <div class="modal-header" style="background-color: #4a9f39;">
                                <h5 class="modal-title" id="createModalLabel" style="color: white;">Agregar Cliente</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label>Cédula:</label><input type="text" name="cedula" class="form-control" required>
                                <label>Nombre:</label><input type="text" name="nombre" class="form-control" required>
                                <label>Dirección:</label><input type="text" name="direccion" class="form-control">
                                <label>Lugar de Trabajo:</label><input type="text" name="lugar_trabajo" class="form-control">
                                <label>Teléfono 1:</label><input type="text" name="telefono1" class="form-control">
                                <label>Teléfono 2:</label><input type="text" name="telefono2" class="form-control">
                                <label>Correo Personal:</label><input type="email" name="correo_personal" class="form-control">
                                <label>Correo Institucional:</label><input type="email" name="correo_institucional" class="form-control">
                            </div>
                            <div class="modal-footer" style="background-color: #c8c8c8;">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal para Editar Cliente -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="./functions/edith.php" method="POST">
                            <div class="modal-header" style="background-color: #4a9f39;">
                                <h5 class="modal-title" id="createModalLabel" style="color: white;">Editar Cliente</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" id="edit_id">
                                <label>Cédula:</label><input type="text" name="cedula" id="edit_cedula" class="form-control" required>
                                <label>Nombre:</label><input type="text" name="nombre" id="edit_nombre" class="form-control" required>
                                <label>Dirección:</label><input type="text" name="direccion" id="edit_direccion" class="form-control">
                                <label>Lugar de Trabajo:</label><input type="text" name="lugar_trabajo" id="edit_lugar_trabajo" class="form-control">
                                <label>Teléfono 1:</label><input type="text" name="telefono1" id="edit_telefono1" class="form-control">
                                <label>Teléfono 2:</label><input type="text" name="telefono2" id="edit_telefono2" class="form-control">
                                <label>Correo Personal:</label><input type="email" name="correo_personal" id="edit_correo_personal" class="form-control">
                                <label>Correo Institucional:</label><input type="email" name="correo_institucional" id="edit_correo_institucional" class="form-control">
                            </div>
                            <div class="modal-footer" style="background-color: #c8c8c8;">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-success">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- ====== Muestra el mensaje del sweetalert ======= -->
    <?php require('functions/mensajecliente.php'); ?>

    <script src="js/script.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="js/clientes.js"></script>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
      //Cargar datatable 
        $(document).ready(function() {
            $('#clientesTable').DataTable(
                {
                    "language":{
                        "url":"//cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json"
                    }
                }
            );
        //});

        //$(document).ready(function() {
        // $('#clientesTable').DataTable();

            // SweetAlert para confirmar eliminación
            $('.btn-eliminar').click(function() {
                const clientId = $(this).data('id');

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "No podrás deshacer esta acción",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './functions/delete.php?id=' + clientId;
                    }
                });
            });
        });
    </script>
</body>
</html>