
</div> <!-- end page-wrapper -->

<br><br>
<br>
<div class="card" style="background-image: linear-gradient(white, white,white,white, lightgrey,grey, black);">

    <p class="text-muted text-center text-white">© Copyright 2023 — Grupo Cívika</p>
</div>


<!-- Scripts del jquery -->
<script src="<?=base_url() . 'extras/plugins/jquery-3.4.1.min.js'?>"></script>

<!-- scripts de bootstrap -->
<script src="<?=base_url() . 'extras/plugins/bootstrap/js/bootstrap.bundle.js'?>"></script>
<script src="<?=base_url() . 'extras/plugins/bootstrap/js/popper.min.js'?>"></script>
<script src="<?=base_url() . 'extras/plugins/bootstrap/js/bootstrap.min.js'?>"></script>

<!-- scripts del template de arcana -->
<script src="<?=base_url()?>extras/template/arcana/js/jquery.dropotron.min.js"></script>
<script src="<?=base_url()?>extras/template/arcana/js/skel.min.js"></script>
<script src="<?=base_url()?>extras/template/arcana/js/util.js"></script>
<!--[if lte IE 8]><script src="<?=base_url()?>extras/template/arcana/js/ie/respond.min.js"></script><![endif]-->
<script src="<?=base_url()?>extras/template/arcana/js/main.js"></script>

<!-- scripts del temple de shards -->
<script src="<?=base_url() . 'extras/template/shards/js/shards.js'?>"></script>
<!-- scripts del plugin de fileupload -->
<script src="<?=base_url() . 'extras/plugins/fileinput/js/fileinput.js'?>"></script>
<script src="<?=base_url() . 'extras/plugins/fileupload/js/vendor/jquery.ui.widget.js'?>"></script>
<script src="<?=base_url() . 'extras/plugins/fileupload/js/jquery.iframe-transport.js'?>"></script>
<script src="<?=base_url() . 'extras/plugins/fileupload/js/jquery.fileupload.js'?>"></script>

<!-- scripts del plugin de notificaciones del sistema -->
<script src="<?=base_url()?>extras/plugins/watnotif/js/watnotif-1.0.min.js"></script>

<!-- scripts del sistema -->
<script src="<?=base_url() . 'extras/js/comun.js?ver=' . uniqid()?>"></script>

<script src="<?=base_url() . 'extras/plugins/jquery/jquery.validate.js'?>" ></script>
<script src="<?=base_url() . 'extras/plugins/jquery/localization/messages_es.js'?>" ></script>
<script src="<?=base_url() . 'extras/plugins/datepicker/locales/bootstrap-datepicker.es.min.js'?>" ></script>

<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';
    var extenciones_files_img = '<?php echo EXTENSIONES_FILES_IMG ?>';
    var extenciones_files_xml = '<?php echo EXTENSION_FILES_XML ?>';
    var extencion_files_doc_pdf = '<?php echo EXTENSION_FILES_DOC_PDF ?>';
    var extencion_files_material_evidencia = '<?php echo EXTENSIONES_FILES_EVIDENCIA ?>';
    var max_filesize = '<?php echo MAX_FILESIZE ?>';
    var base_url_script = '<?php echo base_url() . "extras/" ?>';
    var loader_gif = '<div style="text-align: center;"><img src="<?php echo base_url("extras/imagenes/loaders/loader02.gif") ?>" width="100px" href="100px"></div>';
    var loader_gif_transparente = '<div style="text-align: center;"><img src="<?php echo base_url("extras/imagenes/loaders/loader02.gif") ?>" width="75px" href="75px"></div>';
    var loader_page = '<div class="loader"><div class="page-loader"></div></div>';
    var today = '<?=date('d/m/Y')?>';
    var tomorrow = '<?=date('d/m/Y', strtotime(date('Y-m-d') . ' + 1 days'))?>';
    var type_flashdata = '<?=$this->session->flashdata('type_message')?>';
    var msg_flashdata = '<?=$this->session->flashdata('message')?>';
    // Hide the loader and show the elements.
</script>

<!-- js extras y secundarios se cargan conforme al modulo-->
<?php if (isset($extra_js)): ?>
    <?php foreach ($extra_js as $js): ?>
        <script src="<?=$js?>?ver=<?php echo uniqid(); ?>"></script>
    <?php endforeach;?>
<?php endif;?>

<div id="conteiner_mensajes_civik" class="mensajes_sistema_civik"></div>
<div id="conteiner_modal_confirmacion"></div>

</body>
</html>
