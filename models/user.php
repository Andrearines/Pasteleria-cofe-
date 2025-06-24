<?php
 namespace models;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use models\email;
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
        ini_set('memory_limit', '500M');
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->img = $data['img'] ?? [];
        $this->admin = $data['admin'] ?? 0;
        $this->token = $this->token();
        $this->confirmado = $data['confirmado'] ?? 0;
        $this->direccion = $data['direccion'] ?? '';
    }

    public function getimg($data = []){
          $this->img = $data['img'] ?? [];
    }
    public function register(){
        $r=$this->validate();
        if(empty($r)){
            $img=$this->img($this->img);
            $resut =$this->save($img);
            $email = new email($this->name, $this->email);
            $r=$email->sendEmail(
                "Confirma tu cuenta",
                "<p>Hola {$this->name},</p>
                <p>Gracias por registrarte. Por favor, confirma tu cuenta haciendo clic en el siguiente enlace:</p>
                <a href='http://localhost:3000/confirmar?token={$this->token}'>Confirmar Cuenta</a>
                <p>Si no te registraste, ignora este mensaje.</p>"
            );
            
            return $resut;

        }else{
            return $r;
        }
    }

    static public function confirm($token){
        $token = self::$db->real_escape_string($token);
        $query = "SELECT * FROM " . static::$table . " WHERE token = '$token'";
        $result = self::$db->query($query);
        if($result->num_rows > 0){
            $user = $result->fetch_object();
            if($user->confirmado == 0){
                $query = "UPDATE " . static::$table . " SET confirmado = 1, token = '' WHERE token = '$token'";
                self::$db->query($query);
                return true;
            }else{
                return "Cuenta ya confirmada";
            }
        }else{
            return "Token invalido";
        }
    }

    public function save($img){
        $this->validate();
        if(empty(static::$errors)){
            $query = "INSERT INTO " . static::$table . " (nombre, img, password, direccion, email, admin, token, confirmado)
             VALUES ('{$this->name}', '$img', '{$this->password}', '{$this->direccion}', '{$this->email}', {$this->admin}, '{$this->token}', {$this->confirmado})";
            $result = self::$db->query($query);
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
        }else {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($this->img['type'], $allowedTypes)) {
                static::$errors[] = "Tipo de imagen no permitido";
            }elseif ($this->img['size'] > 2000000) { // 2MB
                static::$errors[] = "La imagen debe ser menor a 2MB";
            }elseif ($this->img['error'] !== UPLOAD_ERR_OK) {
                static::$errors[] = "Error al subir la imagen,intente conuna imagen diferente o mas pequeña";
            }
        }

        return static::$errors;
    }
}