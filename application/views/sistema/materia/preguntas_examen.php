<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>

<form class="form-horizontal" id="form_preguntas">
    <div class="form-group">
        <label class="col-sm-3">Tipo pregunta</label>
        <div class="col-sm-4">
            <select class="form-control tipo_pregunta">
                <option value="">Seleccione</option>
                <option value="1">V/F</option>
                <option value="2">Unica</option>
                <option value="3">Multiple</option>
            </select>
        </div>
    </div>

    <div class="col-sm-12 opcion_vf" style="display: none;">Verdadero falso</div>
    <div class="col-sm-12 opcion_unica" style="display: none;">Unica opcion</div>
    <div class="col-sm-12 opcion_multiple" style="display: none;">Opcion multiple</div>
</form>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>