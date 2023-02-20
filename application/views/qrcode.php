<?php $this->load->view('default/header') ?>
<div align="center">
	<form action="" method="post">
	<span>introduce el la palabra a convertir</span><br><br>
	<input type="text" name="qr_text" required="required" placeholder="">
	<input type="hidden" name="action" value="generate_qrcode">
	<input type="submit" name="" value="Generar">
	</form>
	<?php
	if($img_url)
	{
	?>
		<br><br>Escanea tu resultado<br>
		<img src="<?php echo base_url('imagenes/QR'.$img_url); ?>" alt="QRCode Image">
	<?php
	}
	?>
</div>
<?php $this->load->view('default/footer') ?>