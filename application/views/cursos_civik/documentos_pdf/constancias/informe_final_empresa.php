<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Informe Final</title>
    <link href="<?= base_url() . 'extras/css/comunPDF.css' ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url() . 'extras/css/contanciaDC3.css' ?>" rel="stylesheet" type="text/css">
    <style type="text/css">
        #body_informe_final {
            font-size: 8px !important;
        }
    </style>
</head>
<body>

<div class="constancia_dc3">
    <table width="100%">
        <tr>
            <td width="10%"></td>
            <td class="izquierda">
                <?php if (isset($logo_empresa) && $logo_empresa !== false): ?>
                    <img src="<?= base_url() . $logo_empresa->ruta_directorio . $logo_empresa->nombre ?>" width="150px"
                         height="60px">
                <?php endif; ?>
            </td>
            <td class="derecha">
                <img src="<?= base_url('extras/imagenes/logo-civik.png') ?>" width="150px" height="60px">
            </td>
            <td width="10%"></td>
        </tr>
    </table>

    <div class="salto_linea"></div>

    <!-- datos generales -->
    <table width="100%" border="1">
        <tr>
            <td colspan="2" class="titulo_tabla_carta_descriptiva">CARTA DESCRIPTIVA</td>
        </tr>
        <tr>
            <td class="w33 negrita contenido_celda fondo_celda">Denominación:</td>
            <td class="contenido_celda"><?= $carta_descriptiva->nombre_dc3 ?></td>
        </tr>
        <tr>
            <td class="negrita contenido_celda fondo_celda">Duración:</td>
            <td class="contenido_celda"><?= number_format($carta_descriptiva->duracion, 0) ?> hrs</td>
        </tr>
        <tr>
            <td class="negrita contenido_celda fondo_celda">Fecha inicio:</td>
            <td class="contenido_celda"><?= fechaBDToHtml($carta_descriptiva->fecha_inicio) ?></td>
        </tr>
        <tr>
            <td class="negrita contenido_celda fondo_celda">Fecha de finalización:</td>
            <td class="contenido_celda"><?= fechaBDToHtml($carta_descriptiva->fecha_fin) ?></td>
        </tr>
        <tr>
            <td class="negrita contenido_celda fondo_celda">Área tempática:</td>
            <td class="contenido_celda"><?= $carta_descriptiva->area_tematica ?></td>
        </tr>
        <tr>
            <td class="negrita contenido_celda fondo_celda">Nombre y registro STPS de la Institución capacitadora:</td>
            <td class="contenido_celda"><?= $carta_descriptiva->agente_capacitador ?></td>
        </tr>
        <tr>
            <td class="negrita contenido_celda fondo_celda">Nombre del instructor:</td>
            <td class="contenido_celda"><?= $carta_descriptiva->instructor ?></td>
        </tr>
        <tr>
            <td class="negrita contenido_celda fondo_celda">Lugar de impartición:</td>
            <td class="contenido_celda"><?= $carta_descriptiva->lugar_imparticion ?></td>
        </tr>
        <tr>
            <td class="negrita contenido_celda fondo_celda">Número de Participantes:</td>
            <td class="contenido_celda"><?=sizeof($empleados_curso)?></td>
        </tr>
        <tr>
            <td class="negrita contenido_celda fondo_celda">Número de DC-3 entregadas:</td>
            <td class="contenido_celda"><?=$constancias_dc3_entregadas?></td>
        </tr>
        <tr>
            <td class="negrita contenido_celda fondo_celda">Promedio Grupal Evaluación Diagnóstica:</td>
            <td class="contenido_celda"><?=$promedio_evaluacion_diagnostica?></td>
        </tr>
        <tr>
            <td class="negrita contenido_celda fondo_celda">Promedio Grupal Evaluación Final:</td>
            <td class="contenido_celda"><?=$promedio_evaluacion_final?></td>
        </tr>
    </table>

    <div class="salto_linea"></div>

    <table width="100%" border="1">
        <tr>
            <td colspan="6" class="titulo_tabla_carta_descriptiva">RELACIÓN DE PARTICIPANTES</td>
        </tr>
        <tr>
            <td class="centrado vertical-center contenido_celda w5 fondo_celda">#</td>
            <td class="centrado vertical-center w45 contenido_celda fondo_celda">Apellido Paterno – Apellido Materno – Nombre(s)</td>
            <td class="contenido_celda centrado fondo_celda">Asistencia (porcentaje)</td>
            <td class="contenido_celda centrado fondo_celda">Calificación Evaluación Diagnóstica</td>
            <td class="contenido_celda centrado fondo_celda">Calificación Evaluación Final</td>
            <td class="contenido_celda centrado fondo_celda">Acreditación para la Constancia</td>
        </tr>
        <?php if (isset($empleados_curso) && is_array($empleados_curso) && sizeof($empleados_curso) != 0): ?>
            <?php $nombre_empresa = $empleados_curso[0]->nombre_empresa; ?>
            <?php foreach ($empleados_curso as $index => $ec): ?>
            <tr>
                <td  class="contenido_celda fondo_celda"><?=$index + 1?></td>
                <td class="contenido_celda"><?=$ec->Nombre_alumno?></td>
                <td class="contenido_celda centrado"><?=number_format($ec->perciento_asistencia,0)?>%</td>
                <td class="contenido_celda centrado"><?=number_format($ec->calificacion_diagnostica,2)?></td>
                <td class="contenido_celda centrado"><?=number_format($ec->calificacion_final,2)?></td>
                <td class="contenido_celda centrado">
                    <?=$ec->calificacion_final < 80 ? '<span class="requerido">No</span>':'Si'?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>

    <div class="salto_linea"></div>

    <?php if(isset($pregunta_encuesta_satisfaccion)): ?>
        <table width="100%" border="1">
            <tr>
                <td colspan="9" class="titulo_tabla_carta_descriptiva">ENCUESTA DE SATISFACIÓN DE LOS PARTICIPANTES</td>
            </tr>
            <tr>
                <td rowspan="2" class="centrado vertical-center contenido_celda w5 fondo_celda">#</td>
                <td rowspan="2" colspan="3" class="centrado vertical-center w45 contenido_celda fondo_celda">Reactivo</td>
                <td colspan="5" class="centrado contenido_celda fondo_celda">Respuestas de los participantes</td>
            </tr>
            <tr>
                <?php foreach ($encabezados_preguntas as $ep): ?>
                    <td class="centrado w10 contenido_celda fondo_celda"><?= $ep->opcion ?></td>
                <?php endforeach; ?>
            </tr>
            <?php foreach ($pregunta_encuesta_satisfaccion as $index => $pes): ?>
                <?php if ($index != 10): ?>
                    <tr>
                        <td class="contenido_celda fondo_celda centrado">
                            <?= $index + 1 ?>
                        </td>
                        <td class="contenido_celda" colspan="3">
                            <?= $pes->pregunta ?>
                        </td>
                        <?php foreach ($pes->opcion_respuesta_encuesta_satisfaccion as $ores): ?>
                            <td class="contenido_celda">
                                <?= $ores->respuesta ?> %
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td class="contenido_celda fondo_celda centrado"><?= $index + 1 ?></td>
                        <td class="contenido_celda fondo_celda" colspan="8">Considero que el siguiente curso debe ser sobre:</td>
                            <?= $pes->pregunta ?>
                        </td>
                    </tr>

                    <tr>
                        <?php foreach ($pes->opcion_respuesta_encuesta_satisfaccion as $index => $ores): ?>
                            <td class="contenido_celda fondo_celda centrado" <?=$index == 0 ? 'colspan="2"':''?> ><?= $ores->opcion ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <?php foreach ($pes->opcion_respuesta_encuesta_satisfaccion as $index => $ores): ?>
                            <td class="contenido_celda" <?=$index == 0 ? 'colspan="2"':''?>>
                                <?= $ores->respuesta ?> %
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <div class="salto_linea"></div>
    <div class="salto_linea"></div>

    <table width="100%" border="1">
        <tr>
            <td class="w10 border_no_superior border_no_inferior border_no_izquierdo"></td>
            <td class="centrado contenido_celda">
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                _________________________________
                <br><?=$carta_descriptiva->instructor?>
                <br>Instructor
            </td>
            <td class="w10 border_no_superior border_no_inferior"></td>
            <td class="centrado contenido_celda">
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                _________________________________
                <br>Nombre y firma
                <br>Responsable del área
                <br><?=$nombre_empresa?>
            </td>
            <td class="w10 border_no_superior border_no_inferior border_no_derecho"></td>
        </tr>
    </table>


</div>
</body>
</html>