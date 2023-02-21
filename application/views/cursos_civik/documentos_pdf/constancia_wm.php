<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Evaluacion Civika</title>

    <link href="<?= base_url() . 'extras/css/comunPDF.css' ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url() . 'extras/css/pdf/evaluacion_ctn.css' ?>" rel="stylesheet" type="text/css">

    <link href="<?= base_url('extras/css/constanciaDC3.css') ?>" rel="stylesheet" type="text/css">

    <link href="<?= base_url() . 'extras/imagenes/logo/icono.png' ?>" rel="shortcut icon">
</head>
<body>

<!-- evaluacion de conocimientos formato WM -->
<table class="w100">
    <tr>
        <td class="derecha">
            <img src="<?= base_url() . 'extras/imagenes/logo/certificacion_wm.png' ?>" width="100%" height="190px" alt=""/>
        </td>
    </tr>
</table>
<br>
<span class="titulo_evaluacion_conocimientos">EVALUACIÓN DE CONOCIMIENTOS</span>
<br>
<br>
<span class="titulo_evaluacion_conocimientos"><strong><?=isset($publicacion->nombre) ? $publicacion->nombre : 'SUPERVISIÓN DE SEGURIDAD EN OBRAS NUEVAS Y REMODELACIONES PARA CASCO ROJO DE CONTRATISTAS.'?></strong></span>
<br>
<br>

<!-- datos del usuario -->
<table class="w100">
    <tr>
        <td class="w-50 izquierda">
            <?php if(isset($usuario->foto_perfil) && is_object($usuario->foto_perfil)): ?>
                <img src="<?=$usuario->foto_perfil->ruta_documento?>" class="img_evaluacion_conocimiento">
            <?php else: ?>
                <img src="<?=base_url()?>extras/imagenes/logo/person.png">
            <?php endif; ?>
            <br>
            <span class="titulo_empresa"><?=$empresa->nombre?></span>
            <br>
            <span class="texto_ayuda_evaluacion">Empresa contratista</span>
        </td>
        <td class="w-50 bordes centrado">
            <span class="titulo_calificacion" style="width: 100% !important;">CALIFICACIÓN</span>
            <br>
            <?php $color_calificacion = 'red';
            if($calificacion > 79 && $calificacion < 95){
                $color_calificacion = 'yellow';
            }if($calificacion > 94){
                $color_calificacion = 'green';
            }
            ?>

            <span class="calificacion" style="color: <?=$color_calificacion?>"><?=$calificacion?></span>
        </td>
    </tr>
</table>

<br>

<table class="w100">
    <tr>
        <td class="w-50" style="background-color: #FDBB30 !important; " >
            <?php if(isset($usuario) && is_object($usuario)): ?>
                <span><?=$usuario->nombre.' '.$usuario->apellido_p.' '.$usuario->apellido_m?></span>
            <?php endif; ?>
        </td>
        <td class="w10"></td>
        <td class="w-50 centrado" rowspan="6">
            <img src="<?=$qr_image?>" width="150px" height="150px">
        </td>
    </tr>
    <tr>
        <td><span class="texto_ayuda_evaluacion">Nombre</span></td>
    </tr>
    <tr>
        <td class="w-50" style="background-color: #FDBB30 !important; ">
            <?php if(isset($usuario_alumno) && is_object($usuario_alumno)): ?>
                <span><?=$usuario_alumno->curp?></span>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td><span class="texto_ayuda_evaluacion">CURP</span></td>
    </tr>
    <tr>
        <td class="w-50" style="background-color: #FDBB30 !important; ">
            <?php if(isset($usuario_alumno) && is_object($usuario_alumno)): ?>
                <span><?=$usuario_alumno->puesto?></span>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td><span class="texto_ayuda_evaluacion">Puesto</span></td>
    </tr>

</table>
<br>
<table class="w100">
    <tr>
        <td class="w5"></td>
        <td class="centrado" style="background-color: red;"><span class="semaforo_evaluacion_rojo">Aun no competente de 0% a 79%</span></td>
        <td class="w5"></td>
        <td class="centrado" style="background-color: yellow" ><span class=" semaforo_evaluacion">Competente de 80% a 94%</span></td>
        <td class="w5"></td>
        <td class="centrado" style="background-color: green"><span class=" semaforo_evaluacion">Competente de 95% a 100%</span></td>
        <td class="w5"></td>
    </tr>
</table>

<!-- nueva pagina para la constancia dc3-->
<pagebreak orientation="P" margin-top="0" margin-bottom="0" />

<?php foreach ($Constancia_dc3 as $index => $dc_3): ?>

    <div class="constancia_dc3">
        <table width="100%">
            <tr>
                <td width="10%"></td>
                <td class="izquierda">
                    <?php if (isset($logo_empresa) && $logo_empresa !== false): ?>
                        <img src="<?= base_url() . $logo_empresa->ruta_directorio . $logo_empresa->nombre ?>"
                             width="130px" height="50px">
                    <?php else: ?>
                        <img src="<?= base_url('extras/imagenes/logo/logo_wm_constancias.jpg') ?>" width="200px" height="50px">
                    <?php endif; ?>
                </td>
                <td class="derecha">
                    <img src="<?= base_url('extras/imagenes/logo-civik.png') ?>" width="150px" height="60px">
                </td>
                <td width="10%"></td>
            </tr>
        </table>


        <div class="titulo_dc3">
            FORMATO DC-3
            <div class="salto_linea"></div>
            CONSTANCIA DE COMPETENCIAS O DE HABILIDADES LABORALES
        </div>
        <div class="salto_linea"></div>
        <!-- datos generales -->
        <table width="100%" border="1">
            <tr>
                <td colspan="19" class="titulo_tabla_dc3">DATOS DEL TRABAJADOR</td>
            </tr>
            <tr>
                <td colspan="19" class="contenido_celda border_laterales">
                    Nombre (Anotar apellido paterno, apellido materno, nombre(s))
                </td>
            </tr>
            <tr>
                <td colspan="19" class="contenido_celda border_laterales">
                    <?= isset($dc_3) ? $dc_3->Nombre_alumno : '' ?>
                </td>
            </tr>
            <tr>
                <td colspan="18" width="45%" class="contenido_celda border_no_inferior">Clave Única de Registro de
                    Población
                </td>
                <td width="50%" class="contenido_celda border_no_inferior">Ocupación específica (Catálogo Nacional de
                    Ocupaciones)<span class="superindice">/1</span></td>
            </tr>
            <tr>
                <?php if (isset($dc_3) && is_array($dc_3->array_curp) && sizeof($dc_3->array_curp) == 18): ?>
                    <?php foreach ($dc_3->array_curp as $c): ?>
                        <td class="centrado contenido_celda border_no_superior"><?= $c ?></td>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php for ($i = 1; $i <= 18; $i++): ?>
                        <td class="centrado contenido_celda border_no_superior"><span style="color: white">X</span></td>
                    <?php endfor; ?>
                <?php endif; ?>
                <td width="50%"
                    class="contenido_celda border_no_superior"><?= isset($dc_3) ? $dc_3->ocupacion_especifica_ctn : '<span style="color: white">X</span>' ?></td>
            </tr>
            <tr>
                <td colspan="19" class="contenido_celda border_laterales">Puesto</td>
            </tr>
            <tr>
                <td colspan="19"
                    class="contenido_celda border_no_superior"><?= isset($dc_3) ? $dc_3->puesto : '<span style="color: white">X</span>' ?></td>
            </tr>
        </table>
        <div class="salto_linea"></div>
        <div class="salto_linea"></div>
        <table width="100%" border="1">
            <tr>
                <td colspan="16" class="titulo_tabla_dc3">DATOS DE LA EMPRESA</td>
            </tr>
            <tr>
                <td colspan="16" class="contenido_celda border_no_inferior">Nombre o razón social (En caso de persona
                    física, anotar apellido paterno, apellido materno, nombre (s))
                </td>
            </tr>
            <tr>
                <td colspan="16"
                    class="contenido_celda border_no_superior"><?= isset($dc_3) ? $dc_3->razon_social_empresa : '<span style="color: white">X</span>' ?></td>
            </tr>
            <tr>
                <td colspan="16" class="contenido_celda border_no_inferior">Registro Federal de Contribuyentes con
                    homoclave (SHCP)
                </td>
            </tr>
            <tr>
                <?php if (isset($dc_3) && is_array($dc_3->array_rfc) && sizeof($dc_3->array_rfc) == 15): ?>
                    <?php foreach ($dc_3->array_rfc as $r): ?>
                        <td class="centrado contenido_celda border_no_superior"><?= $r ?></td>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php for ($i = 1; $i <= 15; $i++): ?>
                        <td class="centrado contenido_celda border_no_superior"><span style="color: white">X</span></td>
                    <?php endfor; ?>
                <?php endif; ?>
                <td width="56%" class="border_no_superior"></td>
            </tr>
        </table>
        <div class="salto_linea"></div>
        <div class="salto_linea"></div>
        <table width="100%" border="1">
            <tr>
                <td colspan="20" class="titulo_tabla_dc3">DATOS DEL PROGRAMA DE CAPACITACIÓN, ADIESTRAMIENTO Y
                    PRODUCTIVIDAD
                </td>
            </tr>
            <tr>
                <td colspan="20" class="contenido_celda border_no_inferior">Nombre del curso</td>
            </tr>
            <tr>
                <td colspan="20"
                    class="contenido_celda border_no_superior"><?= isset($dc_3) ? $dc_3->nombre_ctn : '<span style="color: white">X</span>' ?></td>
            </tr>
            <tr>
                <td width="29%" class="contenido_celda border_no_inferior">Duración en horas</td>
                <td width="9%" class="contenido_celda border_no_inferior border_no_derecho izquierda">Periodo de</td>
                <td width="4%" class="contenido_celda border_no_inferior border_no_izquierdo"></td>
                <td colspan="4" class="contenido_celda border_no_inferior centrado">Año</td>
                <td colspan="2" class="contenido_celda border_no_inferior centrado">Mes</td>
                <td colspan="2" class="contenido_celda border_no_inferior centrado">Día</td>
                <td class="border_no_inferior contenido_celda"></td>
                <td colspan="4" class="contenido_celda border_no_inferior centrado">Año</td>
                <td colspan="2" class="contenido_celda border_no_inferior centrado">Mes</td>
                <td colspan="2" class="contenido_celda border_no_inferior centrado">Día</td>
            </tr>
            <tr>
                <td width="29%"
                    class="contenido_celda border_no_superior"><?= isset($dc_3) ? $dc_3->duracion_ctn : '<span style="color: white">X</span>' ?></td>
                <td width="9%" class="contenido_celda border_no_superior border_no_derecho">Ejecución:</td>
                <td width="4%" class="contenido_celda_prog_capa border_no_superior border_no_izquierdo centrado">
                    <span style="color: white">&nbsp;</span><span class="subindice">De</span>
                </td>
                <?php if ($dc_3): ?>
                    <?php foreach ($dc_3->fecha_inicio_constancia as $f): ?>
                        <td class="contenido_celda_prog_capa border_no_superior centrado"><?= $f ?></td>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php for ($i = 1; $i <= 8; $i++): ?>
                        <td class="centrado contenido_celda border_no_superior"><span style="color: white">X</span></td>
                    <?php endfor; ?>
                <?php endif; ?>
                <td class="contenido_celda_prog_capa border_no_superior centrado">
                    <span style="color: white">&nbsp;</span><span class="subindice">a</span>
                </td>
                <?php if ($dc_3): ?>
                    <?php foreach ($dc_3->fecha_fin_constancia as $f): ?>
                        <td class="contenido_celda_prog_capa border_no_superior centrado"><?= $f ?></td>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php for ($i = 1; $i <= 8; $i++): ?>
                        <td class="centrado contenido_celda border_no_superior"><span style="color: white">X</span></td>
                    <?php endfor; ?>
                <?php endif; ?>
            </tr>

            <tr>
                <td colspan="20" class="contenido_celda border_no_inferior">Área temática del curso<span
                        class="superindice">/2</span></td>
            </tr>
            <tr>
                <td colspan="20"
                    class="contenido_celda border_no_superior"><?= isset($dc_3) ? $dc_3->area_tematica_ctn : '<span style="color: white">X</span>' ?></td>
            </tr>

            <tr>
                <td colspan="20" class="contenido_celda border_no_inferior">Nombre del agente capacitador o STPS<span
                        class="superindice">/3</span></td>
            </tr>
            <tr>
                <td colspan="20"
                    class="contenido_celda border_no_superior"><?= isset($dc_3) ? $dc_3->agente_capacitador : '<span style="color: white">X</span>' ?></td>
            </tr>
        </table>

        <div class="salto_linea"></div>
        <div class="salto_linea"></div>

        <table width="100%" border="1">
            <tr>
                <td class="contenido_celda_firmas centrado border_no_inferior" width="100%" colspan="7">
                    Los datos se asientan en esta constancia bajo protesta de decir verdad, apercibidos de la
                    responsabilidad en que incurre todo
                    <br><br>aquel que no se conduce con verdad.
                </td>
            </tr>

            <tr>
                <td class="border_no_superior border_no_inferior" colspan="7"></td>

            </tr>

            <tr>
                <td class="contenido_celda centrado border_no_superior border_no_derecho border_no_inferior"></td>
                <td width="29%" class="contenido_celda centrado border_ninguno">Instructor o tutor</td>
                <td class="border_ninguno"></td>
                <td width="29%"
                    class="contenido_celda centrado border_no_superior border_no_izquierdo border_no_derecho border_no_inferior">
                    Patrón o representante legal <span class="superindice">/4</span></td>
                <td class="contenido_celda centrado border_ninguno"></td>
                <td width="29%" class="contenido_celda centrado border_ninguno">Representante de los trabajadores <span
                        class="superindice">/5</span></td>
                <td class="contenido_celda centrado border_no_superior border_no_izquierdo border_no_inferior border_no_superior"></td>
            </tr>

            <tr>
                <td class="contenido_celda centrado border_no_superior border_no_inferior" colspan="7"></td>

            </tr>

            <tr>
                <td class="contenido_celda centrado border_no_superior border_no_derecho border_no_inferior"></td>
                <td width="29%" class="contenido_celda centrado border_ninguno">
                    <?php if(isset($dc_3->ruta_documento_firma) && existe_valor($dc_3->ruta_documento_firma)): ?>
                        <img src="<?=base_url().$dc_3->ruta_documento_firma?>" alt="Firma instructor" width="100px" height="30px"><br>
                    <?php endif; ?>
                    <?= isset($dc_3) ? strMayusculas($dc_3->instructor) : '' ?>
                </td>
                <td class="border_ninguno"></td>
                <td width="29%"
                    class="contenido_celda centrado border_no_superior border_no_izquierdo border_no_derecho border_no_inferior"><?= isset($dc_3) ? $dc_3->representante_legal : '' ?></td>
                <td class="contenido_celda centrado border_ninguno"></td>
                <td width="29%"
                    class="contenido_celda centrado border_ninguno"><?= isset($dc_3) ? $dc_3->representante_trabajadores : '' ?></td>
                <td class="contenido_celda centrado border_no_superior border_no_izquierdo border_no_inferior border_no_superior"></td>
            </tr>


            <tr>
                <td width="5%"
                    class="contenido_celda centrado border_no_superior border_no_derecho border_no_inferior"></td>
                <td width="28.33%" class="contenido_celda centrado border_ninguno border_inferior"></td>
                <td width="5%" class="border_ninguno"></td>
                <td width="28.33%" class="contenido_celda centrado border_ninguno border_inferior"></td>
                <td width="5%" class="contenido_celda centrado border_ninguno"></td>
                <td width="28.33%" class="contenido_celda centrado border_ninguno border_inferior"></td>
                <td width="5%"
                    class="contenido_celda centrado border_no_superior border_no_izquierdo border_no_inferior border_no_superior"></td>
            </tr>

            <tr>
                <td class="contenido_celda centrado border_no_superior border_no_derecho"></td>
                <td width="29%"
                    class="contenido_celda centrado border_no_superior border_no_derecho border_no_izquierdo">Nombre y
                    firma
                </td>
                <td class="border_no_superior border_no_derecho border_no_izquierdo"></td>
                <td width="29%"
                    class="contenido_celda centrado border_no_superior border_no_derecho border_no_izquierdo">Nombre y
                    firma
                </td>
                <td class="contenido_celda centrado border_no_superior border_no_derecho border_no_izquierdo"></td>
                <td width="29%"
                    class="contenido_celda centrado border_no_superior border_no_derecho border_no_izquierdo">Nombre y
                    firma
                </td>
                <td class="contenido_celda border_no_izquierdo border_no_superior"></td>
            </tr>

        </table>
        <div class="salto_linea"></div>
        <div class="salto_linea"></div>

        <div style=" margin: auto;">
            <div style="float: left; width: 90%;">
                <table border="0" width="100%">
                    <tbody>
                    <tr>
                        <td class="w30">INSTRUCCIONES</td>
                    </tr>
                    <tr>
                        <td class="w30">
                            - Llenar a máquina o con letra de molde.
                        </td>

                    </tr>
                    <tr>
                        <td class="w30"> - Deberá entregarse al trabajador dentro de los veinte días hábiles siguientes al término del curso de
                            capacitación aprobado.
                        </td>
                    </tr>
                    <tr>
                        <td class="w30"><span class="superindice">/1</span>Las áreas y subáreas ocupacionales del Catálogo Nacional de Ocupaciones
                            se encuentran disponibles en el reverso
                            de este formato y en la página
                            <a href="http://www.stps.gob.mx" target="_blank">www.stps.gob.mx</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="w30">
                            <span class="superindice">/2</span>Las áreas temáticas de los cursos se encuentran disponibles en el reverso
                            de este formato y en la página
                            <a href="http://www.stps.gob.mx" target="_blank">www.stps.gob.mx</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="w30">
                            <span class="superindice">/3</span>Cursos impartidos por el área competente de la Secretaria del Trabajo y
                            Previsión Social.
                        </td>
                    </tr>
                    <tr>
                        <td class="w30">
                            <span class="superindice">/4</span>Para empresas con menos de 51 trabajadores. Para empresas con más de 50
                            trabajadores firmaría el representante del patrón ante la Comisión mixta de capacitación,

                        </td>
                    </tr>
                    <tr>
                        <td class="w30">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;adiestramiento y productividad.</td>
                    </tr>
                    <tr>
                        <td class="w30">
                            <span class="superindice">/5</span>Solo para empresas con más de 50 trabajadores.
                        </td>
                    </tr>
                    <tr>
                        <td class="w30">
                            * Dato no obligatorio
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>

            <div style="float: left; width: 10%;">
                <table border="0" width="5%">
                    <tbody>
                    <tr>

                        <td class="w9" align="center">
                            Codigo QR de Autenticidad.

                            <img class="qr_ima" src="<?=$qr_image?>" alt="QRCode Image">

                            Folio: <?=$dc_3->folio_habilidades?>
                        </td>

                    </tr>

                    </tbody>
                </table>
            </div>

        </div>





        <div class="salto_linea_instrucciones"></div>
        <div class="pie_pagina_dc3">
            DC-3&nbsp;&nbsp;&nbsp;&nbsp;<div class="salto_linea_instrucciones">ANVERSO</div>
        </div>
        <?php if($index < sizeof($Constancia_dc3) - 1): ?>
            <div class="salto_pagina"></div>
        <?php endif; ?>
    </div>

<?php endforeach; ?>

<!-- nueva pagina para la evaluacion con respuestas del alumno -->
<pagebreak orientation="P" margin-top="0" margin-bottom="0" />

<table width="100%">
    <tr>
        <td width="10%"></td>
        <td class="izquierda">
            <?php if (isset($logo_empresa) && $logo_empresa !== false): ?>
                <img src="<?= base_url() . $logo_empresa->ruta_directorio . $logo_empresa->nombre ?>"
                     width="130px" height="50px">
            <?php else: ?>
                <img src="<?= base_url('extras/imagenes/logo/logo_wm_constancias.jpg') ?>" width="200px" height="50px">
            <?php endif; ?>
        </td>
        <td class="derecha">
            <img src="<?= base_url('extras/imagenes/logo-civik.png') ?>" width="150px" height="60px">
        </td>
        <td width="10%"></td>
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
        <td><?=isset($evaluacion_alumno_publicacion_ctn->fecha_envio) && !is_null($evaluacion_alumno_publicacion_ctn->fecha_envio) ? fechaBDToHtml($evaluacion_alumno_publicacion_ctn->fecha_envio) : 'Sin registro'?></td>
    </tr>
    <tr>
        <td class="relleno">Nombre del capacitado</td>
        <td>
            <?php if(isset($usuario) && is_object($usuario)): ?>
                <?=$usuario->nombre.' '.$usuario->apellido_p.' '.$usuario->apellido_m?>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td class="relleno">Preguntas evaluación</td>
        <td><?=sizeof($pregunta_publicacion_ctn)?></td>
    </tr>
    <tr>
        <td class="relleno">Preguntas correctas</td>
        <td><?=$opciones_correctas?></td>
    </tr>
    <tr>
        <td class="relleno">Calificación</td>
        <td><?=$calificacion?></td>
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
    <p class="cuerpo_examen"><?= $index + 1 ?>.- <?= $prt->pregunta ?>
        <?php if(isset($respuestas_alumno[$prt->id_pregunta_publicacion_ctn]['es_correcta']) && $respuestas_alumno[$prt->id_pregunta_publicacion_ctn]['es_correcta']): ?>
            <span class="correcta">Correcta</span>
        <?php else: ?>
            <span class="incorrecta">Incorrecta</span>
        <?php endif; ?>
    </p>

    <?php if (in_array($prt->id_opciones_pregunta, array(OPCION_VERDADERO_FALSO, OPCION_UNICA_OPCION, OPCION_IMAGEN_UNICA_OPCION))): ?>
        <table class="w100 cuerpo_examen">
            <?php foreach ($prt->opciones_pregunta_publicacion_ctn as $index_op => $opciones): ?>
                <?php if($index_op % 3 == 0): ?><tr><?php endif; ?>
                <td class="w3 ">
                    <?php if(isset($respuestas_alumno[$prt->id_pregunta_publicacion_ctn]['op_seleccionada']) && $respuestas_alumno[$prt->id_pregunta_publicacion_ctn]['op_seleccionada'] == $opciones->id_opcion_pregunta_publicacion_ctn): ?>
                        <input type="radio" checked="checked">
                    <?php else: ?>
                        <input type="radio">
                    <?php endif; ?>
                </td>
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
                    <td class="w3 ">
                        <?php if(in_array($opciones->id_opcion_pregunta_publicacion_ctn,$prt->respuestas_alumno)): ?>
                            <input type="checkbox" checked="checked">
                        <?php else: ?>
                            <input type="checkbox">
                        <?php endif; ?>
                    </td>
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
            <?php foreach ($prt->opciones_pregunta_publicacion_ctn as $index_op => $opciones): ?>
                <tr>
                    <td class="w5 border_inferior centrado td_preguntas_examen">
                        <?=isset($prt->respuestas_alumno[$index_op]) ? $prt->respuestas_alumno[$index_op] : 'Sin respuesta'?>
                    </td>
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
                    <td class="w5 border_inferior centrado td_preguntas_examen"><?=isset($prt->respuestas_alumno[$index]) ? $prt->respuestas_alumno[$index] : 'Sin respuesta'?></td>
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