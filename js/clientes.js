 function openEditModal(cliente) {
    $('#edit_id').val(cliente.id);
    $('#edit_cedula').val(cliente.cedula);
    $('#edit_nombre').val(cliente.nombre);
    $('#edit_direccion').val(cliente.direccion);
    $('#edit_lugar_trabajo').val(cliente.lugar_trabajo);
    $('#edit_telefono1').val(cliente.telefono1);
    $('#edit_telefono2').val(cliente.telefono2);
    $('#edit_correo_personal').val(cliente.correo_personal);
    $('#edit_correo_institucional').val(cliente.correo_institucional);
    $('#editModal').modal('show');
}