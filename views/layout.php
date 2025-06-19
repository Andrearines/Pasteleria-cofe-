<?php

if(!isset($_SESSION)){
session_start();
}
$auth = $_SESSION['admin'] ?? null;
if(!isset($inicio)){

    $inicio=false;

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
        <div class="contenedor contenido-header">

            <div class="barra">
                <a href="/">
                    <img src="" alt="logo">
                </a>
           </div> <!--barra-->

            <h1> </h1><!--titulo-->
        </div>
    </header>

    <?php echo $contenedor?>
   
    
<footer class="footer">
        <div class="contenedor contenedor-footer">
            <nav class="navegacion">
                
            </nav>
        </div>
        <?php 
        
        $fecha =date("y");

        ?>
        <p class="copyright">todos los derechos resevados <?php echo(date("Y"))?> &copy;</p>
    </footer>
          <?php
    if($script){
        echo "<script src='build/js/{$script}.js'></script>";
    }
    ?>
    </body>
    </html>

    