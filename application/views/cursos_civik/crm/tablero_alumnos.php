<?php $this->load->view('default/header'); ?>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <label>Alumnos</label>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <th class="text-center" width="5%">#</th>
                        <th class="text-center">Nombre del alumno</th>
                        <th class="text-center">Datos de contacto</th>
                        <th class="text-center">Cursos disponibles</th>
                        <th class="text-center">Operaciones(avisado)</th>
                        <th class="text-center">Comentarios</th>
                        </thead>
                        <tbody>
                        <?php if (isset($listaUsuario) && is_array($listaUsuario) && sizeof($listaUsuario) != 0): ?>
                            <?php if (isset($cursos_disponibles) && is_array($cursos_disponibles) && sizeof($cursos_disponibles) != 0): ?>

                                <?php foreach ($listaUsuario as $index1 => $usuario): ?>
                                    <tr>
                                        <td class="text-center"> <?= $num = ($index1 + 1) ?></td>
                                        <td class="text-center"> <?= $usuario->nombre . ' ' . $usuario->apellido_p . ' ' . $usuario->apellido_m ?></td>
                                        <td class="text-center"> <?= 'Correo: ' . $usuario->correo . '<br>Telefono: ' . $usuario->telefono ?></td>
                                        <td class="text-center">
                                            <?php foreach ($cursos_disponibles as $index => $lista_cursos): ?>
                                                <tl class="list-group">
                                                    <?= $lista_cursos->nombre ?>
                                                </tl>
                                            <?php endforeach; ?>
                                        </td>
                                        <td class="text-center"><input type="radio" value="Si"
                                                                       name="curso_si_no<?php echo $index1; ?>"
                                                                       class="radio">Si
                                            <input type="radio" value="No"
                                                   name="curso_si_no<?php echo $index1; ?>"
                                                   class="radio">No
                                        </td>
                                        <td class="text-center"><textarea class="form-control" name=""
                                                                          placeholder="Comentario"></textarea></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div>
                    <button type="button" class="btn btn-outline-primary">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view('default/footer'); ?>