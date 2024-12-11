<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <!----======== CSS ======== -->
     <link rel="stylesheet" href="css/style.css">
     <link rel="stylesheet" href="css/prestamos.css">
    <link rel="stylesheet" href="css/cards.css">
    <link rel="shortcut icon" href="imgs/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/main.css">

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

    <title>BRILLASIS calculadora</title>
</head>
<body>
            <br>
            <button class="btn btn-primary"><a href="prestamos" style="text-decoration: none; color: #fff;">Regresar a prestamos</a></button>
            <!-- ===========  Tabla de amortizacion ============ -->
            <div id="contenedor" class="mx-aut" style="max-width: 600px; min-height: auto;">
                <div class="header">
                    <h2>Calculo de tabla de amortizacion</h2>
                </div>
                <div name="frmPrestamo" id="frmPrestamo">
                    <div class="control">
                        <label for="nombre">Nombre: <input type="text" name="nombre" id="nombre" placeholder="nombre" style=" border: 2px solid #050404;"></label>
                    </div>
                    <div class="control">
                        <label for="fecha">Fecha: <input type="date" name="fecha" id="fecha" placeholder="fecha" style=" border: 2px solid #050404;"></label>
                    </div> 
                    <div class="control">
                        <label for="monto">Monto: <input type="number" name="monto" id="monto" placeholder="monto" min="500" step="500" style=" border: 2px solid #050404;"></label>
                    </div>
                    <div class="control">
                        <label for="periodo">Periodo de pago:
                            <select name="periodo" id="periodo" style=" border: 2px solid #050404;">
                                <option value="semanal">semanal</option>
                                <option value="quincenal">quincenal</option>
                                <option value="mensual">mensual</option>
                            </select>
                        </label>
                    </div>
                    <div class="control">
                        <label for="interes">Interés (anual): <input type="number" name="interes" id="interes" placeholder="interés" min="5" max="100" step=".01" style=" border: 2px solid #050404;"></label>
                    </div>
                    <div class="control">
                        <label for="plazo">Plazo:
                            <div class="radios">
                                <label for="mensual" class="radioContenedor">Mensual
                                    <input type="radio" name="tipoPlazo" id="mensual" value="mensual" style=" border: 2px solid #050404;">
                                    <span class="circle"></span>
                                </label>
                                <label for="anual" class="radioContenedor">Anual
                                    <input type="radio" name="tipoPlazo" id="anual" value="anual" style=" border: 2px solid #050404;">
                                    <span class="circle"></span>
                                </label>
                            </div>
                            <input type="number" name="plazo" id="plazo" min="1" max="12" step="1" style=" border: 2px solid #050404;">
                        </label>
                    </div>
                    <button id="simular" onclick="simularPrestamo()">Calcular</button>
                </div>
            </div>
            
            <div id="contenedorTabla">
                <div class="header">
                    <h2>Tabla de amortizaciones</h2>
                </div>
            <div id="amortizaciones"></div>   
            </div>
            <!-- ===========    Hasta aqui Tabla de amortizacion =========== -->
    </div>
    <script src="js/prestamos.js"></script>
    <script src="js/script.js"></script>
    <script src="assets/js/main.js"></script>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>