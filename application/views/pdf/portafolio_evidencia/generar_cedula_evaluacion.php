<?php
$data['extra_css_pdf'] = array(
	base_url().'assets/css/pdf/portafolio_evidencia.css'
);
$this->load->view('pdf/header',$data);
?>

<?php $this->load->view('pdf/portafolio_evidencia/3-1-1-cedula-evaluacion_unico',array('solo_cedula' => true)); ?>

<?php $this->load->view('pdf/footer')?>
