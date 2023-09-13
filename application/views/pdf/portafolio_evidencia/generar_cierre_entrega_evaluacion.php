<?php
$data['extra_css_pdf'] = array(
	base_url().'assets/css/pdf/portafolio_evidencia.css'
);
$this->load->view('pdf/header',$data);
?>

<?php $this->load->view('pdf/portafolio_evidencia/3-1-0-cierre-evaluacion'); ?>
<?php $this->load->view('pdf/portafolio_evidencia/3-1-1-cedula-evaluacion'); ?>
<?php $this->load->view('pdf/portafolio_evidencia/3-1-2-entrega-certificado'); ?>
<?php $this->load->view('pdf/portafolio_evidencia/3-1-3-encuesta-satisfaccion'); ?>

<?php $this->load->view('pdf/footer')?>
