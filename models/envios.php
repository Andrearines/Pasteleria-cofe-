<?php 
namespace models;
class envios extends main{
    public static $table="ordenes";
    static $columnDB = ["pedidos_id","pastel_id","cantidad","direccion"];
    public $pedidos_id;
    public $pastel_id;
    public $cantidad;
    public $direccion;

    public function  __construct($pedidos_id,$pastel_id,$cantidad,$direccion){
        $this->pedidos_id =$pedidos_id;
        $this->pastel_id =$pastel_id;
        $this->cantidad =$cantidad;
        $this->direccion=$direccion;
    }

    public function save($img){
        $this->validate();
        if(empty(static::$errors)){
            $query = "INSERT INTO " . static::$table . " (pedidos_id,pastel_id,cantidad,direccion) VALUES (
            '{$this->pedidos_id}',
           '{$this->pastel_id}',
            '{$this->cantidad}',
            '{$this->direccion}'
            )";
            $result = self::$db->query($query);
        if($result){
            return true;
        }else{
            return false;
        }
    }
  }
}