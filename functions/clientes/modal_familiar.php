<!-- Modal Agregar/Editar Familiar -->
<div class="modal fade" id="modalFamiliar" data-bs-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalFamiliarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formFamiliar">
                <div class="modal-header" style="background-color: #198754;">
                    <h4 class="modal-title" id="modalFamiliarLabel" style="color: white;">Agregar/Editar Familiar</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="Limpiar()"></button>
                </div>
                <div class="modal-body">
                    <h5><strong>Nota:</strong> <i>todos los campos con * son obligatorios.</i></h5>
                    <br>
                    <input type="hidden" name="id" id="familiar_id">

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="cliente_id">Socio del familiar a agregar <i class="text-danger">*</i></label>
                            <select class="form-control" name="cliente_id" id="cliente_id" required>
                                <option value="" disabled selected>Seleccione un socio</option>
                                <?php foreach ($clientes as $cli): ?>
                                    <option value="<?php echo $cli['id']; ?>"><?php echo $cli['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cedula">Cédula del familiar<i class="text-danger">*</i></label>
                            <input type="text" class="form-control" name="cedula" id="cedula" placeholder="Digite la cedula" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="nombre">Nombre del familiar<i class="text-danger">*</i></label>
                            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Digite el nombre" onkeyPress='return onlyLtt(event.key);' required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="relacion">Relación con el socio<i class="text-danger">*</i></label>
                            <input type="text" class="form-control" name="relacion" id="relacion" placeholder="Digite el parentezco" onkeyPress='return onlyLtt(event.key);' required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="telefono">Teléfono del familiar<i class="text-danger">*</i></label>
                            <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Digite el telefono" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="correo_electronico">Correo Electrónico</label>
                            <input type="email" class="form-control" name="correo_electronico" id="correo_electronico" placeholder="Digite el correo">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="nombre_hijos">Nombre de los Hijos</label>
                            <input type="text" class="form-control" name="nombre_hijos" id="nombre_hijos" placeholder="Digite el nombre de los hijos separados por coma ( , )">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="Limpiar()">Cerrar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

