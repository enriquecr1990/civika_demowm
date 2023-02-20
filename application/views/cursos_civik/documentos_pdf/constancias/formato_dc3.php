<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Constancia DC3</title>
    <link href="<?= base_url('extras/css/constanciaDC3_sin_sello.css') ?>" rel="stylesheet" type="text/css">

    

</head>
<body>


    <?php foreach ($Constancia_dc3 as $index => $dc_3): ?>
        <?php
        $CI = &get_instance();
        $CI->load->library('ciqrcode');
        $qr_image=rand().'.png';
        $params['data'] = $dc_3->link_to_qr;
        $params['level'] = 'l';
        $params['size'] = 2;
        $params['savename'] =FCPATH."imagenes/QR".$qr_image;
        //if(file_exists($params['savename'])){
            if($CI->ciqrcode->generate($params))
            {
                //$data['img_url']=$qr_image;
                $dc_3->qr_img = $qr_image;
            }
        //}

        ?>
        <div class="constancia_dc3">
            <table width="100%">
                <tr>
                    <td width="10%"></td>
                    <td class="izquierda">
                        <?php if (isset($logo_empresa) && $logo_empresa !== false): ?>
                            <img src="<?= base_url() . $logo_empresa->ruta_directorio . $logo_empresa->nombre ?>"
                            width="130px" height="50px">
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
                                               <br> 
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
                                
                                <img class="qr_ima" src="<?=base_url('imagenes/QR'.$dc_3->qr_img); ?>" alt="QRCode Image">

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
</body>
</html>