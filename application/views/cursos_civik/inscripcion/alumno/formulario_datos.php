<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>


<div class="container-fluid" id="accordion">

    <div class="card">
        <div class="card-header">
            <span>
                <h5 >Proceso de inscripcion</h5>
            </span>
        </div>
        <div class="card-body">

            <!-- wizard -->
            <ul class="nav nav-blue nav-fill " id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link rounded <?=$guardo_datos_generales ? '':'active'?>" id="nav_paso_1" data-toggle="tab"
                       href="#datos_personales" role="tab" aria-controls="datos_personales" aria-selected="true">
                        Paso 1 &nbsp;(datos personales)<?=$guardo_datos_generales ? '<span class="fa fa-check fa-2x"></span>':'' ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded <?=$guardo_datos_generales && !$guardo_datos_empresa ? 'active':'' ?> <?=$guardo_datos_generales && !$guardo_datos_empresa ? 'active':''?>"
                       id="nav_paso_2" data-toggle="tab" href="#datos_empresa" role="tab" aria-controls="profile" aria-selected="false">
                        Paso 2 (datos empresa)<?=$guardo_datos_empresa ? '<span class="fa fa-check fa-2x"></span>':'' ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded <?=$guardo_datos_generales ? '':'' ?> <?=$guardo_datos_empresa ? 'active':''?>" id="nav_paso_3"
                       data-toggle="tab" href="#registro_pago" role="tab" aria-controls="contact" aria-selected="false">
                        Paso 3 (registro de pago)
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade <?=$guardo_datos_generales ? '':'show active'?>" id="datos_personales" role="tabpanel" aria-labelledby="datos_personales-tab">
                    <?php $this->load->view('cursos_civik/control_usuarios/form_datos_personales'); ?>
                </div>
                <div class="tab-pane fade <?=$guardo_datos_generales && !$guardo_datos_empresa ? 'show active':''?>" id="datos_empresa" role="tabpanel" aria-labelledby="datos_empresa-tab">
                    <?php $this->load->view('cursos_civik/control_usuarios/form_datos_empresa'); ?>
                </div>
                <div class="tab-pane fade <?=$guardo_datos_empresa ? 'show active':''?>" id="registro_pago" role="tabpanel" aria-labelledby="registro_pago-tab">
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