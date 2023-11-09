<?php $this->load->view('default/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php $this->load->view('menu/content_header');?>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content" id="tablero_informacion_contacto">

		<div class="card card-solid">
			<div class="card-body pb-0">
				<div class="row">
					<div class="form-group col-6">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d559.357822148381!2d-98.12858115877783!3d19.4169369012037!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d01f895179c64f%3A0x70435f5e22ca58b!2sCampus%20C%C3%ADvika!5e0!3m2!1ses!2smx!4v1639626258997!5m2!1ses!2smx"
								style="border:0; width: 100%; min-height: 450px; height: auto" allowfullscreen="" loading="lazy"></iframe>
					</div>
					<div class="form-group col-6">
						<div class="row form-group">
							<div class="col-md-12 col-sm-12">
								<h5>Contacto</h5>
								<ul style="list-style: none">
									<!-- CEDE APIZACO -->
									<li>
										<i class="fa fa-map-marked-alt"></i>
										Centro Educativo Campus Cívika. Ferrocarril Mexicano 286. Colonia 20 de noviembre. Apizaco, Tlax. C.P. 90341
									</li>
									<li>
										<i class="fa fa-phone"></i>
										<a href="tel:241-417-75-65">(01) 241 417 75 65</a>
									</li>
									<li>
										<i class="fab fa-whatsapp"></i>
										<a href="https://api.whatsapp.com/send?phone=522221233936" target="_blank">222 123 3936</a>
									</li>
									<li>
										<i class="fab fa-whatsapp"></i>
										<a href="https://api.whatsapp.com/send?phone=522411318840" target="_blank">241 131 8840</a>
									</li>
									<li>
										<i class="fa fa-envelope-o"></i>
										<a href="mailto:hola.civika@outlook.com?Subject=Información cursos">hola.civika@outlook.com</a>
									</li>
									<li>
										<i class="fa fa-file-pdf-o"></i>
										<a href="<?=base_url()?>assets/docs/aviso_privacidad_civik.pdf" target="_blank">Aviso de privacidad</a>
									</li>
								</ul>
							</div>
						</div>

<!--						<div class="row form-group">-->
<!--							<h5 class="col-12">Nuestros principales registros</h5>-->
<!--						</div>-->
<!---->
<!--						<div class="row form-group">-->
<!--							<div class="col-md-12 col-sm-12 text-center">-->
<!--								<div class="row form-group">-->
<!--									<div class="col-lg-4 col-md-4 col-sm-6 col-12"><img class="img-fluid" src="--><?//=base_url().'assets/imgs/logos/ECE.jpg'?><!--" alt="ECE" width="155px"></div>-->
<!--									<div class="col-lg-4 col-md-4 col-sm-6 col-12"><img class="img-fluid" src="--><?//=base_url().'assets/imgs/logos/CONACYT.png'?><!--" alt="CONACYT" width="75px"></div>-->
<!--									<div class="col-lg-4 col-md-4 col-sm-6 col-12"><img class="img-fluid" src="--><?//=base_url().'assets/imgs/logos/TOEFL.png'?><!--" alt="TOEFL" width="155px"></div>-->
<!--								</div>-->
<!--							</div>-->
<!--						</div>-->
<!---->
<!--						<div class="row form-group">-->
<!--							<div class="col-md-12 col-sm-12 text-center">-->
<!--								<div class="row form-group">-->
<!--									<div class="col-lg-4 col-md-4 col-sm-6 col-12"><img class="img-fluid" src="--><?//=base_url().'assets/imgs/logos/EMA.png'?><!--" alt="EMA" width="100px"></div>-->
<!--									<div class="col-lg-4 col-md-4 col-sm-6 col-12"><img class="img-fluid" src="--><?//=base_url().'assets/imgs/logos/DUNS_2021.png'?><!--" alt="DUNS" width="100px"></div>-->
<!--									<div class="col-lg-4 col-md-4 col-sm-6 col-12"><img class="img-fluid" src="--><?//=base_url().'assets/imgs/logos/STPS.png'?><!--" alt="STPS" width="160px"></div>-->
<!--								</div>-->
<!--							</div>-->
<!--						</div>-->

					</div>
				</div>
			</div>
		</div>

	</section>
	<!-- /.content -->

</div>
<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>
