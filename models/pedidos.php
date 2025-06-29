<?php
namespace models;
class pedidos extends main{
    public static $table ="pedidos";
    static $columnDB=["usuario_id","fecha","hora"];
    public $usuario_id;
    public $fecha;
    public $hora;
    public function __construct($usuario_id,$fecha,$hora){
        $this->usuario_id = $usuario_id;
        $this->fecha = $fecha;
        $this->hora= $hora;

    }
    public function save($img){
        $this->validate();
        if(empty(static::$errors)){
            $query = "INSERT INTO " . static::$table . " () VALUES ('{}')";
            $result = self::$db->query($query);
        if($result){
            return self::$db->insert_id;
        }else{
            return false;
        }
    }
  }
}