<div class="modal fade" role="dialog" id="modal_registro_estacion_servicio">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?=isset($estacion_servicio) ? 'Modifique' : 'Registre'?> su estación de servicio</h4>
            </div>
            <form class="form-horizontal" id="form_registro_es">

                <?php if(isset($es_configuracion) && $es_configuracion): ?>
                    <input type="hidden" name="es_configuracion" value="1">
                <?php endif; ?>

                <input type="hidden" name="estacion_servicio[id_estacion_servicio]" value="<?=isset($estacion_servicio) ? $estacion_servicio->id_estacion_servicio :''?>">
                <input type="hidden" name="estacion_servicio_tiene_documento[id_estacion_servicio]" value="<?=isset($estacion_servicio) ? $estacion_servicio->id_estacion_servicio :''?>">
                <input type="hidden" name="estacion_servicio[id_usuario]" value="<?=isset($estacion_servicio) ? $estacion_servicio->id_usuario :''?>">
                <div id="conteiner_mensaje_registro_es"></div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="es_nombre">Nombre:</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="es_nombre" placeholder="Nombre de la estación de servicio"
                                   data-rule-required="true" name="estacion_servicio[nombre]"
                                   value="<?=isset($estacion_servicio) ? $estacion_servicio->nombre : ''?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="es_rfc" >RFC:</label>
                        <div class="col-sm-9">
                            <input class="form-control input_rfc" id="es_rfc" placeholder="RFC de la estación de servicio"
                                   data-rule-maxlength="13" data-rule-required="true" name="estacion_servicio[rfc]"
                                   value="<?=isset($estacion_servicio) ? $estacion_servicio->rfc : ''?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="es_domicilio" >Domicilio:</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="es_domicilio" placeholder="Escriba el domicilio de la estación de servicio"
                                   data-rule-required="true" data-rule-maxlength="300" data-rule-minlength="15" name="estacion_servicio[domicilio]"
                                   value="<?=isset($estacion_servicio) ? $estacion_servicio->domicilio : ''?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="es_telefono" >Teléfono:</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="es_telefono" placeholder="Número de teléfono"
                                   data-rule-required="true" name="estacion_servicio[telefono]"
                                   value="<?=isset($estacion_servicio) ? $estacion_servicio->telefono : ''?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="es_telefono" >Correo:</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="es_correo" placeholder="Correo electrónico"
                                   data-rule-required="true" data-rule-email="true" name="estacion_servicio[correo]"
                                   value="<?=isset($estacion_servicio) ? $estacion_servicio->correo : ''?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="es_representante" >Representante legal:</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="es_representante" placeholder="Nombre del representante legal de la Estación de Servicio"
                                   data-rule-required="true" data-rule-maxlength="300" data-rule-minlength="15" name="estacion_servicio[representante_legal]"
                                   value="<?=isset($estacion_servicio) ? $estacion_servicio->representante_legal : ''?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="es_logo" >Logo:</label>
                        <div class="col-sm-1">
                            <input type="file" class="file fileLogoEstacionServicio" type="file" name="es_logo_registro" >
                        </div>
                        <div class="col-sm-8 centrado" id="es_logo_registro_file">
                            <?php if(isset($documento_asea)){?>
                                <input type="hidden" name="estacion_servicio_tiene_documento[id_documento_asea]" value="<?=$documento_asea->id_documento_asea?>">
                                <button type="button" class="btn btn-info btn-xs popoverShowImage"
                                        data-nombre_archivo="<?=$documento_asea->nombre?>"
                                        data-src_image="<?=base_url().$documento_asea->ruta_directorio.$documento_asea->nombre?>"><i class="glyphicon glyphicon-eye-open"></i>Ver logo</button>
                                <button type="button" class="btn btn-danger btn-xs eliminar_logo_registro_es"
                                        data-id_documento_asea="<?=$documento_asea->id_documento_asea?>">
                                    <i class="glyphicon glyphicon-trash"></i>Eliminar logo
                                </button>
                            <?php }?></div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="es_usuario">Usuario:</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="es_usuario" placeholder="Usuario Estación de servicio"
                                   data-rule-required="true" data-rule-minlegth="8" name="usuario[usuario]"
                                <?=isset($usuario_estacion) ? 'disabled="disabled"' : ''?>
                                   value="<?=isset($usuario_estacion) ? $usuario_estacion->usuario : ''?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="es_password">Constraseña:</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="password"
                                   data-rule-minlength="8" id="es_password" placeholder="Constraseña"
                                   data-rule-required="true" name="usuario[password]"
                                   value="<?=isset($usuario_estacion) ? $usuario_estacion->password : ''?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12" style="text-align: center">
                            <button type="button" class=" btn btn-success btn-sm <?=isset($nuevo) && $nuevo ? 'guardar_nueva_estacion_registro_es':'guardar_registro_es'?>">Aceptar</button>
                            <button type="button" class=" btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>