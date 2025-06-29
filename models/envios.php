<?php 
namespace models;
class envios extends main{
    public static $table="ordenes";
    static $columnDB = ["pedidos_id","pastel_id","cantidad"];
    public $pedidos_id;
    public $pastel_id;
    public $cantidad;

    public function  __construct($pedidos_id,$pastel_id,$cantidad){
        $this->pedidos_id =$pedidos_id;
        $this->pestel_id =$pastel_id;
        $this->cantidad =$cantidad;
    }

    public function save($img){
        $this->validate();
        if(empty(static::$errors)){
            $query = "INSERT INTO " . static::$table . " () VALUES ('{}')";
            $result = self::$db->query($query);
        if($result){
            return true;
        }else{
            return false;
        }
    }
  }
}