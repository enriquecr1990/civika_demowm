<div class="form-group row">
	<!-- Profile Image -->
	<div class="col-sm-4">
		<div class="card card-danger card-outline">
			<div class="card-body box-profile">
				<div class="text-center">

					<img class="profile-user-img img-fluid img-circle img_foto_perfil" style="width: 100px; height: 100px;"
							src="<?=isset($foto_perfil) ? base_url($foto_perfil->ruta_directorio.$foto_perfil->nombre) : base_url('/assets/imgs/iconos/admin.png')?>"
							alt="Foto de perfil">
				</div>

				<h3 class="profile-username text-center">
					Foto de perfil
				</h3>
				<!-- <p class="text-sm text-muted">Foto digital de libre elección (color, blanco y negro, distintos tamaños, etc), no se usará para los expedientes emitidos por el sistema</p> -->
			</div>
			<!-- /.card-body -->
			<div class="card-footer text-right">
				<input type="file" id="img_perfil" name="img_foto_perfil" accept="image/*" class="img_foto_perfil">
				<div id="procesando_img_foto_perfil"></div>
				<button id="btn_visor_imagen_perfil" type="button" 
						data-nombre_archivo="<?=isset($foto_perfil) ? $foto_perfil->nombre : 'Sin foto de perfil' ?>"
						data-src_image="<?=isset($foto_perfil) ? base_url($foto_perfil->ruta_directorio.$foto_perfil->nombre) : base_url('/assets/imgs/iconos/admin.png')?>"
						class="btn btn-sm btn-success btn_ver_imagen_modal"><i class="fa fa-eye"></i> Ver foto</button>
			</div>
		</div>
		<!-- /.card -->
	</div>

	<?php if(isset($usuario) && in_array($usuario->perfil,array('alumno'))): ?>
		<!-- foto certificados -->
		<div class="col-sm-4">
			<div class="card card-danger card-outline">
				<div class="card-body box-profile">
					<div class="text-center">
						<img class="profile-user-img img-fluid img-circle img_foto_certificado" style="width: 100px; height: 100px;"
							 src="<?=isset($foto_certificados) ? base_url($foto_certificados->ruta_directorio.$foto_certificados->nombre) : base_url('assets/imgs/logos/no_disponible.png')?>"
							 alt="Foto para certificados">
					</div>

					<h3 class="profile-username text-center">
						Foto para certificados
						<?php if(isset($foto_certificados)): ?>
							<a href="<?=base_url($foto_certificados->ruta_directorio.$foto_certificados->nombre)?>" class="btn btn-sm btn-outline-success" target="_blank"><i class="fa fa-download"></i></a>
						<?php endif; ?>
					</h3>
					<p class="text-sm text-muted">Foto digital a color tamaño infantil, de frente, fondo blanco, sin lentes, frente descubierta. (En caso de usar aretes, que estos sean pequeños)</p>
				</div>
				<!-- /.card-body -->
				<div class="card-footer text-right">
					<input type="file" id="img_certificados" data-div_procesando="#procesando_img_foto_certificados" accept="image/*"
						   data-id_cat_expediente="2" data-img_destino=".img_foto_certificado" name="img_foto_certificado" class="">
					<div id="procesando_img_foto_certificados"></div>
					<button id="btn_visor_imagen_foto_certificados" type="button" 
							data-nombre_archivo="<?=isset($foto_certificados) ? $foto_certificados->nombre : 'Sin foto cargada al sistema' ?>"
							data-src_image="<?=isset($foto_certificados) ? base_url($foto_certificados->ruta_directorio.$foto_certificados->nombre) : base_url('assets/imgs/logos/no_disponible.png')?>"
							class="btn btn-sm btn-success btn_ver_imagen_modal"><i class="fa fa-eye"></i> Ver foto</button>
				</div>
			</div>
			<!-- /.card -->
		</div>
	<?php endif; ?>

	<?php if(isset($usuario) && in_array($usuario->perfil,array('instructor','alumno'))): ?>
		<!-- firma digital -->
		<div class="col-sm-4">
			<div class="card card-danger card-outline">
				<div class="card-body box-profile">
					<div class="text-center">
						<img class="profile-user-img img-fluid img-circle img_foto_firma" style="width: 100px; height: 100px;"
							 src="<?=isset($foto_firma) ? base_url($foto_firma->ruta_directorio.$foto_firma->nombre) : base_url('assets/imgs/logos/no_disponible.png')?>"
							 alt="Firma digitalizada">
					</div>

					<h3 class="profile-username text-center">
						Firma digitalizada
						<?php if(isset($foto_firma)): ?>
							<a href="<?=base_url($foto_firma->ruta_directorio.$foto_firma->nombre)?>" class="btn btn-sm btn-outline-success" target="_blank"><i class="fa fa-download"></i></a>
						<?php endif; ?>
					</h3>
					<p class="text-sm text-muted">Firmar en una hoja blanca lo más parecido a su identificación oficial. Posteriormente escanear en formato de imagen "PNG" (fondo transparente). Puede ver el documento/formato de la firma dando click <a href="<?=base_url()?>assets/docs/firma_digitalizada.pdf" download="">aquí</a> </p>
				</div>
				<!-- /.card-body -->
				<div class="card-footer text-right">
					<input type="file" id="img_firma_digital" data-div_procesando="#procesando_img_firma_digital" accept="image/*"
						   data-id_cat_expediente="8" data-img_destino=".img_foto_firma" name="img_foto_firma" class="archivo_expediente_imagen">
					<div id="procesando_img_firma_digital"></div>
					<button id="btn_visor_imagen_foto_firma_digital" type="button" 
							data-nombre_archivo="<?=isset($foto_firma) ? $foto_firma->nombre : 'Sin foto cargada al sistema' ?>"
							data-src_image="<?=isset($foto_firma) ? base_url($foto_firma->ruta_directorio.$foto_firma->nombre) : base_url('assets/imgs/logos/no_disponible.png')?>"
							class="btn btn-sm btn-success btn_ver_imagen_modal"><i class="fa fa-eye"></i> Ver firma</button>
				</div>
			</div>
			<!-- /.card -->
		</div>
	<?php endif; ?>

	<?php if(isset($usuario) && in_array($usuario->perfil,array('alumno'))): ?>
		<!-- curp -->
		<div class="col-sm-4">
			<div class="card card-danger card-outline">
				<div class="card-body box-profile">
					<div class="text-center">
						<a id="doc_curp_candidato_link" href="<?=isset($doc_curp) ? base_url($doc_curp->ruta_directorio.$doc_curp->nombre) : '#'?>" target="_blank">
							<img class="profile-user-img img-fluid img-circle" style="width: 100px; height: 100px;"
								 src="<?=base_url()?>assets/imgs/logos/curp.jpg"
								 alt="Curp digital">
						</a>
					</div>

					<h3 class="profile-username text-center">
						CURP
						<?php if(isset($doc_curp)): ?>
							<a href="<?=base_url($doc_curp->ruta_directorio.$doc_curp->nombre)?>" class="btn btn-sm btn-outline-success" target="_blank"><i class="fa fa-download"></i></a>
						<?php endif; ?>
					</h3>
					<div id="legend_cargo_curp_candidato">
						<?php if(isset($doc_curp)): ?>
							<span class="text-sm text-muted">* Se cargo el CURP previamente, de click en la imagen de arriba para visualizarla</span>
						<?php endif; ?>
					</div>
					<p class="text-sm text-muted">Si no sabe su CURP, puedo consoltarlo en la página del <a href="https://www.gob.mx/curp/" target="_blank">RENAPO</a></p>
				</div>
				<!-- /.card-body -->
				<div class="card-footer text-right">
					<input type="file" id="doc_curp_candidato" name="doc_curp_candidato" accept="application/pdf">
					<div id="procesando_doc_curp_candidato"></div>
				</div>
			</div>
		</div>
	<?php endif; ?>

</div>

<?php if(isset($usuario) && $usuario->perfil == 'alumno'): ?>
	<hr>
	<label>Credencial para votar INE</label>
	<div class="form-group row">
		<!-- INE anversor -->
		<div class="col-sm-4">
			<div class="card card-danger card-outline">
				<div class="card-body box-profile">
					<div class="text-center">
						<img class="profile-user-img img-fluid img-circle img_foto_ine_anverso" style="width: 100px; height: 100px;"
							 src="<?=isset($foto_ine_anverso) ? base_url($foto_ine_anverso->ruta_directorio.$foto_ine_anverso->nombre) : base_url('assets/imgs/logos/ine_anverso.jpg')?>"
							 alt="INE anverso">
					</div>

					<h3 class="profile-username text-center">
						Mi INE (Anverso)
						<?php if(isset($foto_ine_anverso)): ?>
							<a href="<?=base_url($foto_ine_anverso->ruta_directorio.$foto_ine_anverso->nombre)?>" class="btn btn-sm btn-outline-success" target="_blank"><i class="fa fa-download"></i></a>
						<?php endif; ?>
					</h3>
				</div>
				<!-- /.card-body -->
				<div class="card-footer text-right">
					<input type="file" id="img_foto_ine_anverso" data-div_procesando="#procesando_img_ine_anverso" accept="image/*"
						   data-id_cat_expediente="3" data-img_destino=".img_foto_ine_anverso" name="img_foto_ine_anverso" class="">
					<div id="procesando_img_ine_anverso"></div>
					<button id="btn_visor_imagen_foto_ine_anverso" type="button" 
							data-nombre_archivo="<?=isset($foto_ine_anverso) ? $foto_ine_anverso->nombre : 'Sin foto cargada al sistema' ?>"
							data-src_image="<?=isset($foto_ine_anverso) ? base_url($foto_ine_anverso->ruta_directorio.$foto_ine_anverso->nombre) : base_url('assets/imgs/logos/ine_anverso.jpg')?>"
							class="btn btn-sm btn-success btn_ver_imagen_modal"><i class="fa fa-eye"></i> Ver INE</button>
				</div>
			</div>
			<!-- /.card -->
		</div>

		<!-- INE reversor -->
		<div class="col-sm-4">
			<div class="card card-danger card-outline">
				<div class="card-body box-profile">
					<div class="text-center">
						<img class="profile-user-img img-fluid img-circle img_foto_ine_reverso" style="width: 100px; height: 100px;"
							 src="<?=isset($foto_ine_reverso) ? base_url($foto_ine_reverso->ruta_directorio.$foto_ine_reverso->nombre) : base_url('assets/imgs/logos/ine_reverso.jpg')?>"
							 alt="INE reverso">
					</div>

					<h3 class="profile-username text-center">
						Mi INE (Reverso)
						<?php if(isset($foto_ine_reverso)): ?>
							<a href="<?=base_url($foto_ine_reverso->ruta_directorio.$foto_ine_reverso->nombre)?>" class="btn btn-sm btn-outline-success" target="_blank"><i class="fa fa-download"></i></a>
						<?php endif; ?>
					</h3>
				</div>
				<!-- /.card-body -->
				<div class="card-footer text-right">
					<input type="file" id="img_foto_ine_reverso" data-div_procesando="#procesando_img_ine_anverso" accept="image/*"
						   data-id_cat_expediente="3" data-img_destino=".img_foto_ine_reverso" name="img_foto_ine_anverso" class="">
					<div id="procesando_img_ine_anverso"></div>
					<button id="btn_visor_imagen_foto_ine_reverso" type="button" 
							data-nombre_archivo="<?=isset($foto_ine_reverso) ? $foto_ine_reverso->nombre : 'Sin foto cargada al sistema' ?>"
							data-src_image="<?=isset($foto_ine_reverso) ? base_url($foto_ine_reverso->ruta_directorio.$foto_ine_reverso->nombre) : base_url('assets/imgs/logos/ine_reverso.jpg')?>"
							class="btn btn-sm btn-success btn_ver_imagen_modal"><i class="fa fa-eye"></i> Ver INE </button>
				</div>
			</div>
			<!-- /.card -->
		</div>
	</div>
<?php endif; ?>

<?php if(isset($usuario) && in_array($usuario->perfil,array('instructor','alumno'))): ?>
	<hr>
	<div class="form-group row">
		<label class="col-sm-3">¿Cuenta con cédula profesional?</label>
		<div class="form-group clearfix">
			<div class="icheck-danger d-inline">
				<input type="radio" class="check_show_hide_componente" data-destino_show_hide="#contenedor_cedula_profesional"
					   name="cedula_cuenta" <?=isset($foto_cedula_anverso) ? '':'checked="checked"'?> id="cedula_no" value="no">
				<label for="cedula_no">No</label>
			</div>
			<div class="icheck-success d-inline">
				<input type="radio" class="check_show_hide_componente" data-destino_show_hide="#contenedor_cedula_profesional"
					   name="cedula_cuenta" <?=isset($foto_cedula_anverso) ? 'checked="checked"':''?> id="cedula_si" value="si">
				<label for="cedula_si">Si</label>
			</div>
		</div>
	</div>

	<div id="contenedor_cedula_profesional" style="display: <?=isset($foto_cedula_anverso) ? 'block':'none'?>">
		<label>Cédula profesional</label>
		<div class="form-group row" >
			<!-- cedula anverso -->
			<div class="col-sm-4">
				<div class="card card-danger card-outline">
					<div class="card-body box-profile">
						<div class="text-center">
							<img class="profile-user-img img-fluid img-circle img_foto_cedula_anverso" style="width: 100px; height: 100px;"
								 src="<?=isset($foto_cedula_anverso) ? base_url($foto_cedula_anverso->ruta_directorio.$foto_cedula_anverso->nombre) : base_url('assets/imgs/logos/no_disponible.png')?>"
								 alt="Cédula profesional anverso">
						</div>

						<h3 class="profile-username text-center">
							Cédula profesional (Anverso)
							<?php if(isset($foto_cedula_anverso)): ?>
								<a href="<?=base_url($foto_cedula_anverso->ruta_directorio.$foto_cedula_anverso->nombre)?>" class="btn btn-sm btn-success" target="_blank"><i class="fa fa-download"></i></a>
							<?php endif; ?>
						</h3>
					</div>
					<!-- /.card-body -->
					<div class="card-footer text-right">
						<input type="file" id="img_foto_cedula_anverso" data-div_procesando="#procesando_img_cedula_anverso" accept="image/*"
							   data-id_cat_expediente="3" data-img_destino=".img_foto_cedula_anverso" name="img_foto_cedula_anverso" class="">
						<div id="procesando_img_cedula_anverso"></div>
						<button id="btn_visor_imagen_foto_cedula_anverso" type="button" 
							data-nombre_archivo="<?=isset($foto_cedula_anverso) ? $foto_cedula_anverso->nombre : 'Sin foto cargada al sistema' ?>"
							data-src_image="<?=isset($foto_cedula_anverso) ? base_url($foto_cedula_anverso->ruta_directorio.$foto_cedula_anverso->nombre) : base_url('assets/imgs/logos/no_disponible.png')?>"
							class="btn btn-sm btn-success btn_ver_imagen_modal"><i class="fa fa-eye"></i> Ver Cédula </button>
					</div>
				</div>
				<!-- /.card -->
			</div>

			<!-- cedula reverso -->
			<div class="col-sm-4">
				<div class="card card-danger card-outline">
					<div class="card-body box-profile">
						<div class="text-center">
							<img class="profile-user-img img-fluid img-circle img_foto_cedula_reverso" style="width: 100px; height: 100px;"
								 src="<?=isset($foto_cedula_reverso) ? base_url($foto_cedula_reverso->ruta_directorio.$foto_cedula_reverso->nombre) : base_url('assets/imgs/logos/no_disponible.png')?>"
								 alt="Cédula profesional reverso">
						</div>

						<h3 class="profile-username text-center">
							Cédula profesional (Reverso)
							<?php if(isset($foto_cedula_reverso)): ?>
								<a href="<?=base_url($foto_cedula_reverso->ruta_directorio.$foto_cedula_reverso->nombre)?>" class="btn btn-sm btn-success" target="_blank"><i class="fa fa-download"></i></a>
							<?php endif; ?>
						</h3>
					</div>
					<!-- /.card-body -->
					<div class="card-footer text-right">
						<input type="file" id="img_foto_cedula_reverso" data-div_procesando="#procesando_img_cedula_reverso" accept="image/*"
							   data-id_cat_expediente="3" data-img_destino=".img_foto_cedula_reverso" name="img_foto_cedula_reverso" class="archivo_expediente_imagen">
						<div id="procesando_img_cedula_reverso"></div>
						<button id="btn_visor_imagen_foto_cedula_reverso" type="button" 
							data-nombre_archivo="<?=isset($foto_cedula_reverso) ? $foto_cedula_reverso->nombre : 'Sin foto cargada al sistema' ?>"
							data-src_image="<?=isset($foto_cedula_reverso) ? base_url($foto_cedula_reverso->ruta_directorio.$foto_cedula_reverso->nombre) : base_url('assets/imgs/logos/no_disponible.png')?>"
							class="btn btn-sm btn-success btn_ver_imagen_modal"><i class="fa fa-eye"></i> Ver Cédula </button>
					</div>
				</div>
				<!-- /.card -->
			</div>
		</div>
	</div>

	<?php if(isset($usuario) && in_array($usuario->perfil,array('alumno'))): ?>
		<hr>
		<div class="form-group row">
			<label class="col-sm-12 text-justify">
				Doy mi consentimiento al CONOCER para que, en términos del articulo 22 de la LEY FEDERAL DE
				TRANSPARENCIA Y ACCESO A LA INFORMACIÓN PÚBLICA GUBERNAMENTAL, difunda, distribuya y publique la
				información contenida en el documento que se inscribe, para ser transmitida a instituciones públicas o
				privadas para agregar mi información a bolsas de trabajo electrónicas o en línea y facilitar mi
				localización en caso de que alguna otra institución pública o privada requiera personal con las
				competencias certificadas con las que cuento.
			</label>
			<div class="form-group clearfix col-sm-12 text-center">
				<div class="icheck-danger d-inline">
					<input type="radio" class="input_modificacion_update"
						   data-campo_actualizar="consentimiento_conocer"
						   data-tabla_actualizar="datos_usuario"
						   data-id_actualizar="id_datos_usuario"
						   data-id_actualizar_valor="<?=$datos_usuario->id_datos_usuario?>"
						   name="consentimiento_conocer" <?=isset($datos_usuario) && $datos_usuario->consentimiento_conocer == 'si' ? 'checked="checked"':''?> id="consentimiento_conocer_si" value="si">
					<label for="consentimiento_conocer_si">SI AUTORIZA</label>
				</div>
				<div class="icheck-success d-inline">
					<input type="radio" class="input_modificacion_update"
						   data-campo_actualizar="consentimiento_conocer"
						   data-tabla_actualizar="datos_usuario"
						   data-id_actualizar="id_datos_usuario"
						   data-id_actualizar_valor="<?=$datos_usuario->id_datos_usuario?>"
						   name="consentimiento_conocer" <?=isset($datos_usuario) && $datos_usuario->consentimiento_conocer == 'no' ? 'checked="checked"':''?> id="consentimiento_conocer_no" value="no">
					<label for="consentimiento_conocer_no">NO AUTORIZA</label>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div class="form-group row">
		<p class="text-sm text-muted">Tu firma digitalizada y toda la documentación que nos proporcionas será la para uso
			exclusivo de tu proceso de certificación, y contarás para la salvaguarda de tu identidad con un
			<a href="<?=base_url()?>assets/docs/aviso_privacidad_civik.pdf" target="_blank">"Aviso de privacidad para la protección de datos personales"</a>
			En términos de lo previsto en la Ley Federal de Protección de
			Datos Personales en Posesión de los Particulares. Para que de esta manera tu información e identidad, así como
			la aportación que hagas de tus datos Personales a nuestra entidad de certificación, estén plenamente protegidos
			en los Términos y Condiciones de las leyes mexicanas</p>
	</div>
<?php endif; ?>
