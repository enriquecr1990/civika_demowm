<div class="accordion">
    <div class="card mb-3">
        <div class="card-header" id="heading_card">
            <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#body_collapse"
                    aria-expanded="true" aria-controls="body_collapse">
                <label>Detalle general del curso &nbsp;&nbsp;&nbsp;<span class="help-span">(Click para expandir)</span></label>
            </button>
        </div>
        <div id="body_collapse" class="collapse" aria-labelledby="heading_card" data-parent="accordion">
            <div class="card-body">
                <div  class="card-body" aria-labelledby="head_detalle_general" >
                    <div class="row">
                        <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <label>Nombre:</label>
                        </div>
                        <div class="form-group col-lg-10 col-md-10 col-sm-12 col-xs-12">
                            <span><?= $curso_taller_norma->nombre ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <label>Descripción:</label>
                        </div>
                        <div class="form-group col-lg-10 col-md-10 col-sm-12 col-xs-12">
                            <span><?= $curso_taller_norma->descripcion ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <label>Objetivo:</label>
                        </div>
                        <div class="form-group col-lg-10 col-md-10 col-sm-12 col-xs-12">
                            <span><?= $curso_taller_norma->objetivo ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <label>Área temática:</label>
                        </div>
                        <div class="form-group col-lg-10 col-md-10 col-sm-12 col-xs-12">
                            <span><?= $curso_taller_norma->clave . ' - ' . $curso_taller_norma->denominacion ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>