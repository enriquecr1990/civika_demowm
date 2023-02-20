<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>

<div class="container">
    <div class="panel panel-success">
        <div class="panel-heading">Normas ASEA</div>
        <div class="panel-body">

            <div class="form-group">
                <div class="col-md-12">
                    <label class="col-sm-2">Periodo:</label>
                    <div class="col-sm-3">
                        <select class="form-control periodo_curso_empleado_es">
                            <option value="">Todos</option>
                            <?php foreach ($catalogo_anios as $ca): ?>
                                <option value="<?=$ca?>"><?=$ca?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <?php if($normas_asea): ?>
                <div id="conteiner_contenido_cursos_normas_asea">
                    <?php $this->load->view('asea/empleados_es/ListaCursosNormasAsea'); ?>
                </div>
            <?php else: ?>
                <div class="col-sm-12">
                    <div class="alert alert-info">
                        <i class="glyphicon glyphicon-info-sign"></i>
                        Por el momento no se encuentran registras normas en el sistema
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<div id="conteiner_empleado_cursar_norma_asea"></div>
<div id="conteiner_empleado_evaluaciones_norma_asea"></div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>