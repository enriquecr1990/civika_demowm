<div class="card">
    <div class="card-header">
        <label>Tablero de asistencia</label>
    </div>
    <div class="card-body">

        <button type="button" id="buscar_tablero_asistencia" class="noview">sumatoria</button>

        <div class="table-responsive">
            <table class="table table-striped " id="tbl_asistencia_alumnos">
                <thead>
                <tr>
                    <th width="50%">Curso/Denominacion</th>
                    <th>
                        Tipo de curso
                    </th>
                    <th class="text-center">Instructor(es)</th>
                    <th class="text-center">Fecha de impartición</th>
                    <th class="text-center">Alumnos que asistieron</th>
                </tr>
                </thead>
                <tbody class="tbody_tablero_asistencia">
                <?php if(isset($array_asistencia_cursos) && is_array($array_asistencia_cursos) && sizeof($array_asistencia_cursos) !=0): ?>
                    <?php foreach ($array_asistencia_cursos as $index => $curso): ?>
                    <tr>
                        <td>
                            <ul>
                                <li><span class="negrita">Nombre DC-3:</span><span><?=$curso->nombre_dc3?></span></li>
                                <li><span class="negrita">Nombre Comercial:</span><span><?=$curso->nombre_curso_comercial?></span></li>
                            </ul>
                        </td>
                        <td>
                            <span class="badge badge-info"><?=$curso->tipo_publicacion?></span>
                        </td>
                        <td class="text-center"><?=$curso->instructor?></td>
                        <td class="text-center"><?=fechaBDToHtml($curso->fecha_imparticion)?></td>
                        <td class="text-center">
                            <input type="hidden" class="asistieron" value="<?=$curso->asistieron?>">
                            <span><?=$curso->asistieron?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Sin registro de cursos en el sistema</td>
                    </tr>
                <?php endif;?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="4" class="text-right"><label>Total:</label></td>
                    <td class="text-center"><span id="total_asistencia"></span></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>