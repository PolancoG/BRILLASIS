function cargarOpcionesCompania(selectId, selectedId = null) {
    $.ajax({
        url: '/functions/get_compania.php',
        type: 'GET',
        success: function (response) {
            const companias = JSON.parse(response);
            const select = $(`#${selectId}`);
            select.empty();

            companias.forEach(compania => {
                const selected = compania.id === selectedId ? 'selected' : '';
                select.append(`<option value="${compania.id}" ${selected}>${compania.nombre}</option>`);
            });
        },
        error: function () {
            Swal.fire('Error', 'No se pudieron cargar las compañías.', 'error');
        }
    });
}

