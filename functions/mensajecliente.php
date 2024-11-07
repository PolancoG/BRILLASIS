<?php
    if (isset($_SESSION['mensaje'])) {
        $mensaje = $_SESSION['mensaje']['texto'];
        $tipo = $_SESSION['mensaje']['tipo'];
        echo "<script>
            Swal.fire({
                icon: '$tipo',
                title: '$mensaje',
                showConfirmButton: false,
                timer: 2000
            });
        </script>";
        unset($_SESSION['mensaje']); // confirmButtonText: 'OK' Limpiar el mensaje después de mostrarlo
    }
?>