<div class="card">
    <div class="card-header">
        <label>Cotizaciones de Cursos STPS</label>
    </div>
    <div class="card-body">

        <!-- paginacion -->
        <?php
        $data_paginacion = array(
            'url_paginacion' => 'Cotizaciones/buscar_cotizaciones',
            'conteiner_resultados' => '#contenedor_resultados_tablero',
            'form_busqueda' => 'form_buscar_cotizaciones_todas',
            'id_paginacion' => uniqid(),
            'tipo_registro' => 'cotizaciones'
        );
        $this->load->view('default/paginacion_tablero',$data_paginacion);
        ?>

        <div class="table-responsive">
            <table class="table table-striped ">
                <thead>
                <tr>
                    <!---<th>#</th>-->
                    <th></th>
                    <th>Curso</th>
                    <th>Fechas</th>
                    <th width="30%" class="text-center">Detalle</th>
                    <th class="text-center" >Participantes</th>
                    <th class="text-center">Duración</th>
                    <th class="text-center">Costo</th>
                    <?php if(isset($usuario) && ($usuario->tipo_usuario == 'administrador') || $usuario->tipo_usuario == 'admin'): ?>
                        <th  class="text-center" width="10%">
                            <button id="agregar_cotizacion_nueva" class="btn btn-primary btn-sm btn-pill">
                                Nueva cotización
                            </button>
                        </th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody class="tbody_cotizaciones">
                <?php if(isset($array_cotizaciones) && is_array($array_cotizaciones) && sizeof($array_cotizaciones) != 0): ?>
                    <?php foreach ($array_cotizaciones as $index => $ac): ?>
                    <tr>
                        <!--
                        <td>
                            <?=$pagina_select == 1 ? $index + 1 : (($pagina_select * $limit_select) - ($limit_select - ($index + 1)))?>
                        </td>
                        -->
                        <td class="text-center">
                            <?php if(!is_null($ac->id_publicacion_ctn) && $ac->dias_vigencia < 0): ?>
                                <img src="<?=base_url()?>extras/imagenes/semaforo/7.png" class="semaforo_cotizacion">
                            <?php else: ?>
                                <img src="<?=base_url()?>extras/imagenes/semaforo/<?=$ac->id_catalogo_proceso_cotizacion?>.png" class="semaforo_cotizacion">
                            <?php endif; ?>
                        </td>
                        <td><?=$ac->nombre?></td>
                        <td class="text-justify">
                            <ul>
                                <li class="mb-1"><span class="negrita">De cotización: </span><?=existe_valor($ac->fecha_cotizacion) ? fechaHoraBDToHTML($ac->fecha_cotizacion):'Sin fecha'?></li>
                                <li class="mb-1"><span class="negrita">Enviada: </span><?=existe_valor($ac->fecha_envio) ? fechaHoraBDToHTML($ac->fecha_envio):'Sin fecha'?></li>
                                <li class="mb-1"><span class="negrita">Recibida: </span><?=existe_valor($ac->fecha_recepcion) ? fechaHoraBDToHTML($ac->fecha_recepcion):'Sin fecha'?></li>
                                <li class="mb-1"><span class="negrita">Orden de compra: </span><?=existe_valor($ac->fecha_recepcion) ? fechaHoraBDToHTML($ac->fecha_recepcion):'Sin fecha'?></li>
                                <li class="mb-1"><span class="negrita">Vigencia: </span><?=existe_valor($ac->fecha_fin_vigencia) ? fechaHoraBDToHTML($ac->fecha_fin_vigencia):'Sin fecha'?></li>
                                <li class="mb-1"><span class="negrita">Días de vigencia: </span><span class="badge badge-<?=$ac->dias_vigencia < 0 ? 'danger':'info'?>"><?=$ac->dias_vigencia < 0 ? 'Vencido':$ac->dias_vigencia?></span></li>
                            </ul>
                        </td>
                        <td class="text-justify">
                            <ul>
                                <li class="mb-1"><span class="negrita">Folio cotización: </span><?=$ac->folio_cotizacion?></li>
                                <li class="mb-1"><span class="negrita">Empresa: </span><?=$ac->empresa?></li>
                                <li class="mb-1"><span class="negrita">Persona que recibe: </span><?=$ac->persona_recibe?></li>
                                <li class="mb-1"><span class="negrita">Correo: </span><?=$ac->correo?></li>
                                <?php if(existe_valor($ac->folio_orden_compra)): ?>
                                    <li class="mb-1"><span class="negrita">Orden de compra: </span><?=$ac->folio_orden_compra?></li>
                                    <?php if(existe_valor($ac->comprobante_xml)): ?>
                                        <li class="mb-1">
                                            <a class="btn btn-sm btn-pill btn-info" target="_blank" href="<?=$ac->comprobante_xml?>">Comprobante XML</a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if(existe_valor($ac->comprobante_pdf)): ?>
                                        <li class="mb-1">
                                            <a class="btn btn-sm btn-pill btn-danger" target="_blank" href="<?=$ac->comprobante_pdf?>">Comprobante PDF</a>
                                        </li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </ul>
                        </td>
                        <td class="text-center"><?=$ac->participantes?></td>
                        <td class="text-center"><?=$ac->duracion?> horas</td>
                        <td class="text-center">
                            <span class="negrita"><?=isset($usuario) && is_object($usuario) && ($usuario->tipo_usuario == 'administrador' || $usuario->tipo_usuario == 'admin') ? 'Total: ':''?></span>
                            $<?=!is_null($ac->iva) && $ac->iva != '' && $ac->iva != 0 ?
                                number_format(($ac->duracion * $ac->costo_hora) * (1 + ($ac->iva/100)),2) :
                                number_format($ac->duracion * $ac->costo_hora,2)?>
                            <?php if(isset($usuario) && ($usuario->tipo_usuario == 'administrador') || $usuario->tipo_usuario == 'admin'): ?>
                            <ul>
                                <li><span class="negrita">Precio por hora: </span>$<?=number_format($ac->costo_hora,2)?></li>
                                <li><span class="negrita">IVA: </span><?=$ac->iva?>%</li>
                            </ul>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <ul>
                                <li class="mb-1">
                                    <a class="btn btn-pill btn-sm btn-success" href="<?=base_url()?>DocumentosPDF/cotizacion/<?=$ac->id_cotizacion?>" target="_blank">Ver PDF</a>
                                </li>
                                <?php if(isset($usuario) && ($usuario->tipo_usuario == 'administrador') || $usuario->tipo_usuario == 'admin'): ?>
                                    <?php if(in_array($ac->id_catalogo_proceso_cotizacion,array(COTIZACION_REALIZADA,COTIZACION_ENVIADA,COTIZACION_RECIBIDA,COTIZACION_CERRADA_CANCELADA))): ?>
                                        <li class="mb-1">
                                            <button type="button" class="btn btn-sm btn-pill btn-warning modificar_cotizacion" data-id_cotizacion="<?=$ac->id_cotizacion?>">Modificar</button>
                                        </li>
                                    <?php endif; ?>
                                    <?php if($ac->id_catalogo_proceso_cotizacion == COTIZACION_REALIZADA): ?>
                                        <li class="mb-1">
                                            <button type="button" class="btn btn-sm btn-pill enviar_cotizacion_empresa"
                                                    data-url_operacion="<?=base_url().'Cotizaciones/enviar_cotizacion_empresa/'.$ac->id_cotizacion?>"
                                                    data-msg_operacion='Se enviará la cotización a la empresa al correo registrado "<?=$ac->correo?>" <span class="negrita">¿Deseá continuar?</span>'
                                                    data-btn_trigger="#btn_buscar_cotizaciones">Enviar a empresa</button>
                                        </li>
                                    <?php endif; ?>
                                    <?php if($ac->id_catalogo_proceso_cotizacion == COTIZACION_ORDEN_COMPRA): ?>
                                        <li class="mb-1">
                                            <button type="button" class="btn btn-primary btn-sm btn-pill publicar_curso_masivo_civik"
                                                    data-toggle="tooltip" data-id_curso_taller_norma="<?=$ac->id_curso_taller_norma?>"
                                                    data-id_cotizacion="<?=$ac->id_cotizacion?>"
                                                    title="Publicar curso masivo para empresas">
                                                <i class="fa fa-paper-plane"></i> Publicar a empresa
                                            </button>
                                        </li>

                                        <li class="mb-1">
                                            <div class="file_upload_civik btn btn-sm btn-info btn-pill" id="upload_recibo_pago_civik_xml">
                                                <label for="input_recibo_pago_xml" class="col-form-label">Subir XML</label>
                                                <input id="input_recibo_pago_xml" type="file" class="upload_civika file_upload_comprobante_xml"
                                                       accept="application/xml" name="comprobante_xml" data-id_cotizacion="<?=$ac->id_cotizacion?>">
                                            </div>
                                        </li>
                                        <li class="mb-1">
                                            <span id="carga_comprobante_xml_<?=$ac->id_cotizacion?>" class="badge badge-info"></span>
                                        </li>
                                        <li class="mb-1">
                                            <div class="file_upload_civik btn btn-sm btn-danger btn-pill" id="upload_recibo_pago_civik_pdf">
                                                <label for="input_recibo_pago_pdf" class="col-form-label">Subir PDF</label>
                                                <input id="input_recibo_pago_pdf" type="file" class="upload_civika file_upload_comprobante_pdf"
                                                       accept="application/pdf" name="comprobante_pdf" data-id_cotizacion="<?=$ac->id_cotizacion?>">
                                            </div>
                                        </li>
                                        <li class="mb-1">
                                            <span id="carga_comprobante_pdf_<?=$ac->id_cotizacion?>"></span>
                                        </li>
                                        <span class="help-span">Si ya subio el comprante y desea cambiarlo, subalos nuevamente</span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </ul>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td class="text-center" colspan="<?=isset($usuario) && ($usuario->tipo_usuario == 'administrador' || $usuario->tipo_usuario == 'admin') ? '8':'7'?>">
                            Sin registro de cotizaciones en el sistema
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="row">
            <?php foreach ($catalogo_proceso_cotizacion as $cpc): ?>
                <div>
                    <img src="<?=base_url()?>extras/imagenes/semaforo/<?=$cpc->id_catalogo_proceso_cotizacion?>.png" class="semaforo_cotizacion"> <span><?=$cpc->nombre?></span>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>