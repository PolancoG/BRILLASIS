<?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="./imgs/logo.png" type="image/x-icon">
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

    <title>COOPLIGHT Usuarios</title> 
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

                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-user icon' ></i>
                            <span class="text nav-text">Usuarios</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="clientes">
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
            USUARIOS
        </div>
        <br>
        <div class="container mt-4">
            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalCrearUsuario">Agregar Usuario</button>
            
            <table id="usuariosTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        require 'db.php';

                        $stmt = $conn->query("SELECT * FROM usuarios");
                        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($usuarios as $usuario) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($usuario['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($usuario['username']) . "</td>";
                            echo "<td>" . htmlspecialchars($usuario['role']) . "</td>";
                            echo "<td>
                                    <button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#modalEditarUsuario' data-id='" . $usuario['id'] . "'>Editar</button>
                                    <button class='btn btn-danger btn-sm btn-eliminar' data-id='" . $usuario['id'] . "'>Eliminar</button> 
                                </td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Modal para Agregar Usuario -->
        <div class="modal fade" id="modalCrearUsuario" tabindex="-1" aria-labelledby="modalCrearUsuarioLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="./functions/create_usuario.php" method="POST">
                        <div class="modal-header" style="background-color: #4a57ff;">
                            <h5 class="modal-title" id="modalCrearUsuarioLabel" style="color: white;">Agregar Usuario</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="username">Nombre de Usuario</label>
                                <input type="text" class="form-control" name="username" id="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" name="password" id="password" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Rol</label>
                                <select class="form-control" name="role" id="role" required>
                                    <option value="admin">admin</option>
                                    <option value="cajero" selected>cajero</option>
                                    <option value="socio">socio</option>
                                    <?php
                                    /*// Cargar los roles desde la base de datos
                                    $roles = $conn->query("SELECT role FROM usuarios");
                                    while ($rol = $roles->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" /* . $rol['id'] . "'>" */ //. htmlspecialchars($rol['role']) . "</option>";
                                    //} 
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer" style="background-color: #c8c8c8;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal para Editar Usuario -->
        <div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="./functions/edit_usuario.php" method="POST">
                        <div class="modal-header" style="background-color: #4a57ff;">
                            <h5 class="modal-title" id="modalEditarUsuarioLabel" style="color: white;">Editar Usuario</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="edit_id">
                            <div class="form-group">
                                <label for="edit_username">Nombre de Usuario</label>
                                <input type="text" class="form-control" name="username" id="edit_username" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_password">Contraseña (Dejar en blanco si no se quiere cambiar)</label>
                                <input type="password" class="form-control" name="password" id="edit_password">
                            </div>
                            <div class="form-group">
                                <label for="edit_role">Rol</label>
                                <select class="form-control" name="role" id="edit_role" required>
                                    <option value="value1">admin</option>
                                    <option value="value2" selected>cajero</option>
                                    <option value="value3">socio</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer" style="background-color: #c8c8c8;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>

    <!-- ====== Muestra el mensaje del sweetalert ======= -->
    <?php require('functions/mensajeusuario.php'); ?>

    <script src="js/script.js"></script>
    <script src="assets/js/main.js"></script>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#usuariosTable').DataTable(
                {
                    "language":{
                        "url":"//cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json"
                    }
                }
            );

            // SweetAlert para confirmar eliminación
            $('.btn-eliminar').click(function() {
                const userId = $(this).data('id');

                Swal.fire({
                    title: 'Estas a punto de eliminar el usuario',
                    text: "¿Estás seguro?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './functions/delete_usuario.php ?id=' + userId;
                    }
                }); 
            });
        });
    </script>

    <script>
        // Cargar datos en el modal de edición cuando se hace clic en "Editar"
        $('#modalEditarUsuario').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); 
            var id = button.data('id'); 

            // Realizar una solicitud AJAX para obtener los datos del usuario
            $.ajax({
                url: './functions/get_usuario.php',
                method: 'GET',
                data: { id: id },
                success: function(response) {
                    var usuario = JSON.parse(response);
                    $('#edit_username').val(usuario.username);
                    $('#edit_password').val(usuario.password);
                    $('#edit_role').val(usuario.role);
                }
            });
        });
    </script>

</body>
</html>