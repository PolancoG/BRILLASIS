<?php
    /* logout.php
    session_start();
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit(); */

    // logout.php
    require 'Auth.php';

    $auth = new Auth($conn);
    $auth->logout();

    header("Location: index");
    exit();

?>
