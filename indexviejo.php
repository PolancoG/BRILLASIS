<?php
    session_start();
    //Pass para admin: admin123 y user1234 para cajero.
?>
<?php
    // Genera contraseñas cifradas para el usuario admin y user
    //$adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
    //$userPassword = password_hash('user123', PASSWORD_DEFAULT);

    //echo "Contraseña cifrada para admin: $adminPassword\n";
    //echo "Contraseña cifrada para user: $userPassword\n";
?>

<!-- login.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <!--<link rel="stylesheet" href="css/style.css">-->
    <link rel="shortcut icon" href="imgs/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <section class="vh-100" style="background-color: #84a4f9;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-2-strong" style="border-radius: 2rem;">
                <div class="card-body p-5 text-center">

                    <h3 class="mb-5">Inicio de Sesión</h3>
                    <hr class="my-4">
                    <form action="auth_login.php" method="POST">
                        <div data-mdb-input-init class="form-outline mb-4">
                           <!-- <label class="form-label" for="username">Usuario</label> -->
                            <input type="text" id="typeEmailX-2" class="form-control form-control-lg" style="border-color: #8d8d8d" name="username" required  placeholder="Usuario:"/>
                        </div>
 
                        <div data-mdb-input-init class="form-outline mb-4">
                           <!-- <label class="form-label" for="password">Contraseña:</label> -->
                            <input type="password" id="typePasswordX-2" class="form-control form-control-lg" 
                            style="border-color: #8d8d8d" name="password" required placeholder="Contraseña:"/>
                        </div>

                        <!-- Checkbox 
                        <div class="form-check d-flex justify-content-start mb-4">
                            <input class="form-check-input" type="checkbox" value="" id="form1Example3" />
                            <label class="form-check-label" for="form1Example3"> Remember password </label>
                        </div>   -->

                        <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block" type="submit">Iniciar Sesión</button>

                    </form>
                </div>
                </div>
            </div>
            </div>
        </div>
    </section>
   <!-- <h2>Iniciar Sesión</h2>
    <?php //if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form action="auth_login.php" method="POST">
        <label for="username">Usuario:</label>
        <input type="text" name="username" required><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Iniciar Sesión</button>
    </form> -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
