const body = document.querySelector('body'),
      sidebar = body.querySelector('nav'),
      toggle = body.querySelector(".toggle"),
      //searchBtn = body.querySelector(".search-box"),
      modeSwitch = body.querySelector(".toggle-switch"),
      modeText = body.querySelector(".mode-text");


toggle.addEventListener("click" , () =>{
    sidebar.classList.toggle("close");
})

searchBtn.addEventListener("click" , () =>{
    sidebar.classList.remove("close");
})

modeSwitch.addEventListener("click" , () =>{
    body.classList.toggle("dark");
    
    if(body.classList.contains("dark")){
        modeText.innerText = "Light mode";
    }else{
        modeText.innerText = "Dark mode";
        
    }
});

/*$('#formEditarSucursal').on('submit', function (e) {
    e.preventDefault(); // Evitar el comportamiento predeterminado del formulario

    const formData = $(this).serialize(); // Captura los datos del formulario

    $.ajax({
        url: '/functions/edit_sucursal.php', // Archivo de procesamiento
        type: 'POST',
        data: formData,
        success: function (response) {
            const result = JSON.parse(response);

            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Cambios guardados!',
                    text: result.message,
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    //$('#modalEditarSucursal').modal('hide'); // Cerrar el modal
                    //$('#tablaSucursales').DataTable().ajax.reload(); // Recargar el DataTable
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.error,
                });
            }
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo procesar la solicitud.',
            });
        }
    });
}); */
