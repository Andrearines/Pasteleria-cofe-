<?php
namespace models;
class categoria extends main{

    public static $table = 'categoria';
    public static $columnDB = ["id", "categoria","img"];
    public $categoria;
    public $id;
    public $img;
    public function __construct($arg=[]){
        $this->id=$arg["id"] ?? "";
        $this->categoria=$arg["categoria"] ?? "";
        $this->img=$arg["img"] ?? "";
    }

}