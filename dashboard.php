<?php
    session_start();

    $role = $_SESSION['role'];

    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }
    
    include 'db.php';

    $sql = "SELECT COUNT(*) FROM usuarios";
    $result = $conn->query($sql); //conn es el objeto conexión
    $total = $result->fetchColumn();

    $sqli = "SELECT COUNT(*) FROM cliente";
    $results = $conn->query($sqli); //conn es el objeto conexión
    $totalcli = $results->fetchColumn();
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

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    
    <title>COOPLIGHT</title> 
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
                        <a href="#">
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
            Bienvenido(a) <Strong><?php echo htmlspecialchars($_SESSION['username']); ?></Strong> a COOPLIGHT
        </div>
        <br>
        <!-- ======================= Cards ================== -->
        <div class="cardBox">
            <?php if($role == 'admin' || $role == 'socio') { ?>
            <div class="card">
                <div>
                    <div class="numbers"><?php echo $total; ?></div>
                    <div class="cardName">Usuarios</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="person-circle-outline"></ion-icon>
                </div>
            </div>
            <?php } ?>
            <div class="card">
                <div>
                    <div class="numbers">$96,000</div>
                    <div class="cardName">Prestado</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="card-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div>
                    <div class="numbers"><?php echo $totalcli; ?></div>
                    <div class="cardName">Clientes</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="people-outline"></ion-icon>
                </div>
            </div>
    
            <div class="card">
                <div>
                    <div class="numbers">$7,842</div>
                    <div class="cardName">Ganancias</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="pricetags-outline"></ion-icon>
                </div>
            </div>
        </div>

        <!-- ================ Order Details List ================= -->
        <div class="details">
            <div class="recentOrders">
                <div class="cardHeader">
                    <h2>Prestamos</h2>
                    <a href="prestamos" class="btn">View All</a>
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
                        <tr>
                            <td>Star Link</td>
                            <td>$12,100</td>
                            <!-- <td>Due</td> -->
                            <td><span class="status delivered">Activo</span></td>
                        </tr>

                        <tr>
                            <td>Delio Arts</td>
                            <td>$11,500</td>
                            
                            <td><span class="status pending">Pendiente</span></td>
                        </tr>

                        <tr>
                            <td>Apolinar Lopez</td>
                            <td>$25,000</td>
                            
                            <td><span class="status return">Cancelado</span></td>
                        </tr>

                        <tr>
                            <td>Addi Shoe</td>
                            <td>$6,200</td>
                            
                            <td><span class="status delivered">Activo</span></td>
                        </tr>

                        <tr>
                            <td>Rosa Melano</td>
                            <td>$3,000</td>
                           
                            <td><span class="status delivered">Activo</span></td>
                        </tr>

                        <tr>
                            <td>Yokito Fokito</td>
                            <td>$8,000</td>
                            
                            <td><span class="status pending">Pendiente</span></td>
                        </tr>

                        <tr>
                            <td>Alma Marcela Gozo</td>
                            <td>$25,000</td>
                           
                            <td><span class="status return">Cancelado</span></td>
                        </tr>

                        <tr>
                            <td>Armando Esteban Quito</td>
                            <td>$10,000</td>
                           
                            <td><span class="status delivered">Activo</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- ================= New Customers ================ -->
            <div class="recentCustomers">
                <div class="cardHeader">
                    <h2>Clientes mas recientes</h2>
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