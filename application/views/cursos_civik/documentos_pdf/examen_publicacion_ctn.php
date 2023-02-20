<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Evaluacion Civika</title>

    <link href="<?= base_url() . 'extras/css/comunPDF.css' ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url() . 'extras/css/pdf/evaluacion_ctn.css' ?>" rel="stylesheet" type="text/css">

    <link href="<?= base_url() . 'extras/imagenes/logo/icono.png' ?>" rel="shortcut icon">
</head>
<body>

<table class="w100">
    <tr>
        <td class="derecha">
            <img src="<?= base_url() . 'extras/imagenes/logo/civika.png' ?>" width="130px" height="40px" alt=""/>
        </td>
    </tr>
</table>

<strong class="cuerpo_examen">EVALUACIÓN <?= strtoupper($tipo_evaluacion) ?></strong>
<br>
<span class="cuerpo_examen">Instrumento: <strong>CUESTIONARIO</strong></span>
<br>
<table class="w100 bordes cuerpo_examen">
    <tr>
        <td class="w26 relleno">Curso STPS</td>
        <td>
            <?=$publicacion->nombre?>
        </td>
    </tr>
    <tr>
        <td class="w26 relleno">Curso impartido</td>
        <td>
            <?=$publicacion->nombre_curso_comercial?>
        </td>
    </tr>
    <tr>
        <td class="relleno">Fecha de aplicación</td>
        <td></td>
    </tr>
    <tr>
        <td class="relleno">Nombre del capacitado</td>
        <td></td>
    </tr>
</table>
<br>
<strong class="cuerpo_examen">PROPOSITO DEL INSTRUMENTO</strong>
<br>
<span class="cuerpo_examen">
    Determinar si se lograron los objetivos y en qué médida para obtener la calificación <?= $tipo_evaluacion ?> del
    capacitado, asi como la valoración del programa educativo para una mejora continua
</span>

<br>
<strong class="cuerpo_examen">INSTRUCCIONES</strong>
<ul type="circle" class="cuerpo_examen">
    <li>Lea cuidadosamente cada uno de los reactivos antes de emitir su respuesta</li>
    <li>Dé a conocer sus dudas al responsable de la evaluación para un buen desarrollo</li>
    <li>El tiempo establecido para la aplicación de la evaluación será máximo 20 minutos</li>
    <li>
        Para los respuestas sombree o rellene su respuesta correcta
        <ul type="square" class="cuerpo_examen">
            <li>
                <input type="radio"/> Para esta opción sólo debe elegir una como respuesta correcta
            </li>
            <li>
                <input type="checkbox"/> Para esta opción debe elegir todas las que considere como respuesta correcta
            </li>
            <li>
                ___ Para esta opción solo ponga el número de la secuencia, o en su defecto los número que aparecen en la parte izquierda si es una pregunta de relación
            </li>
        </ul>
    </li>

</ul>

<?php foreach ($pregunta_publicacion_ctn as $index => $prt): ?>
    <p class="cuerpo_examen"><?= $index + 1 ?>.- <?= $prt->pregunta ?></p>

    <?php if (in_array($prt->id_opciones_pregunta, array(OPCION_VERDADERO_FALSO, OPCION_UNICA_OPCION, OPCION_IMAGEN_UNICA_OPCION))): ?>
        <table class="w100 cuerpo_examen">
            <?php foreach ($prt->opciones_pregunta_publicacion_ctn as $index_op => $opciones): ?>
                <?php if($index_op % 3 == 0): ?><tr><?php endif; ?>
                    <td class="w3 "><input type="radio"></td>
                    <td>
                        <?= $opciones->descripcion ?>
                        <?php if (isset($opciones->documento_imagen_respuesta) && is_object($opciones->documento_imagen_respuesta)): ?>
                            <div class="centrado">
                                <img class="img_examen" style="width: 100px !important;" src="<?= $opciones->documento_imagen_respuesta->ruta_documento ?>" alt="<?= $opciones->documento_imagen_respuesta->nombre ?>">
                            </div>
                        <?php endif; ?>
                    </td>
                <?php if($index_op % 4 == 0): ?></tr><?php endif; ?>
            <?php endforeach; ?>
        </table>

    <?php elseif (in_array($prt->id_opciones_pregunta, array(OPCION_OPCION_MULTIPLE, OPCION_IMAGEN_OPCION_MULTIPLE))): ?>

        <table class="w100 cuerpo_examen">
            <?php foreach ($prt->opciones_pregunta_publicacion_ctn as $index_op => $opciones): ?>
                <tr>
                    <td class="w3 "><input type="checkbox"></td>
                    <td>
                        <?= $opciones->descripcion ?>
                    </td>
                    <?php if (isset($opciones->documento_imagen_respuesta) && is_object($opciones->documento_imagen_respuesta)): ?>
                        <td class="izquierda">
                            <img class="img_examen" style="width: 100px !important;" src="<?= $opciones->documento_imagen_respuesta->ruta_documento ?>" alt="<?= $opciones->documento_imagen_respuesta->nombre ?>">
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </table>

    <?php elseif ($prt->id_opciones_pregunta == OPCION_SECUENCIAL): ?>

        <table class="w100 cuerpo_examen">
            <?php foreach ($prt->opciones_pregunta_publicacion_ctn as $opciones): ?>
                <tr>
                    <td class="w5 border_inferior td_preguntas_examen"></td>
                    <td>
                        <?= $opciones->descripcion ?>
                    </td>
                    <?php if (isset($opciones->documento_imagen_respuesta) && is_object($opciones->documento_imagen_respuesta)): ?>
                        <td class="izquierda">
                            <img class="img_examen" src="<?= $opciones->documento_imagen_respuesta->ruta_documento ?>" alt="<?= $opciones->documento_imagen_respuesta->nombre ?>">
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </table>

    <?php elseif ($prt->id_opciones_pregunta == OPCION_RELACIONAL): ?>

        <table class="w100 cuerpo_examen">
            <?php foreach ($prt->opciones_pregunta_publicacion_ctn_izq as $index => $opciones): ?>
                <tr>
                    <!-- izq -->
                    <td class="w5">
                        <strong><?= $opciones->consecutivo ?></strong>
                    </td>
                    <td class="w40">
                        <span><?= $opciones->descripcion ?></span>
                    </td>
                    <?php if (isset($opciones->documento_imagen_respuesta) && is_object($opciones->documento_imagen_respuesta)): ?>
                        <td>
                            <img class="img_examen" src="<?= $opciones->documento_imagen_respuesta->ruta_documento ?>" alt="<?= $opciones->documento_imagen_respuesta->nombre ?>">
                        </td>
                    <?php endif; ?>
                    <!-- der -->
                    <td class="w5">_____</td>
                    <td class="w40">
                        <?= $prt->opciones_pregunta_publicacion_ctn_der[$index]->descripcion ?>
                    </td>
                    <?php if (isset($prt->opciones_pregunta_publicacion_ctn_der[$index]->documento_imagen_respuesta) && is_object($prt->opciones_pregunta_publicacion_ctn_der[$index]->documento_imagen_respuesta)): ?>
                        <td>
                            <img class="img_examen"
                                 src="<?= $prt->opciones_pregunta_publicacion_ctn_der[$index]->documento_imagen_respuesta->ruta_documento ?>"
                                 alt="<?= $prt->opciones_pregunta_publicacion_ctn_der[$index]->documento_imagen_respuesta->nombre ?>">
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </table>

    <?php endif; ?>

<?php endforeach; ?>

</body>
</html>