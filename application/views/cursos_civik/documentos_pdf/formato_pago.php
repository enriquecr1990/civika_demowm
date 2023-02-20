<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Formato de pago</title>

    <link href="<?=base_url().'extras/css/comunPDF.css'?>" rel="stylesheet" type="text/css">

    <link href="<?= base_url() . 'extras/imagenes/logo/icono.png'?>" rel="shortcut icon">
</head>
<body>

<table class="w100">
    <tr>
        <td class="centrado">
            <img src="<?=base_url().'extras/imagenes/logo/civika.png'?>" alt=""/>
        </td>
    </tr>
    <tr>
        <td class="centrado"><label>Formato de pago</label></td>
    </tr>
</table>

<hr>

<?php foreach ($catalogo_formas_pago as  $cfg): ?>
    <table class="w100">
        <tr>
            
        </tr>
        <tr>
            <td class="derecha negrita w30">Cuenta</td>
            <td class="izquierda"><?=$cfg->cuenta?></td>
        </tr>
        <tr>
            <td class="derecha negrita w30">N° de tarjeta:</td>
            <td class="izquierda"><?=$cfg->numero_tarjeta?></td>
        </tr>
        <tr>
            <td class="derecha negrita w30">Clabe:</td>
            <td class="izquierda"><?=$cfg->clabe?></td>
        </tr>
        <tr>
            <td class="derecha negrita w30">Sucursal:</td>
            <td class="izquierda"><?=$cfg->sucursal?></td>
        </tr>
        <tr>
            <td class="derecha negrita w30">Titular:</td>
            <td class="izquierda"><?=$cfg->titular?></td>
        </tr>
        <tr>
            <td class="derecha negrita w30">Banco:</td>
            <td class="izquierda">
                <?=$cfg->banco?>
                
            </td>
        </tr>
            </table>
<?php endforeach; ?>

</body>
</html>