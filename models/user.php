<?php
 namespace models;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
class user extends main
{

    public $id;
    public $name;
    public $email;
    public $password;
    public $img;
    public $admin;
    public $token;
    public $confirmado;
    public $direccion;

    public static $table = 'users';
    public static $columnDB = [
        "id",
        'nombre',
        'email',
        'password',
        'img',
        "admin",
        "token",
        "confirmado",
        "direccion"
        
    ];

    public function __construct($data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->password = $data['password'] ?? '';
      $this->img = $data['img'] ?? [];
        $this->admin = $data['admin'] ?? 0;
        $this->token = $data['token'] ?? '';
        $this->confirmado = $data['confirmado'] ?? 0;
        $this->direccion = $data['direccion'] ?? '';
    }

    public function getimg($data = []){
          $this->img = $data['img'] ?? [];
    }
    public function register(){
        $r=$this->validate();
        if(empty($r)){

            $nombre_img=$this->img($this->img);
            $resut =$this->save();
            return $resut;

        }else{
            return $r;
        }
    }

    public function save(){
        $this->validate();
        if(empty(static::$errors)){
            $query = "INSERT INTO " . static::$table . " (nombre,img,password,direccion,admin,token,confirmado)
             VALUES ('{$this->name}' ,'{$this->img}','{$this->password}', '{$this->direccion}','{$this->email}',{$this->admin},'{$this->token}',{$this->confirmado})";
           // $result = self::$db->query($query);
            return true;
        }else{
            return static::$errors;
        }
    }

    public function token(){
         $token=md5(uniqid(rand(),true ));
         return $token;
    }

     private function img($imagen){ 
    $nombre_img = md5(uniqid(rand(), true)) . ".png";
    $manager = new ImageManager(['driver' => 'gd']);
    $imgObj = $manager->make($imagen['tmp_name'])->fit(900, 900);
    $imgObj->save(__DIR__ . '/../public/build/img/imagenes_perfiles/' . $nombre_img);
    return $nombre_img;
  }
    public function validate()
    {
        static::$errors = [];
        
        if (!$this->name) {
             static::$errors[] ="nombre es obligatorio";
        }
        
        if (empty($this->email)) {
             static::$errors[] ="email es obligatorio";
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
             static::$errors[] ="email no valido";;
        }
        
        if (empty($this->password)) {
         static::$errors[] ="contrasena obligatoria";
        }
        if(!$this->img['tmp_name']) {
   static::$errors[] ="subir foto";
        }

        return static::$errors;
    }
}