<?php 
require "funciones.php";
require"config/database.php";
require __DIR__."/../vendor/autoload.php";

use models\main;
main::setDb(conectaDB());
