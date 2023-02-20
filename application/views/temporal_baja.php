<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta name="author" content="Enrique Corona Ricaño">
    <meta name="description" content="Cursos presenciales Civika Holding Latinoamérica, S.A. de C.V.">
    <meta name="keywords" content="Cursos presenciales, Cursos de capacitación, Consultoría Industrial Cívika, Seguridad e Higiene, Protección civil, Certificación de competencias, Cursos Cívika, Cívika, Civika Holding, civika.edu.mx">

    <!-- icono -->
    <link href="<?=base_url()?>extras/imagenes/logo/icono.png" rel="shortcut icon">

    <title>Fundación CIVIKA</title>

    <style>
        #backgroundImage:after {
            content: "";
            position: absolute;
            z-index: -1;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-image: url('<?=base_url()?>extras/imagenes/grupo_civika.jpeg');
            background-repeat: round;
            background-size: 100%;
            /*-webkit-transform: rotate(10deg);
            -moz-transform: rotate(10deg);
            -ms-transform: rotate(10deg);
            -o-transform: rotate(10deg);
            transform: rotate(-10deg);*/
            filter:alpha(opacity=10);
            height:100% !important;
            width:100% !important;
        }

        .fullscreen-bg {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            overflow: hidden;
            z-index: -100;
        }
    </style>

</head>
<body>

<div id="backgroundImage" class="fullscreen-bg"></div>
<img src="<?=base_url()?>extras/imagenes/grupo_civika.jpeg" style="width: 100%; height: 50% !important;">

</body>
</html>
