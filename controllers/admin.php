<?php
namespace controllers;
use MVC\Router;
use models\user;

class admin {
    public static function index(Router $r){
        admin();
        $r->view("/admin/admin.php",["pageAdmin"=>false , "script" => "bundle.min",]);
    }
}