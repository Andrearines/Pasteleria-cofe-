<?php
namespace controllers;

use MVC\Router;
use models\main;
use models\user;
use models\menu;

class API{
    public static function findbyall(Router $r){
    $column = $_GET['column'] ?? null;
$value = $_GET['value'] ?? null;
        if(!$column || !$value){
            echo json_encode(['error' => 'Column and value are required']);
            return;
        }
        $S=[];
         $S = menu::findBy($column,$value);
        echo json_encode($S);
    }
     //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
    //-----------------------login---------------------------------------------
    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
  public static function register(){
    
    $user = new user($_POST); 
    $user ->getimg($_FILES);
     $r=$user->register();
    echo json_encode($r);
  }

  public static function confirm(Router $r){
    $token = $_GET['token'] ?? null;
        $user= user::confirm($token);
        echo json_encode($user);
  }

}