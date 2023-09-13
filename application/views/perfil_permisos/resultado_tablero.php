<?php if(isset($cat_modulo)): ?>
	<?php foreach ($cat_modulo as $cm): ?>
		<div class="col-md-3">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title"><?=$cm->nombre?></h3>
				</div>
				<!-- /.card-header -->
				<div class="card-body" style="display: block;">
					<?php if(isset($cat_permiso)): ?>
						<?php foreach ($cat_permiso as $cp): ?>
							<div class="form-group row">
								<div class="icheck-primary d-inline">
									<input type="checkbox" id="check_permiso_<?=$cm->id_cat_modulo.'_'.$cp->id_cat_permiso?>"
										   class="input_check_modulo_permiso" data-id_cat_modulo="<?=$cm->id_cat_modulo?>"
										   name="modulo_permiso_<?=$cm->id_cat_modulo.'_'.$cp->id_cat_permiso?>" value="<?=$cp->id_cat_permiso?>">
									<label for="check_permiso_<?=$cm->id_cat_modulo.'_'.$cp->id_cat_permiso?>"><?=$cp->nombre?></label>
								</div>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>
	<?php endforeach; ?>
<?php endif; ?>
