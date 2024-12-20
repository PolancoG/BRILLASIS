<?php
   session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    } 
    
    require 'db.php';

    $role = $_SESSION['role'];

    try {
        $stmt = $conn->query("
            SELECT c.id, c.numero_socio, c.cedula, c.nombre, c.contrato, c.image_cedula,
                   s.nombre AS sucursal_nombre, co.nombre AS compania_nombre
            FROM cliente c
            JOIN sucursal s ON c.sucursal_id = s.id
            JOIN compania co ON s.compania_id = co.id
        ");
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error al obtener los clientes: " . $e->getMessage());
    }
    // Obtener la lista de clientes 
  /*  $stmt = $conn->query("
        SELECT c.id, c.numero_socio, c.cedula, c.nombre, s.nombre AS sucursal_nombre
        FROM cliente c
        LEFT JOIN sucursal s ON c.sucursal_id = s.id
    ");
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC); */

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

   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script> 
 
   <style>
        .dataTables_filter {
            margin-bottom: 30px; /* Espacio entre el buscador y la tabla */
        }
    </style>

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
                        <a href="#">
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
            <img class="imglogo" src="imgs/logo.png" alt="image logo"> Socios
        </div>
        <br>
        <div class="card mx-auto" style="max-width: 1150px; min-height: auto;">
            <div class="card-header" style="background-color: #198754;"><h2 style="color: white;">Administración de los Socios</h2></div>
            <div class="card-body">
            <br>
            <!--<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarCliente">Agregar Socio</button>-->
            <button class="btn btn-success mb-3" id="btnAgregarCliente">Agregar Socio</button>
            <div class="d-flex justify-content-end mb-2">
                <a href="familiar" style="text-decoration: none;">
                    <button class="btn btn-secondary" id="btnAccion">
                        <span style="color: white;">Administrar Familiares</span> 
                    </button>
                </a>
            </div>
            
            <div class="d-flex justify-content-end mb-3">
            </div>
            <!-- Datatable -->
            <table id="tablaClientes" class="table table-hover table-bordered" style="width:100%;">
                <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Número de Socio</th>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Compañia</th>
                    <th>Sucursal</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($clientes as $c): ?>
                    <tr>
                        <td><?php echo $c['id']; ?></td>
                        <td><?php echo $c['numero_socio']; ?></td>
                        <td><?php echo $c['cedula']; ?></td>
                        <td><?php echo $c['nombre']; ?></td>
                        <td><?php echo $c['compania_nombre']; ?></td> <!-- Dato de la compañía -->
                        <td><?php echo $c['sucursal_nombre']; ?></td>
                        <?php if($role == 'admin') { ?>
                            <td>
                                <button class="btn btn-info btn-sm btnDetalle" data-id="<?php echo $c['id']; ?>"><i class='bx bx-detail'></i></button>
                                <button class="btn btn-primary btn-sm btnEditar" data-id="<?php echo $c['id']; ?>"><i class='bx bxs-edit'></i></button>
                                <button class="btn btn-danger btn-sm btnEliminar" data-id="<?php echo $c['id']; ?>"><i class='bx bxs-trash' ></i></button>
                                <button class="btn btn-primary btn-sm btnVerOpciones" data-id="<?php echo $c['id']; ?>" data-cedula="<?php echo $c['image_cedula']; ?>" data-contrato="<?php echo isset($c['contrato']) ? $c['contrato'] : ''; ?>">
                                    <i class='bx bxs-file'></i>
                                </button>
                            </td>
                        <?php }else {?>
                            <td>
                                <button class="btn btn-info btn-sm btnDetalle" data-id="<?php echo $c['id']; ?>"><i class='bx bx-detail'></i></button>
                                <button class="btn btn-primary btn-sm btnEditar" data-id="<?php echo $c['id']; ?>" hidden><i class='bx bxs-edit'></i></button>
                                <button class="btn btn-danger btn-sm btnEliminar" data-id="<?php echo $c['id']; ?>" hidden><i class='bx bxs-trash' ></i></button>
                                <button class="btn btn-primary btn-sm btnVerOpciones" data-id="<?php echo $c['id']; ?>" data-cedula="<?php echo $c['image_cedula']; ?>" data-contrato="<?php echo isset($c['contrato']) ? $c['contrato'] : ''; ?>">
                                    <i class='bx bxs-file'></i>
                                </button>
                            </td>
                        <?php }?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

            <!-- Modal Agregar/Editar Cliente -->
            <div class="modal fade" id="modalCliente" data-bs-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalClienteLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <form id="formCliente">
                            <div class="modal-header" style="background-color: #198754;">
                                <h4 class="modal-title" id="modalClienteLabel" style="color: white;">Agregar/Editar Socio</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" id="cliente_id">
                                <h5><strong>Nota:</strong> <i>todos los campos con * son obligatorios.</i></h5>
                                <br>

                                <!-- Información del Cliente -->
                                <fieldset class="border p-3 mb-4">
                                    <legend class="w-auto px-2">Datos del Socio</legend>
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="numero_socio">Número de Socio <i class="text-danger">*</i></label>
                                            <input type="number" class="form-control form-control-sm" name="numero_socio" id="numero_socio" placeholder="Digite el # del socio" required>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="cedula">Cédula <i class="text-danger">*</i></label>
                                            <input type="text" class="form-control form-control-sm" name="cedula" id="cedula" placeholder="Digite la cedula" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="nombre">Nombre Completo <i class="text-danger">*</i></label>
                                            <input type="text" class="form-control" name="nombre" id="nombre" onkeyPress='return onlyLtt(event.key);' placeholder="Digite el nombre completo" required>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="sucursal_id">Sucursal <i class="text-danger">*</i></label>
                                            <select class="form-control" name="sucursal_id" id="sucursal_id" required>
                                                <option value="" disabled selected>Seleccione una Sucursal</option>
                                                <?php foreach ($sucursales as $sucursal): ?>
                                                    <option value="<?php echo $sucursal['id']; ?>"><?php echo $sucursal['nombre']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        
                                    </div>

                                    <!-- Dirección -->
                                    <div class="row mt-3">
                                        <div class="form-group col-md-4">
                                            <label for="direccion_linea1">Dirección (Línea 1) <i class="text-danger">*</i></label>
                                            <input type="text" class="form-control" name="direccion_linea1" id="direccion_linea1" placeholder="Linea 1" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="direccion_linea2">Dirección (Línea 2)</label>
                                            <input type="text" class="form-control" name="direccion_linea2" id="direccion_linea2" placeholder="Linea 2">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="provincia">Provincia <i class="text-danger">*</i></label>
                                            <input type="text" class="form-control" name="provincia" id="provincia" placeholder="Este campo se llena automaticamente" readonly>
                                        </div>
                                    </div>

                                    <!-- Descripción -->
                                    <div class="row mt-3">
                                        <div class="form-group col-md-12">
                                            <label for="descripcion">Descripción</label>
                                            <textarea class="form-control" name="descripcion" id="descripcion" rows="3" placeholder="Agregue una descripcion"></textarea>
                                        </div>
                                    </div>

                                    <!-- Otros datos -->
                                    <div class="row mt-3">
                                        <div class="form-group col-md-3">
                                            <label for="lugar_trabajo">Lugar de Trabajo <i class="text-danger">*</i></label>
                                            <input type="text" class="form-control form-control-sm" name="lugar_trabajo" id="lugar_trabajo" placeholder="Digite le lugar de trabajo" required>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="telefono1">Teléfono 1 <i class="text-danger">*</i></label>
                                            <input type="text" class="form-control form-control-sm" name="telefono1" id="telefono1" placeholder="Digite el telefono" required>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="telefono2">Teléfono 2</label>
                                            <input type="text" class="form-control form-control-sm" name="telefono2" id="telefono2" placeholder="Digite otro telefono">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="correo_personal">Correo Personal <i class="text-danger">*</i></label>
                                            <input type="email" class="form-control form-control-sm" name="correo_personal" id="correo_personal" placeholder="Digite el correo personal" required>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="correo_institucional">Correo Institucional </label>
                                            <input type="email" class="form-control form-control-sm" name="correo_institucional" id="correo_institucional" placeholder="Digite el correo institucional">
                                        </div>
                                    </div>

                                    <!-- Más datos -->
                                    <div class="row mt-3">
                                        <div class="form-group col-md-3">
                                            <label for="sexo">Sexo <i class="text-danger">*</i></label>
                                            <select class="form-control form-control-sm" name="sexo" id="sexo" required>
                                                <option value="" selected disabled>Seleccione el sexo</option>
                                                <option value="Masculino">Masculino</option>
                                                <option value="Femenino">Femenino</option>
                                                <option value="Otro">Otro</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="estado_civil">Estado Civil <i class="text-danger">*</i></label>
                                            <select class="form-control form-control-sm" name="estado_civil" id="estado_civil" required>
                                                <option value="" selected disabled>Seleccione el estado civil</option>
                                                <option value="Soltero">Soltero</option>
                                                <option value="Casado">Casado</option>
                                                <option value="Divorciado">Divorciado</option>
                                                <option value="Viudo">Viudo</option>
                                                <option value="Unión Libre">Unión Libre</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="nacionalidad">Nacionalidad <i class="text-danger">*</i></label>
                                            <input type="text" class="form-control form-control-sm" name="nacionalidad" id="nacionalidad" placeholder="Digite la nacionalidad" required>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="ingresos_mensuales">Ingresos Mensuales <i class="text-danger">*</i></label>
                                            <input type="text" class="form-control form-control-sm" name="ingresos_mensuales" id="ingresos_mensuales" onkeyPress='return isNumber(event.key);' placeholder="Digite los ingresos mensuales" required>
                                        </div>
                                    </div>    
                                    <div class="row mt-3">    
                                        <div class="form-group col-md-3">
                                            <label for="otros_ingresos">Otros Ingresos</label>
                                            <input type="text" class="form-control form-control-sm" name="otros_ingresos" id="otros_ingresos" onkeyPress='return isNumber(event.key);' placeholder="Digite otros ingresos" value="0"> 
                                        </div>
                                       <!-- <div class="form-group col-md-3">
                                            <label for="image_cedula">Imagen de la Cédula </label>
                                            <input type="file" class="form-control form-control-sm" name="image_cedula" id="image_cedula" accept="image/*" >
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="contrato">Contrato </label>
                                            <input type="file" class="form-control form-control-sm" name="contrato" id="contrato" accept=".pdf,.doc,.docx" >
                                        </div> -->

                                    </div>
                                </fieldset>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <!-- Modal para detalles del cliente -->
            <div class="modal fade" id="modalDetalleCliente" data-bs-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalDetalleClienteLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #198754;">
                            <h4 class="modal-title" id="modalDetalleClienteLabel" style="color: white;">Detalle del Cliente</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="cliente_id">
                            <!-- Sección de Información Personal -->
                            <fieldset class="border p-3 mb-4">
                                <legend class="w-auto px-2"><strong><u>Información Personal</u></strong></legend>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p><strong>Número de Socio:</strong> <span id="detalle_numero_socio"></span></p>
                                        <p><strong>Cédula:</strong> <span id="detalle_cedula"></span></p>
                                        <p><strong>Nombre Completo:</strong> <span id="detalle_nombre"></span></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p><strong>Dirección:</strong> <span id="detalle_direccion"></span></p>
                                        <p><strong>Teléfono 1:</strong> <span id="detalle_telefono1"></span></p>
                                        <p><strong>Teléfono 2:</strong> <span id="detalle_telefono2"></span></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p><strong>Correo Personal:</strong> <span id="detalle_correo_personal"></span></p>
                                        <p><strong>Correo Institucional:</strong> <span id="detalle_correo_institucional"></span></p>
                                        <p><strong>Lugar de Trabajo:</strong> <span id="detalle_lugar_trabajo"></span></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p><strong>Sexo:</strong> <span id="detalle_sexo"></span></p>
                                        <p><strong>Estado Civil:</strong> <span id="detalle_estado_civil"></span></p>
                                        <p><strong>Nacionalidad:</strong> <span id="detalle_nacionalidad"></span></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p><strong>Descripción:</strong> <span id="detalle_descripcion"></span></p>
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Sección de Información Financiera -->
                            <fieldset class="border p-3 mb-4">
                                <legend class="w-auto px-2"><strong><u>Información Financiera</u></strong></legend>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p><strong>Ingresos Mensuales:</strong> <span id="detalle_ingresos_mensuales"></span></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p><strong>Otros Ingresos:</strong> <span id="detalle_otros_ingresos"></span></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p><strong>Ahorros Totales:</strong> <span id="detalle_ahorros"></span></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p><strong>Préstamos Totales:</strong> <span id="detalle_prestamos"></span></p>
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Sección de Sucursal y Compañía -->
                            <fieldset class="border p-3 mb-4">
                                <legend class="w-auto px-2"><strong><u>Compañía y Sucursal a la que pertenece</u></strong></legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Compañía:</strong> <span id="detalle_compania"></span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Sucursal:</strong> <span id="detalle_sucursal"></span></p>
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Sección de Información Adicional -->
                            <fieldset class="border p-3">
                                <legend class="w-auto px-2"><strong><u>Información Adicional</u></strong></legend>
                                <div class="row">
                               <!--     <div class="col-md-4">
                                        <p><strong>Sexo:</strong> <span id="detalle_sexo"></span></p>
                                        <p><strong>Estado Civil:</strong> <span id="detalle_estado_civil"></span></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p><strong>Nacionalidad:</strong> <span id="detalle_nacionalidad"></span></p>
                                        <p><strong>Descripción:</strong> <span id="detalle_descripcion"></span></p>
                                    </div> -->
                                </div> 
                            </fieldset>
                        </div>
                        <div class="modal-footer">
                            <!-- Para ver el boton quitar el valo hidden -->
                            <button type="button" class="btn btn-secondary " id="btnImprimirDetalle"> 
                                Imprimir <i class="bx bx-printer"></i>
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal "¿Qué deseas ver?" -->
            <div class="modal fade" id="modalOpciones" tabindex="-1" aria-labelledby="modalOpcionesLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalOpcionesLabel">¿Qué deseas ver?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <button class="btn btn-secondary btnVerCedula">Ver Cédula</button>
                            <!-- <button class="btn btn-primary btnVerContratoss"></button> -->
                                <a href="functions/clientes/descargar_archivo.php?id=1" class="btn btn-primary">Descargar Contrato</a>
                            
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal "Cédula del Socio" -->
            <div class="modal fade" id="modalCedula" tabindex="-1" aria-labelledby="modalCedulaLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCedulaLabel">Cédula del Socio</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <!-- <img id="cedulaImagen" src="" alt="Imagen de la Cédula" class="img-fluid"> -->
                            <img id="cedulaImagen" src="functions/clientes/mostrar_imagen.php?id=1" alt="Imagen de la Cédula" class="img-fluid">

                        </div>
                    </div>
                </div>
            </div>

            <!-- End clientes -->
            </div>
        </div>
        <br><br><br><br>
    </section>
    
    <!-- ====== Muestra el mensaje del sweetalert ======= -->

    <script src="js/script.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="js/clientes.js"></script>
   <script src="./js/keyboard.js"></script>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>--> 
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 
    <script>
        //Funcion para limpiar el modal
        function Limpiar() {
            document.getElementById("Modal").reset();
        }
    </script>
    <script>

        $(document).on('click', '#btnImprimirDetalle', function () {

            const clienteId = $('#modalDetalleCliente').data('id');

            if (clienteId) {
                const url = '/functions/clientes/print_cliente.php?id=' + clienteId;
                window.open(url, '_blank');
            } else {
                Swal.fire('Error', 'No se pudo obtener el ID del cliente.', 'error');
            }
        });


        $(document).ready(function () {
                // Inicializar DataTable sin AJAX
                $('#tablaClientes').DataTable({
                    language: {
                        url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                    }
                });

                // Botón agregar cliente
                $('#btnAgregarCliente').click(function () {
                    limpiarFormulario();
                    $('#modalClienteLabel').text('Formulario de Agregar Socios');
                    $('#modalCliente').modal('show');
                });

                // Manejar el formulario de cliente
                $('#formCliente').on('submit', function (e) {
                    e.preventDefault();

                    // Construir dirección completa
                    const direccionLinea1 = $('#direccion_linea1').val();
                    const direccionLinea2 = $('#direccion_linea2').val() || '';
                    const provincia = $('#provincia').val();
                    const direccionCompleta = `${direccionLinea1}, ${direccionLinea2}, ${provincia}`;

                    // Crear el objeto de datos del formulario
                    const formData = new FormData(this);
                    formData.set('direccion', direccionCompleta);

                    fetch('/functions/clientes/save_cliente.php', {
                        method: 'POST',
                        body: formData,
                    })
                        .then((r) => r.json())
                        .then((response) => {
                            if (response.success) {
                                Swal.fire('Éxito', response.message, 'success').then(() => {
                                    $('#modalCliente').modal('hide');
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error', response.message, 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Error', 'No se pudo procesar la solicitud.', 'error');
                        });
                });

                // Actualizar provincia al seleccionar sucursal
                $('#sucursal_id').on('change', function () {
                    const provincia = $(this).find(':selected').data('provincia');
                    $('#provincia').val(provincia);
                });
        

            //Muestrar los detalles del cliente en el modal 
            $(document).on('click', '.btnDetalle', function() {
                const id = $(this).data('id');

                // Almacenar el ID del cliente en el modal
                $('#modalDetalleCliente').data('id', id);

                fetch(`/functions/clientes/get_detalle_cliente.php?id=${id}`)
                    .then(res => res.json())
                    .then(response => {
                        if (response.error) {
                            Swal.fire('Error', response.error, 'error');
                        } else {
                            const c = response.cliente;

                              // Formateador para moneda
                                const formatCurrency = (value) => {
                                    return new Intl.NumberFormat('es-DO', {
                                        style: 'currency',
                                        currency: 'DOP'
                                    }).format(value);
                                };

                            $('#detalle_numero_socio').text(c.numero_socio);
                            $('#detalle_cedula').text(c.cedula);
                            $('#detalle_nombre').text(c.nombre);
                            $('#detalle_direccion').text(c.direccion);
                            $('#detalle_telefono1').text(c.telefono1);
                            $('#detalle_telefono2').text(c.telefono2);
                            $('#detalle_correo_personal').text(c.correo_personal);
                            $('#detalle_correo_institucional').text(c.correo_institucional);
                            $('#detalle_sexo').text(c.sexo);
                            $('#detalle_estado_civil').text(c.estado_civil);
                            $('#detalle_nacionalidad').text(c.nacionalidad);
                            $('#detalle_lugar_trabajo').text(c.lugar_trabajo);

                            $('#detalle_ingresos_mensuales').text(formatCurrency(c.ingresos_mensuales));
                            $('#detalle_otros_ingresos').text(formatCurrency(c.otros_ingresos));
                            $('#detalle_descripcion').text(c.descripcion);
                            $('#detalle_ahorros').text(formatCurrency(response.ahorros || 0));
                            $('#detalle_prestamos').text(formatCurrency(response.prestamos || 0));

                            $('#detalle_sucursal').text(c.sucursal_nombre);
                            $('#detalle_compania').text(c.compania_nombre);

                            $('#modalDetalleCliente').modal('show');
                        }
                    })
                    .catch(() => Swal.fire('Error', 'No se pudo cargar el detalle del cliente.', 'error'));
            });

            //Obtener los datos del cliente para llenar el modal de editar
            $(document).on('click', '.btnEditar', function () {
                const id = $(this).data('id');
                fetch('/functions/clientes/get_cliente.php?id=' + id)
                    .then((r) => r.json())
                    .then((response) => {
                        if (response.error) {
                            Swal.fire('Error', response.error, 'error');
                        } else {
                            const c = response.cliente;
                            limpiarFormulario();

                            // Rellenar el formulario con los datos del cliente
                            $('#cliente_id').val(c.id);
                            $('#numero_socio').val(c.numero_socio);
                            $('#cedula').val(c.cedula);
                            $('#nombre').val(c.nombre);

                            const direccionParts = c.direccion.split(', ');
                            $('#direccion_linea1').val(direccionParts[0] || '');
                            $('#direccion_linea2').val(direccionParts[1] || '');
                            $('#provincia').val(direccionParts[2] || '');

                            $('#lugar_trabajo').val(c.lugar_trabajo);
                            $('#telefono1').val(c.telefono1);
                            $('#telefono2').val(c.telefono2);
                            $('#correo_personal').val(c.correo_personal);
                            $('#correo_institucional').val(c.correo_institucional);
                            $('#sucursal_id').val(c.sucursal_id);
                            $('#sexo').val(c.sexo);
                            $('#estado_civil').val(c.estado_civil);
                            $('#nacionalidad').val(c.nacionalidad);
                            $('#ingresos_mensuales').val(c.ingresos_mensuales);
                            $('#otros_ingresos').val(c.otros_ingresos);
                            $('#descripcion').val(c.descripcion);
                            $('#image_cedula').val(''); // Para no prellenar campos de archivo
                            $('#contrato').val('');

                            $('#modalClienteLabel').text('Editar Socio');
                            $('#modalCliente').modal('show');
                        }
                    })
                    .catch(() => {
                        Swal.fire('Error', 'No se pudo obtener la información del cliente.', 'error');
                    });
            });


            // Eliminar cliente
            $(document).on('click', '.btnEliminar', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Esta acción eliminará el cliente.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let fd = new FormData();
                        fd.append('id', id);

                        fetch('/functions/clientes/delete_cliente.php', {
                            method: 'POST',
                            body: fd
                        })
                        .then(r => r.json())
                        .then(response => {
                            if (response.success) {
                                Swal.fire('Eliminado', response.message, 'success');
                                location.reload();
                            } else {
                                Swal.fire('Error', response.message, 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Error', 'No se pudo eliminar el cliente.', 'error');
                        });
                    }
                });
            });
        });

        function limpiarFormulario() {
            $('#formCliente')[0].reset();
            $('#cliente_id').val('');
        }

        $(document).ready(function () {
            // Al cambiar la sucursal, actualiza la provincia
            $('#sucursal_id').on('change', function () {
                const sucursalId = $(this).val();

                if (sucursalId) {
                    $.ajax({
                        url: '/functions/get_provincia.php', // Ruta al archivo PHP que devuelve la provincia
                        type: 'GET',
                        data: { sucursal_id: sucursalId },
                        success: function (response) {
                            const data = JSON.parse(response);

                            if (data.success) {
                                $('#provincia').val(data.provincia); // Llena el campo de provincia
                            } else {
                                Swal.fire('Error', data.error, 'error');
                                $('#provincia').val(''); // Limpia el campo si hay error
                            }
                        },
                        error: function () {
                            Swal.fire('Error', 'No se pudo obtener la provincia.', 'error');
                            $('#provincia').val(''); // Limpia el campo en caso de error
                        }
                    });
                } else {
                    $('#provincia').val(''); // Limpia el campo si no se selecciona sucursal
                }
            });
        });

    </script>
    <script>
    // Manejar el clic del botón "¿Qué deseas ver?"
    $(document).on('click', '.btnVerOpciones', function () {
        const cedula = $(this).data('cedula');
        const contrato = $(this).data('contrato');

        // Almacenar datos en los botones del modal
        $('.btnVerCedula').data('cedula', cedula);
        $('.btnVerContrato').data('contrato', contrato);

        // Abrir modal
        $('#modalOpciones').modal('show');
    });

    // Mostrar la cédula
    $(document).on('click', '.btnVerCedula', function () {
        const cedula = $(this).data('cedula');

        if (cedula) {
            $('#cedulaImagen').attr('src', '/uploads/images/' + cedula);
            $('#modalCedula').modal('show');
            $('#modalOpciones').modal('hide');
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'No hay una cédula asociada a este cliente.',
                showConfirmButton: false,
                timer: 2200
            })
        }
    });

    // Descargar el contrato
    $(document).on('click', '.btnVerContrato', function () {
        const contrato = $(this).data('contrato');

        if (contrato) {
            window.location.href = '/uploads/files/' + contrato;
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'No hay un contrato asociado a este cliente.',
                showConfirmButton: false,
                timer: 2200
            })
        }
    });
</script>

</body>
</html>