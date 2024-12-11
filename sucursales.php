<?php
    session_start();

    include('db.php');

    $role = $_SESSION['role'];

    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }

    $provinciasRD = [
        'Azua', 'Baoruco', 'Barahona', 'Dajabón', 'Distrito Nacional', 
        'Duarte', 'El Seibo', 'Elías Piña', 'Espaillat', 'Hato Mayor',
        'Hermanas Mirabal', 'Independencia', 'La Altagracia', 'La Romana', 
        'La Vega', 'María Trinidad Sánchez', 'Monseñor Nouel', 'Monte Cristi',
        'Monte Plata', 'Pedernales', 'Peravia', 'Puerto Plata', 
        'Samaná', 'San Cristóbal', 'San José de Ocoa', 'San Juan',
        'San Pedro de Macorís', 'Sánchez Ramírez', 'Santiago', 
        'Santiago Rodríguez', 'Santo Domingo', 'Valverde'
    ];

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

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script> 

    <style>
        .dataTables_filter {
            margin-bottom: 30px; /* Espacio entre el buscador y la tabla */
        }
    </style>

    <title>BRILLASIS Sucursales</title> 
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
            <img class="imglogo" src="imgs/logo.png" alt="image logo"> Sucursales
        </div>
        <br>
        <!--===========Sucursales===========-->
        <div class="card mx-auto" style="max-width: 1100px; min-height: auto;">
            <div class="card-header" style="background-color: #198754;"><h2 style="color: white;">Administración de las Sucursales</h2></div>
            <div class="card-body">
                <!-- <h2 class="card-title text-center">Datos de los Préstamos</h2><br><br> -->
                <br>
                <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalAgregarSucursal">Agregar Sucursal</button>
                <br><br>
                <table id="tablaSucursales" class="display table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Provincia</th>
                            <th>Compañía</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $conn->prepare("
                            SELECT s.id, s.nombre, s.direccion, s.telefono, s.provincia, c.nombre AS compania
                            FROM sucursal s
                            JOIN compania c ON s.compania_id = c.id
                        ");
                        $stmt->execute();
                        $sucursales = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($sucursales as $sucursal) {
                            echo "<tr>
                                    <td>{$sucursal['id']}</td>
                                    <td>{$sucursal['nombre']}</td>
                                    <td>{$sucursal['direccion']}</td>
                                    <td>{$sucursal['telefono']}</td>
                                    <td>{$sucursal['provincia']}</td>
                                    <td>{$sucursal['compania']}</td>
                                    <td>
                                        <button class='btn btn-warning btnEditar' data-id='{$sucursal['id']}'><i class='bx bxs-edit'></i></button>
                                        <button class='btn btn-danger btnEliminar' data-id='{$sucursal['id']}'><i class='bx bxs-trash' ></i></button>
                                    </td>
                                </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Modal Agregar Sucursal -->
            <div class="modal fade" id="modalAgregarSucursal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="formAgregarSucursal">
                            <div class="modal-header" style="background-color: #198754;">
                                <h4 class="modal-title" id="modalLabel" style="color: white;">Agregar Sucursal</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="limpiarFormulario()"></button>
                            </div>
                            <div class="modal-body">
                                <h5><strong>Nota:</strong><i> todos los campos con * son obligatorios.</i></h5>
                                <br>
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Digite el nombre" on required>
                                </div>
                                <div class="mb-3">
                                    <label for="direccion" class="form-label">Dirección <i class="text-danger">*</i></label>
                                    <textarea class="form-control" id="direccion" name="direccion" placeholder="Digite la direccion" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="telefono" class="form-label">Teléfono <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Digite el telefono" required>
                                </div>
                                <div class="mb-3">
                                    <label for="provincia" class="form-label">Provincia <i class="text-danger">*</i></label>
                                    <select class="form-control" id="provincia" name="provincia" required>
                                        <option selected disabled value="">Seleccione una Provincia</option>
                                        <?php foreach ($provinciasRD as $provincia): ?>
                                            <option value="<?php echo $provincia; ?>"><?php echo $provincia; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="compania_id" class="form-label">Compañía <i class="text-danger">*</i></label>
                                    <select class="form-control" id="compania_id" name="compania_id" required>
                                        <option selected disabled value="">Seleccione una Compañía</option>
                                        <?php
                                        $stmt = $conn->prepare("SELECT id, nombre FROM compania");
                                        $stmt->execute();
                                        $companias = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($companias as $compania) {
                                            echo "<option value='{$compania['id']}'>{$compania['nombre']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="limpiarFormulario()">Cerrar</button>
                                <button type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal de editar -->
            <div class="modal fade" id="modalEditarSucursal" tabindex="-1" aria-labelledby="editarSucursalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #198754;">
                            <h4 class="modal-title" id="editarSucursalLabel" style="color: white;">Editar Sucursal</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formEditarSucursal">
                            <div class="modal-body">
                                <h5><strong>Nota:</strong><i> todos los campos con * son obligatorios.</i></h5>
                                <br>
                                <input type="hidden" id="editSucursalId" name="id">
                                
                                <div class="mb-3">
                                    <label for="editSucursalNombre" class="form-label">Nombre <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" id="editSucursalNombre" name="nombre" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="editSucursalDireccion" class="form-label">Dirección <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" id="editSucursalDireccion" name="direccion" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="editSucursalTelefono" class="form-label">Teléfono <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" id="editSucursalTelefono" name="telefono" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="editSucursalProvincia" class="form-label">Provincia <i class="text-danger">*</i></label>
                                    <select class="form-control" id="editSucursalProvincia" name="provincia" required>
                                        <option selected disabled value="">Seleccione una Provincia</option>
                                        <?php foreach ($provinciasRD as $provincia): ?>
                                            <option value="<?php echo $provincia; ?>"><?php echo $provincia; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="editSucursalCompaniaId" class="form-label">Compañía <i class="text-danger">*</i></label>
                                    <select class="form-select" id="editSucursalCompaniaId" name="compania_id" required>
                                        <!-- Opciones cargadas dinámicamente -->
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <br><br><br><br>           
    </section>
    <script src="js/script.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="./js/keyboard.js"></script>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   
    <script>
        $('#telefono').mask('(000)-000-0000');   
        $('#editSucursalTelefono').mask('(000)-000-0000');    

        function limpiarFormulario() {
            const form = document.getElementById('formAgregarSucursal');
            form.reset(); // Limpia todos los campos del formulario
        }

     $(document).on('click', '.btnEditar', function () {
        const sucursalId = $(this).data('id');

        $.ajax({
            url: '/functions/get_sucursal.php',
            type: 'GET',
            data: { id: sucursalId },
            success: function (response) {
                const result = JSON.parse(response);

                if (result.success) {
                    const sucursal = result.sucursal;
                    const companias = result.companias;

                    $('#editSucursalId').val(sucursal.id);
                    $('#editSucursalNombre').val(sucursal.nombre);
                    $('#editSucursalDireccion').val(sucursal.direccion);
                    $('#editSucursalTelefono').val(sucursal.telefono);
                    $('#editSucursalProvincia').val(sucursal.provincia); // Seleccionar la provincia

                    const companiaSelect = $('#editSucursalCompaniaId');
                    companiaSelect.empty();
                    companias.forEach(compania => {
                        const selected = compania.id == sucursal.compania_id ? 'selected' : '';
                        companiaSelect.append(
                            `<option value="${compania.id}" ${selected}>${compania.nombre}</option>`
                        );
                    });

                    $('#modalEditarSucursal').modal('show');
                } else {
                    Swal.fire('Error', result.error, 'error');
                }
            },
            error: function () {
                Swal.fire('Error', 'No se pudo cargar la información de la sucursal.', 'error');
            }
        });
    });



        $(document).ready(function() {
    // Manejar la edición de sucursal
    $('#formEditarSucursal').on('submit', function(e) {
        e.preventDefault(); // Prevenir el envío tradicional del formulario

        const formData = new FormData(this);

        fetch('/functions/edit_sucursal.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar alerta de éxito
                Swal.fire('Éxito', data.message, 'success').then(() => {
                    $('#formEditarSucursal')[0].reset(); // Limpiar el formulario
                    $('#modalEditarSucursal').modal('hide'); // Cerrar el modal
                    location.reload(); // Recargar la página para reflejar los cambios
                });//.then(() => location.reload());
            } else {
                // Mostrar alerta de error
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(error => {
            Swal.fire('Error', 'No se pudo procesar la solicitud.', 'error');
            console.error('Error:', error);
        });
    });

});


    </script>

     <script>
        $(document).ready(function () {
            $('#tablaSucursales').DataTable({
                //lengthMenu: [ [5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "Todos"] ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                }
            });


            // Eliminar Sucursal
            $('.btnEliminar').on('click', function () {
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
                        $.post('/functions/delete_sucursal.php', { id: id }, function (response) {
                            Swal.fire(
                                '¡Eliminado!',
                                'La sucursal ha sido eliminada.',
                                'success'
                            ).then(() => location.reload());
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#formAgregarSucursal').on('submit', function(e) {
                e.preventDefault(); // Prevenir el envío tradicional del formulario

                const formData = new FormData(this);

                fetch('/functions/create_sucursal.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mostrar alerta de éxito
                        Swal.fire('Éxito', data.message, 'success').then(() => {
                            $('#formAgregarSucursal')[0].reset(); // Limpiar el formulario
                            $('#modalAgregarSucursal').modal('hide'); // Cerrar el modal
                            //location.reload(); // Recargar la tabla de sucursales
                        }).then(() => location.reload());
                    } else {
                        // Mostrar alerta de error
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'No se pudo procesar la solicitud.', 'error');
                    console.error('Error:', error);
                });
            });
        });

        function cargarOpcionesCompania(selectId, selectedId = null) {
            $.ajax({
                url: '/functions/get_compania.php',
                type: 'GET',
                success: function (response) {
                    const companias = JSON.parse(response);
                    const select = $(`#${selectId}`);
                    select.empty();

                    companias.forEach(compania => {
                        const selected = compania.id === selectedId ? 'selected' : '';
                        select.append(`<option value="${compania.id}" ${selected}>${compania.nombre}</option>`);
                    });
                },
                error: function () {
                    Swal.fire('Error', 'No se pudieron cargar las compañías.', 'error');
                }
            });
        }
    </script>

</body>
</html>