<?php
    if (isset($_SESSION['mensaje'])) {
        $mensaje = $_SESSION['mensaje']['texto'];
        $tipo = $_SESSION['mensaje']['tipo'];
        echo "<script>
                Swal.fire({
                    icon: '$tipo',
                    title: '$mensaje',
                    confirmButtonText: 'OK'
                });
            </script>";
        unset($_SESSION['mensaje']); // Limpiar el mensaje después de mostrarlo
    }
?>