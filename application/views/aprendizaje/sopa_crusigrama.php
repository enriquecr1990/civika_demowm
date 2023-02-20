
<?php $this->load->view('default/header') ?>



    <style media="print">.ocultar {display:none;}.col-md-3 { width: 25%;float: left;}.col-md-9 {width: 75%;float: left;}
    </style>

<div class="container">
    <div class="row">

<div class="row  ocultar text-center">
    <br />
    <div class="panel panel-default">
    <div class="panel-heading"><h4>1.- Escribe las palabras, luego presiona el botón <strong>"Crear Juego"</strong></h4></div>
    <div class="panel-body"><ul id="myTags">
    <li>perro</li>
    <li>gato</li>
    <li>pajaro</li>
</ul></div>
  </div>




    </div>



<div class="row text-center">
<div class="ocultar">
<br/><br/>
</div>
<div>

<div class="row">


     <div class="panel panel-default">
     <div class="panel-heading ocultar"><h4>2.- Crea la sopa e imprimela o simplemente resuelvela online</h4></div>
    <div class="panel-body">
    <div class="ocultar">
    <button onclick="document.getElementById('../extras/plugin1/primera.js').innerHTML = Crear();" id="boton-crear" class="btn btn-success btn-lg"> Crear Juego</button>
    <button onclick="window.print();" class="btn btn-info btn-lg "> Imprimir</button>
    <button id='solve' class="btn btn-danger btn-lg" >  Resolver</button>
    <!-- <a href="#" class="btn btn-default btn-lg" > Descargar</a>-->
        </div>
        <div class="row">


        <div class="col-md-3">
                        <div id='Palabras'></div>

        </div>
                <div class="col-md-9">
                        <div id='juego'></div>

                </div>
         </div>







    </div>



  </div>




</div>




    </div>
