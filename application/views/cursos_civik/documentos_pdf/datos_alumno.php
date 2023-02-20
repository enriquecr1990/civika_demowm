<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Formulario de inscripción</title>

    <link href="<?=base_url() . 'extras/css/comunPDF.css'?>" rel="stylesheet" type="text/css">

    <link href="<?=base_url() . 'extras/imagenes/logo/icono.png'?>" rel="shortcut icon">
</head>
<body>

<table class="w100">
    <tr>
        <td class="centrado">
            <img src="<?=base_url() . 'extras/imagenes/logo/civika.png'?>" alt=""/>
        </td>
    </tr>
    <tr>
        <td class="centrado"><label>Formulario de inscripción</label></td>
    </tr>
</table>

<?php $this->load->view('cursos_civik/documentos_pdf/alumnos/datos_personales');?>
<?php $this->load->view('cursos_civik/documentos_pdf/alumnos/datos_empresa');?>
<?php if (isset($alumno_inscrito_ctn_publicado) && $alumno_inscrito_ctn_publicado->requiere_factura == 'si'): ?>
    <?php $this->load->view('cursos_civik/documentos_pdf/alumnos/datos_facturacion');?>
<?php endif;?>


</body>
</html>