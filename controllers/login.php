<?php
namespace controllers;
use MVC\Router;
use models\user;
class login{
    public static function login(Router $r){
        $r->view("/login/login.php" ,["headerFrotante"=>true,"inicio"=>false, "script"=>"bundle.min"]);
    }
    //-------------------------------------------------------------------------
    
    public static function logout(Router $r){
        session_start();
        $_SESSION = [];
        session_destroy();
        header("Location: /");
    }

    //-------------------------------------------------------------------------
    public static function confirm(Router $r){
      
        $token = $_GET['token'] ?? null;
        if(!$token){
            header("Location: /login");
            return;
        }    
        $r->view("/login/confirm.php", [
            "headerFrotante" => true,
            "inicio" => false,
            "script" => "bundle.min",
          
        ]);
    }
    //-------------------------------------------------------------------------
    public static function forget(Router $r){
        $r->view("/login/forget.php" ,["headerFrotante"=>true, "script"=>"bundle.min"]);
    }
    //-------------------------------------------------------------------------
    public static function reset(Router $r){
        $token = $_GET['token'] ?? null;
        if(!$token){
            header("Location: /login");
            return;
        }    
        $r->view("/login/reset.php", [
            "headerFrotante" => true,
            "inicio" => false,
            "script" => "bundle.min",
          
        ]);
    }
    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
    public static function register(Router $r){
        $r->view("/login/register.php" ,["headerFrotante"=>true, "script"=>"bundle.min"]);
    }


}