<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>


<div class="container-fluid" id="accordion">

    <div class="card">
        <div class="card-header">
            <span>
                <h5 >Formulario complementario al proceso de inscripción</h5>
            </span>
        </div>
        <div class="card-body">

            <!-- wizard -->
            <ul class="nav nav-blue nav-fill " id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link rounded active" id="nav_formato_dc3"
                       data-toggle="tab" href="#datos_empresa" role="tab" aria-controls="profile" aria-selected="false">
                        Datos formato DC-3
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded <?=$guardo_datos_empresa ? '':'disabled'?>" id="nav_registro_pago_complemento"
                       data-toggle="tab" href="#registro_pago" role="tab" aria-controls="contact" aria-selected="false">
                        Complemento registro de pago
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="datos_empresa" role="tabpanel" aria-labelledby="datos_empresa-tab">
                    <?php $this->load->view('cursos_civik/control_usuarios/form_datos_empresa',array('es_inscripcion' => true)); ?>
                </div>
                <div class="tab-pane fade" id="registro_pago" role="tabpanel" aria-labelledby="registro_pago-tab">
                    <?php $this->load->view('cursos_civik/inscripcion/form_registro_pago'); ?>
                </div>
            </div>

        </div>
    </div>

</div>

<!-- conteiners para las peticiones de las operaciones -->
<div id="container_modal_validar_datos_alumno_envio_recibo"></div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>