<input type="hidden" id="inp_notificaciones_no_leidas" value="<?=$num_no_leidas?>">
<div class="card card-primary card-outline">
	<div class="card-header">
		<h3 class="card-title" id="titulo_mensajes_carpeta">Recibidas</h3>

		<!--<div class="card-tools">
			<div class="input-group input-group-sm">
				<input type="text" class="form-control" placeholder="Buscar notificación">
				<div class="input-group-append">
					<div class="btn btn-primary">
						<i class="fas fa-search"></i>
					</div>
				</div>
			</div>
		</div>-->
		<!-- /.card-tools -->
	</div>
	<!-- /.card-header -->
	<div class="card-body p-0">
		<div class="table-responsive mailbox-messages">
			<?php if(isset($notificacion) && is_array($notificacion) && sizeof($notificacion) > 0): ?>
				<table class="table table-hover table-striped">
					<thead>
					<tr>
						<th></th>
						<th>Cuando</th>
						<th><?=isset($tipo) && $tipo == 'recibidos' ? 'Remitente' : 'Destinatario'?></th>
						<th>Asunto</th>
						<th></th>
						<th>Operaciones</th>
					</tr>
					</thead>
					<tbody>
						<?php foreach ($notificacion as $n): ?>
							<tr <?=$n->notificacion_leida ? '':'style="background-color: #92FF0000"'?>>
								<td>
									<?php if($n->notificacion_leida): ?>
										<i class="fa fa-envelope-open" style="color: green"></i>
									<?php else: ?>
										<i class="fa fa-envelope" style="color: rgba(255,0,0,0.57)"></i>
									<?php endif; ?>
								</td>
								<td class="mailbox-star"><i class="fas fa-calendar"></i> <?=fechaHoraBDToHTML($n->fecha)?> </td>
								<td class="mailbox-name"><?=isset($tipo) && $tipo == 'recibidos' ? $n->remitente : $n->destinatario?></td>
								<td class="mailbox-subject"><b><?=$n->asunto?></b>
								</td>
								<?php if(isset($n->archivos) && is_array($n->archivos) && sizeof($n->archivos) != 0): ?>
									<td class="mailbox-attachment"><i class="fas fa-paperclip"></i></td>
								<?php else: ?>
									<td></td>
								<?php endif; ?>
								<td>
									<button type="button" class="btn btn-default btn-sm ver_notificacion" data-id_notificacion="<?=$n->id_notificacion?>"><i class="fa fa-eye"></i> Ver</button>
									<!--<button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>-->
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<!-- /.table -->
			<?php else: ?>
				<?php $this->load->view('default/sin_datos'); ?>
			<?php endif; ?>
		</div>
		<!-- /.mail-box-messages -->
	</div>
	<!-- /.card-body -->
</div>
<!-- /.card -->
