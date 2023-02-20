<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>


<div class="container">
    <div class="card">
        <div class="card-header">
            <label>Notificaciones</label>
        </div>
        <div class="card-body">
            <div id="div_notificaciones">
                <?php $this->load->view('cursos_civik/notificaciones/resultados'); ?>
            </div>
        </div>
    </div>
</div>

<!-- conteiners para las peticiones de las operaciones -->

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>