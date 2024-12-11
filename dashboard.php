<?php
    session_start();

    $role = $_SESSION['role'];

    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }
    
    include 'db.php';

    $sql = "SELECT SUM(monto) FROM ahorro";
    $result = $conn->query($sql); //conn es el objeto conexión
    $total = $result->fetchColumn();

    $sqli = "SELECT COUNT(*) FROM compania";
    $results = $conn->query($sqli); //conn es el objeto conexión
    $totalcli = $results->fetchColumn();

    $sqlp = "SELECT COUNT(*) FROM prestamo;";
    $resultp = $conn->query($sqlp); //conn es el objeto conexión
    $totalp = $resultp->fetchColumn();

    
    $sqlpr = "SELECT COUNT(*) FROM prestamo WHERE estado = 'activo_bien';";
    $resultpr = $conn->query($sqlpr); //conn es el objeto conexión
    $totalpr = $resultpr->fetchColumn();

    $sqlpr1 = "SELECT COUNT(*) FROM prestamo WHERE estado = 'activo_problemas';";
    $resultpr1 = $conn->query($sqlpr1); //conn es el objeto conexión
    $totalpr1 = $resultpr1->fetchColumn();

    $sqlcli = "SELECT COUNT(*) FROM cliente";
    $resultcli = $conn->query($sqlcli); //conn es el objeto conexión
    $totalClientes = $resultcli->fetchColumn();
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
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/logo.css">

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    
    <title>Bienvenido(a) a BRILLASIS</title> 
</head>
<body>
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
                        <a href="#">
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
                    <?php } ?>
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
            <img class="imglogo" src="imgs/logo.png" alt="image logo"> Bienvenido(a) <Strong><?php echo htmlspecialchars($_SESSION['username']); ?></Strong> a BRILLASIS
        </div>
        <br>
        <!-- ======================= Cards ================== -->
        <div class="cardBox">
            <div class="card">
                <div>
                    <div class="numbers"><?php echo $totalcli; ?></div>
                    <div class="cardName">Cantidad de empresas</div>
                </div>
                <div class="iconBx">
                   <!-- <ion-icon name="pricetags-outline"></ion-icon> -->
                   <i class='bx bx-building-house icon'></i>
                </div>
            </div>

            <div class="card">
                <div>
                    <div class="numbers"><?php echo "$" . number_format($total, 2, '.', ','); ?></div>
                    <div class="cardName">Total ahorrado</div>
                </div>
                <div class="iconBx">
                    <i class='bx bx-wallet'></i>
                </div>
            </div>

            <div class="card">
                <div>
                    <div class="numbers"><?php echo $totalp; ?></div>
                    <div class="cardName">Total de prestamos</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="cash-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div class="item">
                    <div class="number"><span class="badge"><?php echo $totalpr; ?></span></div>
                    <div class="cardName">Cant. de prestamos</div>
                </div>
                <br>
                <div class="vertical-line"></div>
                <br>
                <div class="item">
                    <div class="number"><span class="badge1"><?php echo $totalpr1; ?></span></div>
                    <div class="cardName">Cant. de prestamos</div>
                </div>

                <!-- <div class="iconBx">
                    <ion-icon name="cash-outline"></ion-icon>
                </div> -->
            </div>

            <div class="card">
                <div>
                    <div class="numbers"><?php echo $totalClientes; ?></div>
                    <div class="cardName">Cantidad de socios</div>
                </div>
                <div class="iconBx">
                   <!-- <ion-icon name="pricetags-outline"></ion-icon> -->
                   <ion-icon name="people-outline"></ion-icon>
                </div>
            </div>
    
        </div>

        <!-- ================ Order Details List ================= -->
        <div class="details">
            <div class="recentOrders">
                <div class="cardHeader">
                    <h2>Prestamos</h2>
                    <?php if($role == 'admin' || $role == 'cajerop') { ?>
                      <a href="prestamos" class="btn">Ver todos</a>
                    <?php } ?>
                </div>

                <table>
                    <thead>
                        <tr>
                            <td>Nombre del cliente</td>
                            <td>Valor del prestamo</td>
                           <!-- <td>Payment</td> -->
                            <td>Estado</td>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            require 'db.php';
                            // Consulta con unión para obtener información del cliente
                            $stmt = $conn->query("SELECT prestamo.id, cliente.nombre AS cliente_nombre, prestamo.monto, prestamo.interes, prestamo.plazo, prestamo.estado
                                                FROM prestamo
                                                JOIN cliente ON prestamo.cliente_id = cliente.id");
                            while ($prestamo = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $estadoClase = '';
                                if ($prestamo['estado'] == 'activo_bien') $estadoClase = 'status delivered';
                                elseif ($prestamo['estado'] == 'activo_problemas') $estadoClase = 'status pending';
                                elseif ($prestamo['estado'] == 'pendiente') $estadoClase = 'status pending';
                                elseif ($prestamo['estado'] == 'cancelado') $estadoClase = 'status return';

                                echo "<tr>";
                                echo "<td>" . $prestamo['cliente_nombre'] . "</td>";
                                //echo "<td> $" . $prestamo['monto'] . "</td>";
                                echo "<td> RD$" . number_format($prestamo['monto'], 2, '.', ',') . "</td>";
                                echo "<td><span class='$estadoClase'>" . ucfirst($prestamo['estado']). "</span></td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- ================= New Customers ================ -->
            <div class="recentCustomers">
                <div class="cardHeader">
                    <h2>Recientes</h2>
                </div>

                <table>
                    <tr>
                        <td width="60px">
                            <div class="imgBx"><img src="assets/imgs/customer02.jpg" alt=""></div>
                        </td>
                        <td>
                            <h4>David <br> <span>Italy</span></h4>
                        </td>
                    </tr>

                    <tr>
                        <td width="60px">
                            <div class="imgBx"><img src="assets/imgs/customer01.jpg" alt=""></div>
                        </td>
                        <td>
                            <h4>Amit <br> <span>India</span></h4>
                        </td>
                    </tr>

                    <tr>
                        <td width="60px">
                            <div class="imgBx"><img src="assets/imgs/customer02.jpg" alt=""></div>
                        </td>
                        <td>
                            <h4>David <br> <span>Italy</span></h4>
                        </td>
                    </tr>

                    <tr>
                        <td width="60px">
                            <div class="imgBx"><img src="assets/imgs/customer01.jpg" alt=""></div>
                        </td>
                        <td>
                            <h4>Amit <br> <span>India</span></h4>
                        </td>
                    </tr>

                    <tr>
                        <td width="60px">
                            <div class="imgBx"><img src="assets/imgs/customer02.jpg" alt=""></div>
                        </td>
                        <td>
                            <h4>David <br> <span>Italy</span></h4>
                        </td>
                    </tr>

                    <tr>
                        <td width="60px">
                            <div class="imgBx"><img src="assets/imgs/customer01.jpg" alt=""></div>
                        </td>
                        <td>
                            <h4>Amit <br> <span>India</span></h4>
                        </td>
                    </tr>

                    <tr>
                        <td width="60px">
                            <div class="imgBx"><img src="assets/imgs/customer01.jpg" alt=""></div>
                        </td>
                        <td>
                            <h4>David <br> <span>Italy</span></h4>
                        </td>
                    </tr>

                    <tr>
                        <td width="60px">
                            <div class="imgBx"><img src="assets/imgs/customer02.jpg" alt=""></div>
                        </td>
                        <td>
                            <h4>Amit <br> <span>India</span></h4>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </section>

    <script src="js/script.js"></script>
    <script src="assets/js/main.js"></script>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>