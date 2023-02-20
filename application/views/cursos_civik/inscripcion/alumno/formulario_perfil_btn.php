<div class="row">
    <?php if(isset($es_inscripcion) && $es_inscripcion): ?>
        <input type="hidden" name="alumno_inscrito_ctn_publicado[id_alumno_inscrito_ctn_publicado]" value="<?=$alumno_inscrito_ctn_publicacion->id_alumno_inscrito_ctn_publicado?>">
        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
            <button type="button" class="btn btn-success btn-pill btn-sm guardar_usuario_alumno_datos_personales">
                Guardar datos personales
            </button>
        </div>
    <?php endif; ?>
</div>