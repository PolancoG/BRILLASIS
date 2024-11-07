<?php
    session_start();
    //Pass para admin: admin123 y user1234 para cajero. 
?>
<!doctype html>
<html lang="en">
  <head>
  	<title>Inicio de sesion</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="shortcut icon" href="imgs/logo.png" type="image/x-icon">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="css/index.css">

	</head>
	<body>
		<section class="ftco-section">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-6 col-lg-5">
						<div class="login-wrap p-4 p-md-5">
                            <div class="icon d-flex align-items-center justify-content-center"> 
                                <span class="fa fa-user"></span> 
                            </div>
                            <h3 class="text-center mb-4">Inicio de sesion</h3>
                            <form action="auth_login.php" method="POST" class="login-form">
                                <div class="form-group">
                                    <input type="text" id="typeEmailX-2" class="form-control rounded-left" name="username" placeholder="Digite el Usuario" required>
                                </div>
                                <div class="form-group d-flex">
                                    <input type="password" id="typePasswordX-2" class="form-control rounded-left" name="password" placeholder="Digite la Contraseña" required>
                                </div>
                                <div class="form-group d-md-flex">
                                <!-- <div class="w-50">
                                    <label class="checkbox-wrap checkbox-primary">Remember Me
                                                <input type="checkbox" checked>
                                                <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="w-50 text-md-right">
                                                <a href="#">Forgot Password</a>
                                            </div> -->
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn hover btn-primary rounded submit p-3 px-5">Iniciar Sesión</button>
                                </div>
                            </form>
                        </div>
					</div>
				</div>
			</div>
		</section>
	</body>
</html>

