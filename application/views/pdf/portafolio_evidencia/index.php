<?php
$data['extra_css_pdf'] = array(
	base_url().'assets/css/pdf/portafolio_evidencia.css'
);
$this->load->view('pdf/header',$data);
?>

<?php $this->load->view('pdf/portafolio_evidencia/1-1-3-acuse_recibo'); ?>
<?php $this->load->view('pdf/portafolio_evidencia/2-1-0-recopilacion-evidencia'); ?>
<?php $this->load->view('pdf/portafolio_evidencia/2-1-1-plan-evaluacion'); ?>

<?php $this->load->view('pdf/footer')?>
