<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Carta descriptiva</title>
    <link href="<?= base_url() . 'extras/css/comunPDF.css' ?>" rel="stylesheet" type="text/css">
</head>
<body>

    <div class="constancia_dc3">
        <table width="100%">
            <tr>
                <td width="10%"></td>
                <td class="izquierda">
                    <?php if(isset($logo_empresa) && $logo_empresa !== false): ?>
                        <img src="<?= base_url().$logo_empresa->ruta_directorio.$logo_empresa->nombre ?>" width="150px" height="60px">
                    <?php endif; ?>
                </td>
                <td class="derecha">
                    <img src="<?= base_url('extras/imagenes/logo-civik.png') ?>" width="150px" height="60px">
                </td>
                <td width="10%"></td>
            </tr>
        </table>

        <div class="salto_linea"></div>
        <div class="salto_linea"></div>
        <!-- datos generales -->
        <table width="100%" border="1">
            <tr>
                <td colspan="2" class="titulo_tabla_carta_descriptiva">CARTA DESCRIPTIVA</td>
            </tr>
            <tr>
                <td class="w33 negrita fondo_celda contenido_celda">Denominación:</td>
                <td class="contenido_celda"><?=$carta_descriptiva->nombre_dc3?></td>
            </tr>
            <tr>
                <td class="negrita fondo_celda contenido_celda">Duración:</td>
                <td class="contenido_celda"><?=number_format($carta_descriptiva->duracion,0)?> hrs</td>
            </tr>
            <tr>
                <td class="negrita fondo_celda contenido_celda">Fecha inicio:</td>
                <td class="contenido_celda"><?=fechaBDToHtml($carta_descriptiva->fecha_inicio)?></td>
            </tr>
            <tr>
                <td class="negrita fondo_celda contenido_celda">Fecha de finalización:</td>
                <td class="contenido_celda"><?=fechaBDToHtml($carta_descriptiva->fecha_fin)?></td>
            </tr>
            <tr>
                <td class="negrita fondo_celda contenido_celda">Área tempática:</td>
                <td class="contenido_celda"><?=$carta_descriptiva->area_tematica?></td>
            </tr>
            <tr>
                <td class="negrita fondo_celda contenido_celda">Nombre y registro STPS de la Institución capacitadora:</td>
                <td class="contenido_celda"><?=$carta_descriptiva->agente_capacitador?></td>
            </tr>
            <tr>
                <td class="negrita fondo_celda contenido_celda">Nombre del instructor:</td>
                <td class="contenido_celda"><?=$carta_descriptiva->instructor?></td>
            </tr>
            <tr>
                <td class="negrita fondo_celda contenido_celda">Resumen Curricular:</td>
                <td class="contenido_celda"><?=$carta_descriptiva->experiencia_curricular?></td>
            </tr>
            <tr>
                <td class="negrita fondo_celda contenido_celda">Lugar de impartición:</td>
                <td class="contenido_celda"><?=$carta_descriptiva->lugar_imparticion?></td>
            </tr>
            <tr>
                <td class="negrita fondo_celda contenido_celda">Objetivo:</td>
                <td class="contenido_celda"><?=nl2br($carta_descriptiva->objetivo)?></td>
            </tr>
            <tr>
                <td class="negrita fondo_celda contenido_celda">Eje temático:</td>
                <td class="contenido_celda"><?=nl2br($carta_descriptiva->eje_tematico)?></td>
            </tr>
        </table>

    </div>
</body>
</html>