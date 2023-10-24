
<?php foreach ($tabla as $index => $item): ?>
	<tr>
		<th scope="row"><?=$item->id_cat_sector_ec?></th>
		<td><?=$item->nombre?></td>
		<td>
			<button type="button" data-id_estandar_competencia="<?=$item->id_cat_sector_ec?>"
					data-toggle="tooltip" title="Modificar sector"
					class="btn btn-sm btn-outline-primary modificar_sector" data-id="<?= $item->id_cat_sector_ec ?>"><i class="fa fa-edit"></i> Editar</button>

			<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion"
					data-toggle="tooltip" title="Eliminar sector"
					data-msg_confirmacion_general="¿Esta seguro de eliminar el sector?, esta acción no podrá revertirse"
					data-url_confirmacion_general="<?=base_url()?>Catalogos/eliminar_sector/<?=$item->id_cat_sector_ec?>"
					data-btn_trigger="#btn_buscar_sectores">
				<i class="fas fa-trash"></i> Eliminar
			</button>
		</td>
	</tr>
<?php endforeach; ?>
