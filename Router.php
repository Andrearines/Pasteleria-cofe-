<?php

namespace MVC;

class Router{

    public $rutasGET=[];
    public $rutasPOST=[];
    public $rutasPUT=[];
    public $rutasDELETE=[];

    public function get($url,$fn){
        $this->rutasGET[$url]=$fn;
    }

    public function put($url,$fn){
        $this->rutasPUT[$url]=$fn;
    }
    public function delete($url,$fn){
        $this->rutasDELETE[$url]=$fn;
    }
    public function post($url,$fn){
        $this->rutasPOST[$url]=$fn;
    }

    public function view($view ,$datos=[]){
        foreach($datos as $key => $value){
             $$key = $value;
        }
        ob_start();
        include __DIR__."/views/$view";

        $contenedor=ob_get_clean();
        include __DIR__."/views/layout.php";

    }

   public function Rutas(){
   $urlA=$_SERVER['PATH_INFO'] ?? "/";
   $metodo=$_SERVER['REQUEST_METHOD'];
   
   if($metodo ==='GET'){
    $fn = $this->rutasGET[$urlA] ?? null;
   }else if($metodo ==='POST'){
    $fn = $this->rutasPOST[$urlA] ?? null;
   }else if($metodo ==='PUT'){
    $fn = $this->rutasPUT[$urlA] ?? null;
    }else{
    $fn = $this->rutasDELETE[$urlA] ?? null;
    }
   
   if($fn){
    call_user_func($fn,$this);

   }else{
    echo "pagina no existe";
   }

   }
}