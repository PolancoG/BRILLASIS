<div class="modal fade" id="modalAgregarPrestamo" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="formAgregarPrestamo">
                <div class="modal-header" style="background-color: #198754;">
                    <h4 class="modal-title" style="color: white;">Agregar Préstamo</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" onclick="limpiarFormulario()"></button>
                </div>
                <div class="modal-body">
                    <h5><strong>Nota:</strong> <i>todos los campos con * son obligatorios.</i></h5>
                    <br>
                    <div class="form-group">
                        <label>Socio <i class="text-danger">*</i></label>
                        <select name="cliente_id" id="cliente_id" class="form-control" required>
                            <option selected disabled value="">Seleccione un socio</option>
                            <?php
                            $stmt = $conn->query("SELECT cliente.id, cliente.nombre FROM cliente WHERE cliente.id NOT IN (SELECT cliente_id FROM prestamo WHERE estado != 'cancelado')");
                            while ($cliente = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='{$cliente['id']}'>{$cliente['nombre']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Monto <i class="text-danger">*</i></label>
                        <input type="text" name="monto" class="form-control" placeholder="Introduzca el monto" onkeyPress='return isNumber(event.key);' required>
                    </div>
                    <div class="form-group">
                        <label>Interés (%) <i class="text-danger">*</i></label>
                        <input type="text" name="interes" id="interes" class="form-control" placeholder="Introduzca el interés" onkeyPress='return isNumber(event.key);' required>
                    </div>
                    <div class="form-group">
                        <label>Plazo (meses) <i class="text-danger">*</i></label>
                        <input type="text" name="plazo" class="form-control" placeholder="Introduzca el plazo aquí" onkeyPress='return isNumber(event.key);' required>
                    </div>
                    <div class="form-group">
                        <label>Estado <i class="text-danger">*</i></label>
                        <select id="estado" name="estado" class="form-control" required>
                            <option selected disabled value="">Seleccione una Opción</option>
                            <option value="activo_bien">Activo Bien</option>
                            <option value="activo_problemas">Activo Pendiente</option>
                            <option value="activo_terminado">Activo Terminado</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #c8c8c8;">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiarFormulario()">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarPrestamo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="formEditarPrestamo" method="POST">
                <div class="modal-header" style="background-color: #198754;">
                    <h4 class="modal-title">Editar Préstamo</h4>
                    <button type="button" class="btn-close cerrarModal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5><strong>Nota:</strong><i> todos los campos con * son obligatorios.</i></h5>
                    <br>
                    <input type="hidden" id="editPrestamoId" name="id">
                    <div class="form-group">
                        <label>ID del Socio <i class="text-danger">*</i></label>
                        <input type="text" id="editClienteId" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Monto <i class="text-danger">*</i></label>
                        <input type="text" id="editMonto" name="monto" class="form-control" onkeyPress='return isNumber(event.key);' required>
                    </div>
                    <div class="form-group">
                        <label>Interés (%) <i class="text-danger">*</i></label>
                        <input type="text" id="editInteres" name="interes" class="form-control" onkeyPress='return isNumber(event.key);' readonly required>
                    </div>
                    <div class="form-group">
                        <label>Plazo (meses) <i class="text-danger">*</i></label>
                        <input type="text" id="editPlazo" name="plazo" class="form-control" onkeyPress='return isNumber(event.key);' required>
                    </div>
                    <div class="form-group">
                        <label>Estado <i class="text-danger">*</i></label>
                        <select id="editEstado" name="estado" class="form-control" required>
                            <option selected disabled value="">Seleccione una Opción</option>
                            <option value="activo_bien">Activo Bien</option>
                            <option value="activo_problemas">Activo Pendiente</option>
                            <option value="activo_terminado">Activo Terminado</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #c8c8c8;">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-secondary cerrarModal" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

            <!-- hasta aqui-->
<script>
    function limpiarFormulario() {
        const form = document.getElementById('formAgregarPrestamo');
        form.reset(); // Limpia todos los campos del formulario
    }
</script>