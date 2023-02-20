<form id="form_validar_rfc_registro_masivo_curso">

    <input type="hidden" name="id_publicacion_ctn" value="<?=$publicacion_ctn->id_publicacion_ctn?>">

    <div class="row row_form">
        <div class="form-group col-lg-4 col-md-4"></div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            <label>RFC de la empresa</label>
            <input id="rfc_empresa" name="rfc" class="form-control civika_mayus" data-rule-required="true" placeholder="RFC de la empresa">
        </div>
        <div class="form-group col-lg-4 col-md-4"></div>
    </div>
    <div class="row">
        <div class="form-group col-lg-4 col-md-4"></div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12 text-center">
            <button type="button" class="btn btn-pill btn-success btn-sm validar_rfc_inscripcion_masiva">Validar RFC</button>
            <button type="button" class="btn btn-sm btn-pill btn-info btn_cargar_carta_descriptiva_curso"
                    data-id_publicacion_ctn="<?=$publicacion_ctn->id_publicacion_ctn?>">
                Carta descriptiva
            </button>
        </div>
        <div class="form-group col-lg-4 col-md-4"></div>
    </div>
</form>