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
        $this->token = $data['token'] ;
        $this->confirmado = $data['confirmado'] ?? 0;
        $this->direccion = $data['direccion'] ?? '';

        $this->name = self::$db->real_escape_string($this->name);
        $this->email = self::$db->real_escape_string($this->email);
        $this->password = self::$db->real_escape_string($this->password);
        $this->direccion = self::$db->real_escape_string($this->direccion);
        $this->img = self::$db->real_escape_string($this->img['name'] ?? '');  
        $this->token = self::$db->real_escape_string($this->token);
     
        

    }

    public function login(){

        $r = $this->validatelogin();
        if(empty($r)){

            $query = "SELECT * FROM " . static::$table . " WHERE email = '{$this->email}' LIMIT 1";
            $result = self::$db->query($query);

            if ($result && $result->num_rows === 1) {
                $user = $result->fetch_assoc();
                if (password_verify($this->password, $user['password'])) {
                    if ($user['confirmado'] == 1) {
                       
                        if($user["admin"]==1){
                            $admin =true;
                        }else{
                            $admin=false;
                        }
                        session_start();
                        $_SESSION =["id" => $user["id"],
                                    "nombre"=>$user["nombre"],
                                    "img"=> $user["img"],
                                    "direccion" =>$user["direccion"],
                                    "email"=>$user["email"],
                                    "login"=>true,
                                    "admin"=>$admin];

                        return true;
                    } else {
                        return "Cuenta no confirmada";
                    }
                } else {
                    return "Contraseña incorrecta";
                }
            } else {
                return "Usuario no encontrado";
            }

        }else{
            return $r;
        }

    }

    public function getimg($data = []){
          $this->img = $data['img'] ?? [];
    }
    public function register(){
        $r=$this->validate();
        $this->token= $this->token();
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

    public function reset(){
        static::$errors = [];
        if(!$this->password){
           static::$errors[] = "contaseña obligatoria";
        }
        if(!$this->token){
              static::$errors[] = "token no valido";
        }
        if(!empty(static::$errors)){
            return static::$errors;
        }else{

             $query = "SELECT * FROM " . static::$table . " WHERE token = '{$this->token}'";
             $result = self::$db->query($query);

             if($result->num_rows <= 0){
                return "espiro la pagina";
             }else{
                 $this->password = password_hash($this->password, PASSWORD_BCRYPT);
                 $query = "UPDATE " . static::$table . " SET password = '{$this->password}', token = '' WHERE token = '{$this->token}'";
            $result = self::$db->query($query);
            if($result){
                return true;
            }else{
                return "Error al actualizar la contraseña";
            }
             }
        }
    }

    public function forget(){
        if(empty($this->email)){
            return "Email es obligatorio";
        }
        $this->email = self::$db->real_escape_string($this->email);
        $query = "SELECT * FROM " . static::$table . " WHERE email = '{$this->email}'";
        $result = self::$db->query($query);
        if($result->num_rows > 0){
            $token = $this->token();
            $user = $result->fetch_object();
            if($user->confirmado == 0){
                return "Cuenta no confirmada";
            }else{
            $query = "UPDATE " . static::$table . " SET token = '$token' WHERE email = '{$this->email}'";
            self::$db->query($query);
            $email = new email($user->nombre, $this->email);
            $email->sendEmail(
                "Recuperar contraseña",
                "<p>Hola {$user->nombre},</p>
                <p>Has solicitado recuperar tu contraseña. Por favor, haz clic en el siguiente enlace para restablecerla:</p>
                <a href='http://localhost:3000/reset?token={$token}'>Recuperar Contraseña</a>
                <p>Si no solicitaste esto, ignora este mensaje.</p>"
            );

            return true;
        }
        }
        else{
            return "Email no encontrado";
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
        }else{
            $this->password = password_hash($this->password, PASSWORD_BCRYPT);
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

    public function existeUser(){
        $query ="SELECT * FROM ".static::$table." WHERE email=".$this->email;
        $r =self::db->query($query);
        if($r->num_rows ==0){
            return false;
        }else{
            return true;
        }
    }

    public function validatelogin()
    {
        static::$errors = [];
         
        if (empty($this->email)) {
             static::$errors[] ="email es obligatorio";
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
             static::$errors[] ="email no valido";;
        }
        
        if (empty($this->password)) {
         static::$errors[] ="contrasena obligatoria";
        } 
        
        return static::$errors;
    }
}