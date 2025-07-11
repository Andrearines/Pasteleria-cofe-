<?php

if(!isset($_SESSION)){
session_start();
$_SESSION=['admin'=>false,"login"=>false];
}

if(!isset($inicio)){

    $inicio=false;
}

if(!isset($titulo)){

    $titulo="";
}
if(!isset($headerFrotante)){

    $headerFrotante=false;
}
if(!isset($pageAdmin)){
    if($_SESSION["admin"]){
        $pageAdmin=true;
    }else{
    $pageAdmin= false;
}
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../build/css/app.css">
    <title></title>
</head>
<body>

    <header class="header <?php echo $inicio ?"inicio":""; echo $headerFrotante ?"header-fotante":""; ?>">
        <div class="contenido-header">

            <div class="barra">
                <a href="/">
                    <img src="/build/img/logo.jpeg" alt="logo">
                </a>

                <?php if($_SESSION["login"]==true){?>
                <div class="acciones ">
                    <a href="/logout" class="boton">salir</a>
                    <?php if($_SESSION["admin"] && $pageAdmin ){?>
                    <a class="boton boton-admin" href="/admin">admin</a>
                  <?php }?>
                  <?php if($pageAdmin){ ?>
                    <div id="carrito">
                    <script src="https://animatedicons.co/scripts/embed-animated-icons.js"></script>
                       <animated-icons
                         src="https://animatedicons.co/get-icon?name=shopping&style=minimalistic&token=1a426870-e168-49f4-b12a-f584dc9f311e"
                         trigger="loop"
                         attributes='{"variationThumbColour":"#A4A7A9","variationName":"Gray Tone","variationNumber":3,"numberOfGroups":1,"strokeWidth":0.8,"backgroundIsGroup":true,"defaultColours":{"group-1":"#000000","background":"#FFFFFFFF"}}'
                         height="100"
                         width="100"
                       ></animated-icons>
                       <?php }?>
                   </div>
                </div>
                <?php }?>
           </div> <!--barra-->

           <h1><?php echo($titulo)?></h1>

        </div>
    </header>

    <?php echo $contenedor?>
   
    
<footer class="footer">
        <div class="contenedor-footer">
            <img src="build/img/logo.jpeg" alt="">
            <div class="redes">
                <img src="/build/img/iconos/Social Icons-1.svg" alt="">
                <img src="/build/img/iconos/Social Icons-2.svg" alt="">
                <img src="/build/img/iconos/Social Icons.svg" alt="">
            </div>
        </div>
        <?php 
        
        $fecha =date("y");

        ?>
        <p class="copyright">todos los derechos resevados <?php echo(date("Y"))?> &copy;</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
          <?php
          
    if($script){
        echo "<script src='build/js/{$script}.js'></script>";
    }
    ?>
    </body>
    </html>

    