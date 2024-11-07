<?php
// auth_login.php
require 'Auth.php';

$auth = new Auth($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($auth->login($username, $password)) {
        header("Location: Dashboard");
        exit();
    } else {
        //echo "Usuario o contraseña incorrectos.";
        $var = "Usuario o clave incorrectos!";
        echo "  <script> 
                    alert('".$var."'); 
                    window.location='index?'
                </script>";
    }
}
?>
