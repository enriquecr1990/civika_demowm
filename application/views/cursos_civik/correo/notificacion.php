<?php $this->load->view('cursos_civik/correo/header'); ?>

<div class="container">
    <br>
    <div class="card">
        <div class="card-header">
            <?php if(isset($correo_masivo) && $correo_masivo === true): ?>
                <!--<label>Estimado(a)</label>-->
            <?php else: ?>
                <!--<label>Estimado(a) C. <?=isset($nombre_destinatario) ? $nombre_destinatario : $usuario->nombre.' '.$usuario->apellido_p?></label>-->
            <?php endif; ?>
        </div>
        <div class="card-body">
            <p>
                <?=$mensaje?>
            </p>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="alert alert-light text-center oferta_academica" style="font-size: 18px; font-weight: bold">
                Tenemos más de 400 cursos registrados ante la Secretaria del Trabajo y Previsión Social. Para consultarlos dé clic
                <a href="http://agentes.stps.gob.mx:141/Buscador/BuscadorAgente.aspx" class="btn-link" target="_blank">aquí</a>
                y teclee en razón social: CIVIKA o en RFC: CHL111213MX1 y dé clic en botón "consultar".
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <p>
                Te enviamos este e-mail como parte de tu inscripción en el portal de la Fundación Civika.
                Visita nuestra página <a href="<?=base_url()?>"><?=base_url()?></a> para conocer nuestras politicas de privacidad.
            </p>
            <p>
                Puedes cancelar en el momento que desees pulsando en <a href="<?=base_url()?>InscripcionesCTN/baja_suscripcion_mail<?=isset($email_baja) && $email_baja != '' ? '?email='.$email_baja : ''?>" >Cancelar suscripción</a>
            </p>
        </div>
    </div>
    <br>
</div>

<?php $this->load->view('cursos_civik/correo/footer'); ?>

