<?php
namespace controllers;

use MVC\Router;
use models\main;
use models\user;
use models\menu;
use models\categoria;
use models\envios;
use models\pedidos;

class API{
    public static function findbyall(){
    $column = $_GET['column'] ?? null;
     $value = $_GET['value'] ?? null;
     $value= filter_var($value,FILTER_SANITIZE_NUMBER_INT);
     if($value){
      if(!$column || !$value){
                 echo json_encode(['error' => 'Column and value are required']);
                 return;
             }
             $S=[];
              $S = menu::findBy($column,$value);
        echo json_encode($S);
} }

public static function call(){
  $r=[];
  $r=categoria::all();
  echo json_encode($r);
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

  public static function confirm(){
    $token = $_GET['token'] ?? null;
        $user= user::confirm($token);
        echo json_encode($user);
  }
  public static function forget(){
    $r = new user($_POST);
    $r = $r->forget();
    echo json_encode($r);
  }

  public static function login(){
    $user = new user($_POST);
    $r = $user->login();
    echo json_encode($r);
  }

  public static function reset(){
   
   $user = new user($_POST);
   $user->token=$_GET['token'];
    $r = $user->reset();
    echo json_encode($r);
  }

  //-------------------------------------------------------------------------------------------
  //-------------------------------------------------------------------------------------------
  //-------------------------------------------------------------------------------------------
  //-------------------------------------------------------------------------------------------
  //---------------------------------------envio-----------------------------------------------
  //-------------------------------------------------------------------------------------------
  //-------------------------------------------------------------------------------------------
  //-------------------------------------------------------------------------------------------
  //-------------------------------------------------------------------------------------------
  //-------------------------------------------------------------------------------------------


  public static function envio(){
    $pedido=new pedidos(
    $_POST["usuario_id"],
    $_POST["fecha"],
    $_POST["hora"]
    );
    $id=$pedido->save("");
    $envios= new envios(
      $id,
      $_POST["pastel_id"],
      $_POST["cantidad"],
      $_POST["direccion"]
    );
    $r=$envios->save("");

echo json_encode($r);
  }

}