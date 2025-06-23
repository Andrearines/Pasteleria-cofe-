<?php

if(!isset($_SESSION)){
session_start();
}
$auth = $_SESSION['admin'] ?? null;
if(!isset($inicio)){

    $inicio=false;
}

if(!isset($titulo)){

    $tituo="";
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

    <header class="header <?php echo $inicio ?"inicio":"" ?>">
        <div class="contenido-header">

            <div class="barra">
                <a href="/">
                    <img src="/build/img/logo.jpeg" alt="logo">
                </a>
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

    