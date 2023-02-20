<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>

<div id="conteniner_mensajes_sistema_asea"></div>

<div class="container">

    <div class="panel panel-success">
        <div class="panel-heading">Configuración general de la cuenta</div>
        <div class="panel-body">

            <div class="row">
                <?php if (isset($usuario->es_administrador) && $usuario->es_administrador && $usuario->update_password == 0): ?>
                    <div class="form-group" id="msg_cambio_pass_asea">
                        <div class="col-sm-12 col-md-12">
                            <div class="alert alert-info">
                                <i class="glyphicon glyphicon-warning-sign"></i>&nbsp;<label><?= $usuario->nombre . ' ' . $usuario->apellido_p ?></label> por seguridad, le recomendamos actualizar sus datos de acceso en el sistema.
                                Por única ocasión, adicional de su contraseña tiene la posibilidad de cambiar su usuario en el sistema.
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>


            <div class="panel panel-default">
                <div class="panel-heading">Mis datos</div>
                <div class="panel-body form_configuracion_usuario">
                    <?php $this->load->view('asea/control_usuarios/FormConfiguracionUsuario')?>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="conteiner_agregar_modificar_usuario_admin"></div>
<div id="conteiner_agregar_modificar_es"></div>
<div id="conteiner_modificar_empleado_es_sistema"></div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>