<?php
namespace models;

class menu extends main{

    public static $table =  "pasteles";
    static $columnDB = ["id","nombre","precio","img","disponible","categoria_id"];
    public $id;
    public $nombre;
    public $precio;
    public $img;
    public $disponible;
    public $categoria_id;

    public function __construct($args=[]){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->img = $args['img'] ?? '';
        $this->disponible = $args['disponible'] ?? '';
        $this->categoria_id = $args['categoria_id'] ?? '';
    }

}