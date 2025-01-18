<!-- Modal Agregar Compañía -->
<div class="modal fade" id="modalAgregarCompania" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="formAgregarCompania">
                        <div class="modal-header" style="background-color: #198754;">
                            <h4 class="modal-title" id="modalLabel" style="color: white;">Formulario de Agregar Compañía</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="limpiarFormulario()"></button>
                        </div>
                        <div class="modal-body">
                        <h5><strong>Nota:</strong> <i>todos los campos con * son obligatorios.</i></h5>
                        <br>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre <i class="text-danger">*</i></label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Digite el nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="rnc" class="form-label">RNC <i class="text-danger">*</i></label>
                                <input type="text" class="form-control" id="rnc" name="rnc" placeholder="Digite el rnc de la compañia" required>
                            </div>
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección <i class="text-danger">*</i></label>
                                <textarea class="form-control" id="direccion" name="direccion" placeholder="Digite la direccion" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono <i class="text-danger">*</i></label>
                                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="digite el telefono" required>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo <i class="text-danger">*</i></label>
                                <input type="email" class="form-control" id="correo" name="correo" placeholder="Digite el correo" required>
                            </div>
                            <div class="mb-3">
                                <label for="interes_fijo" class="form-label">Interes Fijo <i class="text-danger">*</i></label>
                                <input type="text" class="form-control" id="interes_fijo" name="interes_fijo" placeholder="Digite el interés que se va a asignar" onkeyPress='return isNumber(event.key);' required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="limpiarFormulario()">Cerrar</button>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal Editar Compañía -->
        <div class="modal fade" id="modalEditarCompania" tabindex="-1" role="dialog" aria-labelledby="editarCompaniaLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="formEditarCompania">
                        <div class="modal-header" style="background-color: #198754;">
                            <h4 class="modal-title" id="editarCompaniaLabel" style="color: white;">Editar Compañía</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <h5><strong>Nota:</strong> <i>todos los campos con * son obligatorios.</i></h5>
                        <br>
                            <input type="hidden" id="editarCompaniaId" name="id">
                            <div class="form-group">
                                <label for="editarNombre">Nombre <i class="text-danger">*</i></label>
                                <input type="text" class="form-control" id="editarNombre" name="nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="editarRNC">RNC <i class="text-danger">*</i></label>
                                <input type="text" class="form-control" id="editarRNC" name="rnc" required>
                            </div>
                            <div class="form-group">
                                <label for="editarDireccion">Dirección <i class="text-danger">*</i></label>
                                <input type="text" class="form-control" id="editarDireccion" name="direccion" required>
                            </div>
                            <div class="form-group">
                                <label for="editarTelefono">Teléfono <i class="text-danger">*</i></label>
                                <input type="text" class="form-control" id="editarTelefono" name="telefono" required>
                            </div>
                            <div class="form-group">
                                <label for="editarCorreo">Correo <i class="text-danger">*</i></label>
                                <input type="text" class="form-control" id="editarCorreo" name="correo" required>
                            </div>
                            <div class="form-group">
                                <label for="editarCorreo">Interes Fijo <i class="text-danger">*</i></label>
                                <input type="number" class="form-control" id="editarInteresFijo" name="interes_fijo" onkeyPress='return isNumber(event.key);' required>
                            </div>
                            <div class="form-group">
                                <label for="editarEstado">Estado</label>
                                <select class="form-control" id="editarEstado" name="estado">
                                    <option value="" disabled selected>Seleccione un estado</option>
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<script>
    function limpiarFormulario() {
        const form = document.getElementById('formAgregarCompania');
        form.reset(); // Limpia todos los campos del formulario
    }
</script>