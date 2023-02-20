<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php if($existen_datos){ ?>
    <table class="table table-bordered tabla-resultado-busqueda" id="exportar-excel" border="1">
        <thead>
        <tr>
            <?php foreach($cabeceras as $campo => $descripcion): ?>
                <td style="text-align: center; background-color: #579fff; width: auto !important;">
                    <strong><?=str_replace('_', ' ',$campo)?></strong>
                </td>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach($registros as $row): ?>
            <tr>
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