function editarAhorro(button) {
  var id = $(button).data('id');

  // Llamada AJAX a get_ahorro.php para obtener los datos del ahorro
  $.ajax({
      url: '../functions/get_ahorro.php',
      type: 'GET',
      data: { id: id },
      //dataType: 'json',
      success: function(response) {
          var ahorro = JSON.parse(response);
          if (response.error) {
              Swal.fire('Error', response.error, 'error');
          } else {
              // Llenar el formulario del modal con los datos recibidos
              $('#edit_id').val(ahorro.id);
              $('#edit_cliente_id').val(ahorro.cliente_id);
              $('#edit_monto').val(ahorro.monto);
              $('#edit_fecha').val(ahorro.fecha);

              // Abrir el modal de edición
              $('#modalEditarAhorro').modal('show');
          }
      },
      error: function() {
          Swal.fire('Error', 'Error al intentar obtener los datos.', 'error');
      }
  });
} 

// Confirmación de eliminación
function eliminarAhorro(id) {
  Swal.fire({
      title: "¿Estás seguro?",
      text: "¡Este ahorro será eliminado permanentemente!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Eliminar"
  }).then((result) => {
      if (result.isConfirmed) {
          window.location.href = "./functions/delete_ahorro.php?id=" + id;
      }
  });
}