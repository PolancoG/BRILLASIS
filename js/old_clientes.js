
//$('#ingreso_mensual').mask('RD$000,000,000,000,000');
$(function(){
    $('#cedula').mask('000-0000000-0');
    $('#telefono1').mask('(000)-000-0000');
    $('#telefono2').mask('(000)-000-0000');
}); 

//  function openEditModal(cliente) {
//     $('#edit_id').val(cliente.id);
//     $('#edit_numero_socio').val(cliente.numero_socio);
//     $('#edit_cedula').val(cliente.cedula);
//     $('#edit_nombre').val(cliente.nombre);
//     $('#edit_direccion').val(cliente.direccion);
//     $('#edit_lugar_trabajo').val(cliente.lugar_trabajo);
//     $('#edit_telefono1').val(cliente.telefono1);
//     $('#edit_telefono2').val(cliente.telefono2);
//     $('#edit_correo_personal').val(cliente.correo_personal);
//     $('#edit_correo_institucional').val(cliente.correo_institucional);
//     $('#editModal').modal('show');
// }

//Cargar los datos del cliente
function cargarDatosCliente(clienteId) {
    $.ajax({
        url: '/functions/clientes/get_clientes.php',
        method: 'GET',
        data: { id: clienteId },
        dataType: 'json',
        success: function (data) {
            if (data.error) {
                Swal.fire('Error', data.error, 'error');
                return;
            }

            // Cargar datos en el modal
            $('#clienteModal #id').val(data.id);
            $('#clienteModal #numero_socio').val(data.numero_socio);
            $('#clienteModal #cedula').val(data.cedula);
            $('#clienteModal #nombre').val(data.nombre);
            $('#clienteModal #direccion').val(data.direccion);
            $('#clienteModal #lugar_trabajo').val(data.lugar_trabajo);
            $('#clienteModal #telefono1').val(data.telefono1);
            $('#clienteModal #telefono2').val(data.telefono2);
            $('#clienteModal #correo_personal').val(data.correo_personal);
            $('#clienteModal #correo_institucional').val(data.correo_institucional);
            $('#clienteModal #sucursal_id').val(data.sucursal_id);
            $('#clienteModal #sexo').val(data.sexo);
            $('#clienteModal #estado_civil').val(data.estado_civil);
            $('#clienteModal #nacionalidad').val(data.nacionalidad);
            $('#clienteModal #ingresos_mensuales').val(data.ingresos_mensuales);
            $('#clienteModal #otros_ingresos').val(data.otros_ingresos);

            // Mostrar modal
            $('#clienteModal').modal('show');
        },
        error: function () {
            Swal.fire('Error', 'No se pudo cargar la información del cliente.', 'error');
        }
    });
}

//Para cargar los datos de los familiares en el modal de ditar
function cargarDatosFamiliares(clienteId) {
    $.ajax({
        url: '/functions/clientes/get_familiares.php',
        method: 'GET',
        data: { cliente_id: clienteId },
        dataType: 'json',
        success: function (data) {
            if (data.error) {
                Swal.fire('Error', data.error, 'error');
                return;
            }

            // Limpiar contenedor antes de cargar datos
            $('#familiaModal #familia-container').html('');

            // Iterar sobre familiares y añadir al contenedor
            data.forEach(function (familiar, index) {
                let familiaFields = `
                    <div class="form-row familia-item" id="familia-${index}">
                        <div class="form-group col-md-2">
                            <label for="familia_cedula_${index}">Cédula</label>
                            <input type="text" class="form-control" name="familia[${index}][cedula]" id="familia_cedula_${index}" value="${familiar.cedula}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="familia_nombre_${index}">Nombre</label>
                            <input type="text" class="form-control" name="familia[${index}][nombre]" id="familia_nombre_${index}" value="${familiar.nombre}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="familia_relacion_${index}">Relación</label>
                            <input type="text" class="form-control" name="familia[${index}][relacion]" id="familia_relacion_${index}" value="${familiar.relacion}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="familia_telefono_${index}">Teléfono</label>
                            <input type="text" class="form-control" name="familia[${index}][telefono]" id="familia_telefono_${index}" value="${familiar.telefono}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="familia_correo_${index}">Correo</label>
                            <input type="email" class="form-control" name="familia[${index}][correo]" id="familia_correo_${index}" value="${familiar.correo_electronico}">
                        </div>
                    </div>
                `;
                $('#familiaModal #familia-container').append(familiaFields);
            });

            // Mostrar modal
            $('#familiaModal').modal('show');
        },
        error: function () {
            Swal.fire('Error', 'No se pudo cargar la información familiar.', 'error');
        }
    });
}

//Eliminar cliente
$(document).on('click', '.btnEliminar', function () { //btnEliminarCliente
    let clienteId = $(this).data('id');

    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará al cliente y todos sus datos relacionados.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            eliminarCliente(clienteId);
        }
    });
});

function eliminarCliente(clienteId) {
    $.ajax({
        url: '/functions/clientes/delete_cliente.php',
        method: 'POST',
        data: { id: clienteId },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                Swal.fire('Eliminado', 'El cliente ha sido eliminado correctamente.', 'success');
                $('#tablaClientes').DataTable().ajax.reload(); // Recargar el datatable
            } else {
                Swal.fire('Error', response.error || 'No se pudo eliminar el cliente.', 'error');
            }
        },
        error: function () {
            Swal.fire('Error', 'Ocurrió un problema al intentar eliminar el cliente.', 'error');
        }
    });
}


document.addEventListener("DOMContentLoaded", function () {
    let familiaContainer = document.getElementById("familia-container");
    let addFamiliaBtn = document.getElementById("add-familia-btn");

    // Contador para identificar dinámicamente a cada familiar
    let familiaIndex = 0;

    // Función para agregar un nuevo conjunto de campos para un familiar
    addFamiliaBtn.addEventListener("click", function () {
        familiaIndex++;

        let familiaFields = `
            <div class="form-row familia-item" id="familia-${familiaIndex}">
                <div class="form-group col-md-2">
                    <label for="familia_cedula_${familiaIndex}">Cédula</label>
                    <input type="text" class="form-control" name="familia[${familiaIndex}][cedula]" id="familia_cedula_${familiaIndex}" placeholder="Cédula">
                </div>
                <div class="form-group col-md-3">
                    <label for="familia_nombre_${familiaIndex}">Nombre</label>
                    <input type="text" class="form-control" name="familia[${familiaIndex}][nombre]" id="familia_nombre_${familiaIndex}" placeholder="Nombre">
                </div>
                <div class="form-group col-md-2">
                    <label for="familia_relacion_${familiaIndex}">Relación</label>
                    <input type="text" class="form-control" name="familia[${familiaIndex}][relacion]" id="familia_relacion_${familiaIndex}" placeholder="Relación">
                </div>
                <div class="form-group col-md-2">
                    <label for="familia_telefono_${familiaIndex}">Teléfono</label>
                    <input type="text" class="form-control" name="familia[${familiaIndex}][telefono]" id="familia_telefono_${familiaIndex}" placeholder="Teléfono">
                </div>
                <div class="form-group col-md-2">
                    <label for="familia_correo_${familiaIndex}">Correo</label>
                    <input type="email" class="form-control" name="familia[${familiaIndex}][correo]" id="familia_correo_${familiaIndex}" placeholder="Correo">
                </div>
                <div class="form-group col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm remove-familia-btn" data-id="${familiaIndex}">Eliminar</button>
                </div>
            </div>
        `;

        familiaContainer.insertAdjacentHTML("beforeend", familiaFields);

        // Añadir evento al botón de eliminar
        familiaContainer.querySelector(`#familia-${familiaIndex} .remove-familia-btn`).addEventListener("click", function () {
            let id = this.getAttribute("data-id");
            let familiaItem = document.getElementById(`familia-${id}`);
            familiaItem.remove();
        });
    });
});

$(document).ready(function () {
    $('#modalCliente').on('show.bs.modal', function () {
        // Limpiar opciones anteriores
        $('#sucursal_id').empty().append('<option value="" selected disabled>Seleccione una sucursal</option>');

        // Cargar opciones desde el backend
        $.ajax({
            url: '/functions/clientes/get_sucursales.php',
            method: 'GET',
            success: function (response) {
                const sucursales = JSON.parse(response);
                sucursales.forEach(sucursal => {
                    $('#sucursal_id').append(`<option value="${sucursal.id}">${sucursal.nombre}</option>`);
                });
            },
            error: function () {
                Swal.fire('Error', 'No se pudieron cargar las sucursales', 'error');
            }
        });
    });
});


// //Carga los datos en el datatable
// $(document).ready(function () {
//     let tableClientes = $('#tablaClientes').DataTable({
//         ajax: {
//             url: '/functions/clientes/get_cliente.php',
//             method: 'GET',
//             dataSrc: '',
//         },
//         columns: [
//             { data: 'id' },
//             { data: 'numero_socio' },
//             { data: 'cedula' },
//             { data: 'nombre' },
//             { data: 'telefono1' },
//             { data: 'correo_personal' },
//             { data: 'sucursal_nombre' }, // Nombre de la sucursal (obtenido con JOIN)
//             {
//                 data: null,
//                 render: function (data, type, row) {
//                     return `
//                         <button class="btn btn-info btn-sm btnEditarCliente" data-id="${row.id}">Editar</button>
//                         <button class="btn btn-danger btn-sm btnEliminarCliente" data-id="${row.id}">Eliminar</button>
//                     `;
//                 }
//             },
//         ],
//         language: {
//             url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json',
//         }
//     });

//     // Recargar la tabla después de ciertas acciones
//     function recargarTabla() {
//         tableClientes.ajax.reload();
//     }
// });

//Script para mostrar la alerta y elegir que es lo que se va a editar
$(document).on('click', '.btnEditar', function () {
    let clienteId = $(this).data('id');

    // Mostrar SweetAlert2 con las opciones
    Swal.fire({
        title: '¿Qué desea editar?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Editar Cliente',
        denyButtonText: 'Editar Familiares/Beneficiario',
    }).then((result) => {
        if (result.isConfirmed) {
            // Cargar modal para editar cliente
            cargarDatosCliente(clienteId);
        } else if (result.isDenied) {
            // Cargar modal para editar familiares/beneficiario
            cargarDatosFamiliares(clienteId);
        }
    });
});

$(document).on('click', '.btnDetalles', function () {
    let clienteId = $(this).data('id');

    $.ajax({
        url: '/functions/clientes/get_cliente.php',
        method: 'GET',
        data: { id: clienteId },
        dataType: 'json',
        success: function (response) {
            if (response.error) {
                Swal.fire('Error', response.error, 'error');
            } else {
                // Llenar los datos del cliente en el modal
                $('#detalleNombre').text(response.cliente.nombre);
                $('#detalleCedula').text(response.cliente.cedula);
                $('#detalleDireccion').text(response.cliente.direccion);
                $('#detalleLugarTrabajo').text(response.cliente.lugar_trabajo);
                $('#detalleTelefono1').text(response.cliente.telefono1);
                $('#detalleTelefono2').text(response.cliente.telefono2);
                $('#detalleCorreoPersonal').text(response.cliente.correo_personal);
                $('#detalleCorreoInstitucional').text(response.cliente.correo_institucional);
                $('#detalleSucursal').text(response.cliente.sucursal_nombre);
                $('#detalleCompania').text(response.cliente.compania_nombre);
                $('#detalleSexo').text(response.cliente.sexo);
                $('#detalleEstadoCivil').text(response.cliente.estado_civil);
                $('#detalleNacionalidad').text(response.cliente.nacionalidad);
                $('#detalleIngresos').text(response.cliente.ingresos_mensuales);
                $('#detalleOtrosIngresos').text(response.cliente.otros_ingresos);

                // Llenar tabla de familiares
                let familiaresHtml = '';
                response.familiares.forEach(familiar => {
                    familiaresHtml += `
                        <tr>
                            <td>${familiar.nombre}</td>
                            <td>${familiar.relacion}</td>
                            <td>${familiar.telefono}</td>
                            <td>${familiar.correo_electronico}</td>
                            <td>${familiar.nombre_hijos || 'N/A'}</td>
                        </tr>
                    `;
                });
                $('#tablaFamiliares tbody').html(familiaresHtml);

                // Llenar tabla de beneficiarios
                let beneficiariosHtml = '';
                response.beneficiarios.forEach(beneficiario => {
                    beneficiariosHtml += `
                        <tr>
                            <td>${beneficiario.nombre_completo}</td>
                            <td>${beneficiario.cedula}</td>
                            <td>${beneficiario.parentesco}</td>
                        </tr>
                    `;
                });
                $('#tablaBeneficiarios tbody').html(beneficiariosHtml);

                // Mostrar el modal de detalles
                $('#modalDetallesCliente').modal('show');
            }
        },
        error: function () {
            Swal.fire('Error', 'Ocurrió un problema al obtener los datos del cliente.', 'error');
        }
    });
});


function cargarDetallesCliente(idCliente) {
    $.ajax({
        url: '/functions/clientes/get_detalles_cliente.php', // Archivo PHP que devuelve los detalles del cliente
        type: 'GET',
        data: { id: idCliente },
        success: function(response) {
            var cliente = JSON.parse(response);
            
            if (cliente) {
                // Cargar datos generales del cliente
                $('#cliente_nombre').text(cliente.nombre);
                $('#cliente_cedula').text(cliente.cedula);
                $('#cliente_direccion').text(cliente.direccion);
                $('#cliente_lugar_trabajo').text(cliente.lugar_trabajo);
                $('#cliente_telefono1').text(cliente.telefono1);
                $('#cliente_telefono2').text(cliente.telefono2);
                $('#cliente_correo_personal').text(cliente.correo_personal);
                $('#cliente_correo_institucional').text(cliente.correo_institucional);

                // Cargar familiares
                $('#familiares_lista').empty();
                cliente.familiares.forEach(function(familiar) {
                    $('#familiares_lista').append('<li>' + familiar.nombre + ' (' + familiar.relacion + ') - Tel: ' + familiar.telefono + '</li>');
                });

                // Cargar información financiera
                $('#total_ahorros').text(cliente.ahorros.total);
                $('#total_prestamos').text(cliente.prestamos.total);
                $('#balance_actual').text(cliente.balance_actual);

                // Cargar sucursal y compañía
                $('#sucursal_nombre').text(cliente.sucursal.nombre);
                $('#compania_nombre').text(cliente.compania.nombre);
            } else {
                alert('No se encontraron los detalles del cliente.');
            }
        },
        error: function() {
            alert('Hubo un error al cargar los detalles.');
        }
    });
}

//Funcion para cargar los datos del modal de edicion
function cargarDatosClienteParaEdicion(idCliente) {
    $.ajax({
        url: '/functions/clientes/get_cliente.php', // El archivo PHP que obtiene los datos del cliente
        type: 'GET',
        data: { id: idCliente },
        success: function(response) {
            var cliente = JSON.parse(response);

            if (cliente) {
                // Cargar los datos del cliente en el formulario de edición
                $('#editar_nombre').val(cliente.nombre);
                $('#editar_cedula').val(cliente.cedula);
                $('#editar_direccion').val(cliente.direccion);
                $('#editar_lugar_trabajo').val(cliente.lugar_trabajo);
                $('#editar_telefono1').val(cliente.telefono1);
                $('#editar_telefono2').val(cliente.telefono2);
                $('#editar_correo_personal').val(cliente.correo_personal);
                $('#editar_correo_institucional').val(cliente.correo_institucional);
                $('#editar_ingresos_mensuales').val(cliente.ingresos_mensuales);
                $('#editar_otros_ingresos').val(cliente.otros_ingresos);

                // Establecer valores de sucursal, sexo y estado civil
                $('#editar_sucursal_id').val(cliente.sucursal_id);
                $('#editar_sexo').val(cliente.sexo);
                $('#editar_estado_civil').val(cliente.estado_civil);

                // Cargar la lista de sucursales (si es necesario)
                cargarSucursales(cliente.sucursal_id); // Función para cargar las opciones de sucursal
            }
        },
        error: function() {
            alert('Error al cargar los datos del cliente.');
        }
    });
}

// Función para cargar las sucursales en el formulario
function cargarSucursales(sucursal_id) {
    $.ajax({
        url: '/functions/clientes/get_sucursales.php', // El archivo PHP que obtiene las sucursales
        type: 'GET',
        success: function(response) {
            var sucursales = JSON.parse(response);
            $('#editar_sucursal_id').empty(); // Limpiar opciones existentes
            sucursales.forEach(function(sucursal) {
                $('#editar_sucursal_id').append('<option value="' + sucursal.id + '" ' + (sucursal.id === sucursal_id ? 'selected' : '') + '>' + sucursal.nombre + '</option>');
            });
        },
        error: function() {
            alert('Error al cargar las sucursales.');
        }
    });
}

// Lógica para manejar los botones de editar cliente o editar familiares
$('#editarCliente').click(function() {
    // Guardar los cambios del cliente
    editarCliente();
});

$('#editarFamiliares').click(function() {
    // Abrir otro modal para editar familiares
    $('#modalEditarFamiliares').modal('show');
});


function editarCliente() {
    var formData = $('#formEditarCliente').serialize(); // Obtener todos los datos del formulario

    $.ajax({
        url: '/functions/clientes/editar_cliente.php', // Archivo PHP para actualizar los datos del cliente
        type: 'POST',
        data: formData,
        success: function(response) {
            var result = JSON.parse(response);

            if (result.success) {
                // Si la edición es exitosa, mostrar la alerta y actualizar el DataTable
                Swal.fire('Éxito', 'El cliente ha sido actualizado.', 'success');
                $('#modalEditarCliente').modal('hide');
                cargarTablaClientes(); // Recargar la tabla de clientes
            } else {
                Swal.fire('Error', 'Hubo un problema al actualizar el cliente.', 'error');
            }
        },
        error: function() {
            Swal.fire('Error', 'Error en la conexión al servidor.', 'error');
        }
    });
}


// Función para cargar los familiares y beneficiarios en el modal
function cargarDatosFamiliares(idCliente) {
    $.ajax({
        url: '/functions/clientes/get_familiares.php', // Archivo PHP que obtiene los familiares de un cliente
        type: 'GET',
        data: { cliente_id: idCliente },
        success: function(response) {
            var familiares = JSON.parse(response);

            if (familiares && familiares.length > 0) {
                // Solo cargamos el primer familiar (se puede extender para más familiares si es necesario)
                $('#editar_familiar_cedula').val(familiares[0].cedula);
                $('#editar_familiar_nombre').val(familiares[0].nombre);
                $('#editar_familiar_relacion').val(familiares[0].relacion);
                $('#editar_familiar_telefono').val(familiares[0].telefono);
                $('#editar_familiar_correo').val(familiares[0].correo_electronico);
                $('#editar_familiar_nombre_hijos').val(familiares[0].nombre_hijos);
            }
        },
        error: function() {
            alert('Error al cargar los datos familiares.');
        }
    });
}

//Funcion para guardar los datos de los familiares
$('#guardarFamiliares').click(function() {
    var formData = $('#formEditarFamiliares').serialize(); // Obtener todos los datos del formulario

    $.ajax({
        url: '/functions/clientes/editar_familiares.php', // Archivo PHP para actualizar los datos de los familiares
        type: 'POST',
        data: formData,
        success: function(response) {
            var result = JSON.parse(response);

            if (result.success) {
                Swal.fire('Éxito', 'Los datos familiares han sido actualizados.', 'success');
                $('#modalEditarFamiliares').modal('hide');
                cargarTablaClientes(); // Recargar la tabla de clientes
            } else {
                Swal.fire('Error', 'Hubo un problema al actualizar los datos familiares.', 'error');
            }
        },
        error: function() {
            Swal.fire('Error', 'Error en la conexión al servidor.', 'error');
        }
    });
});

//Lógica para Botón de Edición en el Datatable del Cliente
$('#tablaClientes tbody').on('click', '.btnEditar', function() {
    var clienteId = $(this).data('id');
    Swal.fire({
        title: '¿Qué deseas editar?',
        text: 'Selecciona lo que deseas modificar',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Editar Cliente',
        cancelButtonText: 'Editar Familiares',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            cargarDatosClienteParaEdicion(clienteId);
            $('#modalEditarCliente').modal('show');
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            cargarDatosFamiliares(clienteId);
            $('#modalEditarFamiliares').modal('show');
        }
    });
});

$(document).on('click', '.btnDetalles', function() {
    const cliente_id = $(this).data('id'); // Obtener el ID del cliente

    if (!cliente_id) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'ID de cliente no especificado.'
        });
        return;
    }

    $.ajax({
        url: '/functions/clientes/get_familiares.php',
        type: 'GET',
        data: { cliente_id: cliente_id },
        success: function(response) {
            const datos = JSON.parse(response);

            if (datos.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: datos.error
                });
            } else {
                // Cargar los datos en el modal de detalles
                let detallesHTML = '';
                datos.forEach(familiar => {
                    detallesHTML += `
                        <tr>
                            <td>${familiar.nombre}</td>
                            <td>${familiar.relacion}</td>
                            <td>${familiar.telefono}</td>
                            <td>${familiar.correo_electronico}</td>
                        </tr>`;
                });

                $('#tablaFamiliares tbody').html(detallesHTML);
                $('#modalDetallesCliente').modal('show');
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al obtener los datos del cliente.'
            });
        }
    });
});


$('#formCliente').on('submit', function(e) {
    e.preventDefault(); // Evita que la página se recargue

    let formData = $(this).serialize(); // Serializa los datos del formulario

    $.ajax({
        url: '/functions/clientes/add_cliente.php', // Archivo PHP que procesará los datos
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                Swal.fire('Éxito', response.message, 'success');
                $('#modalAgregarCliente').modal('hide'); // Cierra el modal
                $('#tablaClientes').DataTable().ajax.reload(); // Recarga el DataTable
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        },
        error: function() {
            Swal.fire('Error', 'No se pudo procesar la solicitud.', 'error');
        }
    });
});
