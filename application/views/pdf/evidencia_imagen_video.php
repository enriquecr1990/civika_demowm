<?php
$data['extra_css_pdf'] = array(
		base_url() . 'assets/css/pdf/portafolio_evidencia.css'
);
$this->load->view('pdf/header', $data);
?>

<?php if ($es_evidencia_imagen): ?>
	<strong>Evidencia del candidato en imagen</strong>
	<br>
	<img src="<?=base_url().$evidencia->ruta_directorio.$evidencia->nombre?>" style="width: 100%; height: auto">
<?php else: ?>
	<strong>Evidencia del candidato en link de video</strong>
	<br>
	<strong><a href="<?=$evidencia->url_video?>"><?=$evidencia->url_video?></a></strong>
<?php endif; ?>

<?php $this->load->view('pdf/footer') ?>
