<?php
function base_url(){
    $scheme = 'http://';
    if(isset($_SERVER['REQUEST_SCHEME'])){
        $scheme = $_SERVER['REQUEST_SCHEME'].'://';
    }if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != '' && $_SERVER['HTTPS'] == 'on'){
        $scheme = 'https://';
    }
    $request = str_replace('index.php','',$_SERVER['SCRIPT_NAME']);
    $request = explode('/',$request);
    $url = $scheme.$_SERVER['HTTP_HOST'].implode('/',$request);
    return $url;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta name="author" content="Enrique Corona Ricaño">
    <meta name="description" content="Cursos presenciales Civika Holding Latinoamérica, S.A. de C.V.">
    <meta name="keywords" content="Cursos presenciales, Cursos de capacitación, Consultoría Industrial Cívika, Seguridad e Higiene, Protección civil, Certificación de competencias, Cursos Cívika, Cívika, Civika Holding, civika.edu.mx">

    <!-- CSS de bootstrap -->
    <link href="<?=base_url()?>extras/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <!--CSS for templates-->
    <link href="<?=base_url()?>extras/template/arcana/css/main.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url()?>extras/template/shards/css/shards.min.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url()?>extras/template/shards/css/shards-demo.css" rel="stylesheet" type="text/css">

    <!-- CSS para el sistema -->
    <link href="<?=base_url()?>extras/css/comun.css" rel="stylesheet" type="text/css">

    <!-- icono -->
    <link href="<?=base_url()?>extras/imagenes/logo/icono.png" rel="shortcut icon">

    <title>Fundación CIVIKA</title>
</head>
<body>

<div id="page-wrapper">

    <div class="container">
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-xs-12 col-sm-12 text-center">
                        <img src="<?=base_url()?>extras/imagenes/logo/civika.png" class="img-fluid">
                    </div>
                </div>

                <div class="row">

                    <div class="form-group col-lg-12 col-md-12 col-xs-12 col-sm-12 text-center">
                        <img src="<?=base_url()?>extras/imagenes/logo/not_found.png" class="img-fluid">
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <span class="negrita contenido_no_disponible">¡Contenido no disponible o link expirado!</span>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <a href="<?=base_url()?>" class="btn btn-success btn-lg">Inicio</a>
                    </div>
                </div>

            </div>
        </div>
    </div>


</div> <!-- end page-wrapper -->

<!--<div class="card" style="background-image: linear-gradient(white, white,white,white, lightgrey,grey, black);">
    <div class="card-body row">
        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12 text-left">
            <img class="mr-4" src="<?=base_url()?>extras/imagenes/logo/ECE.jpg" width="155px">
            <img class="ml-4" src="<?=base_url()?>extras/imagenes/logo/CONACYT.png" width="75px">
            <img class="mt-5" src="<?=base_url()?>extras/imagenes/logo/TOEFL.png" width="155px">
        </div>
        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center" style="font-weight: bold !important;">
            <h5 class="">Contacto</h5>
            <ul class="">

                <li>
                    <i class="fa fa-map-marker"></i>
                    Centro Educativo Campus Cívika. Ferrocarril Mexicano 286. Colonia 20 de noviembre. Apizaco, Tlax. C.P. 90341
                </li>
                <li>
                    <i class="fa fa-phone"></i>
                    (01) 241 417 75 65
                </li>
                <li>
                    <i class="fa fa-whatsapp"></i>
                    241 135 62 52
                </li>
                <li>
                    <i class="fa fa-envelope-o"></i>
                    <a href="mailto:hola@civika.edu.mx?Subject=Información cursos">hola@civika.edu.mx</a>
                </li>
                <li>
                    <i class="fa fa-file-pdf-o"></i>
                    <a href="/extras/docs/aviso_privacidad_2021.pdf" target="_blank">Aviso de privacidad</a>
                </li>
            </ul>
        </div>
        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right">
            <img class="mr-4" src="/extras/imagenes/logo/EMA.png" width="100PX">&nbsp;
            <img class="ml-5" src="/extras/imagenes/logo/DUNS_2021.png" width="100px">
            <img class="mt-5" src="/extras/imagenes/logo/STPS.png" width="160px">
        </div>
    </div>
    <p class="text-muted text-center text-white">© Copyright 2021 — Grupo Cívika</p>
</div> -->

<br><br>
<br>
<div class="card" style="background-image: linear-gradient(white, white,white,white, lightgrey,grey, black);">

    <p class="text-muted text-center text-white">© Copyright 2021 — Grupo Cívika</p>
</div>


<!-- Scripts del jquery -->
<script src="/extras/plugins/jquery-1.12.4.min.js"></script>

<!-- scripts de bootstrap -->
<script src="/extras/plugins/bootstrap/js/bootstrap.bundle.js"></script>
<script src="/extras/plugins/bootstrap/js/popper.min.js"></script>
<script src="/extras/plugins/bootstrap/js/bootstrap.min.js"></script>

<!-- scripts del template de arcana -->
<script src="/extras/template/arcana/js/jquery.dropotron.min.js"></script>
<script src="/extras/template/arcana/js/skel.min.js"></script>
<script src="/extras/template/arcana/js/util.js"></script>
<!--[if lte IE 8]><script src="/extras/template/arcana/js/ie/respond.min.js"></script><![endif]-->
<script src="/extras/template/arcana/js/main.js"></script>

<!-- scripts del temple de shards -->
<script src="/extras/template/shards/js/shards.js"></script>

<!-- scripts del sistema -->
<script src="/extras/js/comun.js"></script>

<div id="conteiner_mensajes_civik" class="mensajes_sistema_civik"></div>
<div id="conteiner_modal_confirmacion"></div>

</body>
</html>
