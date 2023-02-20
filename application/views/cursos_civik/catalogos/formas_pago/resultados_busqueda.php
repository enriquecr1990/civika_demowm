
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="text-center" width="12%">Banco</th>
                <th class="text-center" width="12%">Sucursal</th>
                <th class="text-center" width="12%">Titular</th>
                <th class="text-center" width="12%">Cuenta</th>
                <th class="text-center" width="12%">Numero de Tarjeta</th>
                <th class="text-center" width="12%">Clabe</th>
                <th class="text-center" width="15%">Titulo Forma de Pago</th>
                <th class="text-center" width="15%">
                    <button class="btn btn-info btn-sm btn-pill agregar_nueva_formas_pago">
                        Nueva forma pago
                    </button> <hr>
                    <a class="btn btn-pill btn-sm btn-success" href="<?=base_url()?>DocumentosPDF/formato_pago/" target="_blank">Ver PDF</a>
                </th>
            </tr>
        </thead>
        <tbody class="tbodyFormasPago">
            <?php if(isset($catalogo_formas_pago) && is_array($catalogo_formas_pago) && sizeof($catalogo_formas_pago) != 0): ?>
            <?php foreach ($catalogo_formas_pago as $index => $a): ?>

                <tr>
                    <td><?=$a->banco?></td>
                    <td><?=$a->sucursal?></td>
                    <td><?=$a->titular?></td>
                    <td><?=$a->cuenta?></td>
                    <td><?=$a->numero_tarjeta?></td>
                    <td><?=$a->clabe?></td>
                    <td><?=$a->titulo_pago?></td>

                    <td class="text-center">
                        <button class="btn btn-primary btn-pill btn-sm modificar_formas_pago" data-toggle="tooltip"
                        title="Modificar forma de pago" data-placement="bottom"
                        data-id_catalogo_formas_pago="<?=$a->id_catalogo_formas_pago?>">
                        <i class="fa fa-pencil"></i>
                    </button>
                    <?php if($index != 0): ?>
                        <button class="btn btn-danger btn-pill btn-sm eliminar_formas_pago" data-toggle="tooltip"
                        data-url_operacion="<?=base_url().'AdministrarCatalogos/eliminar_catalogo_formas_pago/'.$a->id_catalogo_formas_pago?>"
                        data-msg_operacion="Se eliminará la forma de pago del sistema <label>¿deseá continuar?</label>"
                        data-btn_trigger="#btn_buscar_formas_pago"
                        title="Eliminar forma de pago" data-placement="bottom">
                        <i class="fa fa-trash"></i>
                    </button>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
</div>
<script src="<?=base_url().'extras/plugins/tinymce-master/plugin/tinymce/tinymce.min.js'?>" ></script>
<script src="<?=base_url().'extras/plugins/tinymce-master/plugin/tinymce/init-tinymce.js'?>" ></script>




<div class="rows">
    <form id="form_detalle_pdf_forma_pago" action="<?=base_url()?>AdministrarCatalogos/formas_pago" method="post">
        <input type="hidden" name="id_catalogo_forma_pago_detalle" value="<?=$catalogo_forma_pago_detalle->id_catalogo_forma_pago_detalle?>">
        <div class="container">
            <div class="col-md-12">
                <div class="form-group">
                    <textarea class="tinymce" id="texto" name="detalle_pdf"><?=$catalogo_forma_pago_detalle->descripcion?></textarea>
                </div> 
                <div class="col-md-12" style="text-align:right">
                    <button  type="submit" class="btn btn-pill btn-success btn-sm">Guardar</button>
                </div>
            </div>
        </div>
    </form>
</div>