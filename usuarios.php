<?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="./imgs/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="css/logo.css">
    <link rel="stylesheet" href="css/usuarios.css">

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

    <title>BRILLASIS Usuarios</title> 
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
                   
                    <li class="nav-link">
                        <a href="#">
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

                    <li class="nav-link">
                        <a href="clientes">
                            <!--Identficador del icono sacado del i: bx-bar-chart-alt-2-->
                            <i class='bx icon' ><ion-icon name="people-outline"></ion-icon></i>
                            <span class="text nav-text">Socios</span>
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
            <img class="imglogo" src="imgs/logo.png" alt="image logo"> USUARIOS
        </div>
        <br>
        <div class="card mx-auto" style="max-width: 900px; min-height: auto;">
            <div class="card-header" style="background-color: #198754;"><h2 style="color: white;">Administración de Usuarios</h2></div>
            <div class="card-body">
            <br>
            <button class="btn btn-success mb-3" data-toggle="modal" data-target="#modalCrearUsuario">Agregar Usuario</button>
            <br><br>
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
                            //echo "<td>" . htmlspecialchars($usuario['role']) . "</td>";
                            if ($usuario['role'] == 'admin') {
                                echo "<td>" . "Administrador" . "</td>";
                            } else if($usuario['role'] == 'cajeroa') {
                                echo "<td>" . "Cajero de Ahorros" . "</td>";
                            } else{
                                echo "<td>" . "Cajero de Prestamos" . "</td>";
                            }
                            echo "<td>
                                    <button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#modalEditarUsuario' data-id='" . $usuario['id'] . "'><i class='bx bxs-edit'></i> Editar</button>
                                    <button class='btn btn-danger btn-sm btn-eliminar' data-id='" . $usuario['id'] . "'><i class='bx bxs-trash'></i> Eliminar</button> 
                                </td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
            </div>
        </div>

        <!-- Modal para Agregar Usuario -->
        <div class="modal fade" id="modalCrearUsuario" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalCrearUsuarioLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="./functions/create_usuario.php" method="POST" id="Modal">
                        <div class="modal-header" style="background-color: #198754;">
                            <h4 class="modal-title" id="modalCrearUsuarioLabel" style="color: white;">Agregar Usuario</h4>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" onclick="Limpiar()"></button>
                        </div>
                        <div class="modal-body">
                        <h5><u><strong>Nota:</strong><i> todos los campos con * son obligatorios.</i></u></h5>
                        <br>
                            <div class="form-group">
                                <label for="username">Nombre de Usuario <i class="text-danger">*</i></label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Introduzca el usuario aquí" pattern="[A-Za-z0-9_-]" title="Solo números, letras, guiones (-) y guiones bajos (_)" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña <i class="text-danger">*</i></label>
                                <div class="password-container">
                                    <input type="password" class="form-control password-input" name="password" id="password" placeholder="Introduzca la contraseña aquí" required>
                                    <span id="toggle-password" class="password-toggle">👁️</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role">Rol <i class="text-danger">*</i></label>
                                <select class="form-control" name="role" id="role" required>
                                    <option selected disabled value="">Seleccione una Opción</option>
                                    <option value="admin">administrador</option>
                                    <option value="cajeroa">cajero de ahorros</option>
                                    <option value="cajerop">cajero de prestamos</option> 
                                    <?php
                                    // Cargar los roles desde la base de datos
                                   /* $roles = $conn->query("SELECT role FROM usuarios");
                                    while ($rol = $roles->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $rol['id'] . "'>" . htmlspecialchars($rol['role']) . "</option>";
                                    } */
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer" style="background-color: #c8c8c8;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="Limpiar()">Cancelar</button>
                            <button type="submit" class="btn btn-success">Guardar Usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal para Editar Usuario || Lo que estaba en el form action="./functions/edit_usuario.php" method="POST" -->
        <div class="modal fade" id="modalEditarUsuario" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form>
                        <div class="modal-header" style="background-color: #198754;">
                            <h4 class="modal-title" id="modalEditarUsuarioLabel" style="color: white;">Editar Usuario</h4>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <h5><u><strong>Nota:</strong><i> todos los campos con * son obligatorios.</i></u></h5>
                        <br>
                            <input type="hidden" name="id" id="edit_id">
                            <div class="form-group">
                                <label for="edit_username">Nombre de Usuario <i class="text-danger">*</i></label>
                                <input type="text" class="form-control" name="username" id="edit_username" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_password">Contraseña (Dejar en blanco si no se quiere cambiar)</label>
                                <input type="password" class="form-control" name="password" id="edit_passwords">
                            </div>
                            <div class="form-group">
                                <label for="edit_role">Rol <i class="text-danger">*</i></label>
                                <select class="form-control" name="role" id="edit_role" required>
                                    <option selected disabled value="">Seleccione una Opción</option>
                                    <option value="admin">administrador</option>
                                    <option value="cajeroa">cajero de ahorros</option>
                                    <option value="cajerop">cajero de prestamos</option> 
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer" style="background-color: #c8c8c8;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Actualizar Usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br><br><br><br>
    </section>

    <!-- ====== Muestra el mensaje del sweetalert ======= -->
    <?php require('functions/mensajeusuario.php'); ?>

    <script src="js/script.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="js/usuarios.js"></script>
    <script src="js/keyboard.js"></script>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#usuariosTable').DataTable({
                lengthMenu: [ [5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "Todos"] ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                }
            });

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
        $('#modalEditarUsuario').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget); 
            const id = button.data('id'); 

            fetch('/functions/get_usuario.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const usuario = data.usuario;
                        $('#edit_id').val(usuario.id);
                        $('#edit_username').val(usuario.username);
                        $('#edit_role').val(usuario.role);
                        $('#edit_password').val(''); // Limpia el campo de contraseña
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(() => {
                    Swal.fire('Error', 'No se pudo obtener los datos del usuario.', 'error');
                });
        });


        $(document).ready(function () {
            // Enviar formulario de edición de usuario
            $('#modalEditarUsuario form').on('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);

                fetch('/functions/edit_usuario.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Éxito', data.message, 'success').then(() => {
                                $('#modalEditarUsuario').modal('hide');
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(() => {
                        Swal.fire('Error', 'No se pudo procesar la solicitud.', 'error');
                    });
            });
        });
    </script>

</body>
</html>