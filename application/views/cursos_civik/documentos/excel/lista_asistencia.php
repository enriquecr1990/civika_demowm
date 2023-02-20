<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<table>
    <tr>
        <td>Curso:</td>
        <td colspan="5"><?=$publicacion_ctn->nombre_curso_comercial?></td>
        <td style="text-align: right">
            <img src="<?=base_url()?>extras/imagenes/logo/civika_asistencia.jpg">
        </td>
    </tr>
</table>
<table>
    <tr>
        <td >Instructor:</td>
        <td colspan="5"><?=$instructor->nombre.' '.$instructor->apellido_p.' '.$instructor->apellido_p?></td>
    </tr>
</table>
<table>
    <tr>
        <td >Fecha:</td>
        <td colspan="7" style="text-align: left"><?=fechaBDToHtml($publicacion_ctn->fecha_inicio)?></td>
    </tr>
</table>
<table>
    <tr>
        <td >Aula:</td>
        <td colspan="7"><?=$instructor->aula?></td>
    </tr>
</table>
<table>
    <tr><td></td></tr>
</table>
<?php if($existen_datos){ ?>
    <table class="table table-bordered tabla-resultado-busqueda" id="exportar-excel" border="1">
        <thead>
        <tr>
            <td style="text-align: center; background-color: #579fff; width: auto !important;">#</td>
            <?php foreach($cabeceras as $campo => $descripcion): ?>
                <td style="text-align: center; background-color: #579fff; width: auto !important;">
                    <strong><?=str_replace('_', ' ',$campo)?></strong>
                </td>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach($registros as $index => $row): ?>
            <tr>
                <td><?=$index + 1?></td>
                <?php foreach($row as $columna => $valor): ?>
                    <td style="text-align: left;"><?=$valor != '' ? $valor : ''?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php }else{?>
    <table class="table table-bordered tabla-resultado-busqueda" id="exportar-excel">
        <tr>
            <td>Sin registros encontrados</td>
        </tr>
    </table>
<?php }?>