<?php 

class Usuario{
    protected static $db;
    protected static $errores = [];
    protected static $mensajes = [];

    private $nombre;
    private $apellidos;
    private $email;
    private $creado;


    private $usuario;
    private $password;

    // Validacion
    private function validar(){
        if($this->nombre === ""){
            self::$errores[] = "Debes introducir un nombre";
        }

        if($this->email === ""){
            self::$errores[] = "Debes introducir correo electrónico";
        }

        if($this->usuario === ""){
            self::$errores[] = "Debes introducir tu nombre de usuario";
        }

        if($this->password === ""){
            self::$errores[] = "Debes introducir una contraseña";
        }
    }

    public function sanear($args = []) {
        $saneado = [];
        foreach($args as $key => $value ) {
            $saneado[$key] = self::$db->escape_string($value);
        }
        return $saneado;
    }

    // Hashear password
    private function hash($password){
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        return $passwordHash;
    }

    // Constructor
    public function __construct($args = []){
        $saneado = $this->sanear($args);
        $this->nombre = $saneado["nombre"] ?? "";
        $this->apellidos = $saneado["apellidos"] ?? "";
        $this->creado = date("Y/m/d");
        $this->email = $saneado["email"] ?? "";
        $this->usuario = $saneado["usuario"] ?? "";
        $this->password = isset($saneado["password"]) ? $this->hash($saneado["password"]) : "";
    }

    // Crear
    public function crear(){
        // Validamos
        $this->validar();

        // Creamos
        $query = "INSERT INTO usuario (nombre, apellidos, email, creado, usuario, password) VALUES ( ?, ?, ?, ?, ?, ?);";

        $stmt = self::$db->prepare($query);
        $stmt->bind_param("ssssss", $this->nombre, $this->apellidos, $this->email, $this->creado, $this->usuario, $this->password);
        $resultado = $stmt->execute();
    }

    public function existeUsuario(){
        $query = "SELECT * FROM usuario WHERE usuario = ?";

        $stmt = self::$db->prepare($query);
        $stmt->bind_param("s", $this->usuario);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows){
            return true;
        }
        
        return false;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getUsuario(){
        return $this->usuario;
    }

    public function getApellidos(){
        return $this->apellidos;
    }

    public function getPassword(){
        return $this->password;
    }

    // Asignar BD
    public static function setDataBase($db){
        self::$db = $db;
    }

    // Obtener errores
    public static function getErrores(){
        return self::$errores;
    }

    public static function addError($error){
        self::$errores[] = $error;
    }

    // Obtener errores
    public static function getMensajes(){
        return self::$mensajes;
    }

    public static function addMensaje($mensaje){
        self::$mensajes[] = $mensaje;
    }
    
    public static function all(){
        $query = "SELECT * FROM usuario";
        $resultado = [];  // Incompleto

        return $resultado;
    }

    public static function find($nombre_usuario) {
        $query = "SELECT * FROM usuario WHERE usuario = \"$nombre_usuario\"";
        $resultado = self::$db->query($query);

        $usuario = $resultado->fetch_assoc();
        $usuario = self::crearObjeto($usuario);



        return $usuario;
    }

    protected static function crearObjeto($registro) : Usuario{
        $usuario = new Usuario();

        foreach($registro as $key => $value ) {
            if(property_exists( $usuario, $key  )) {
                $usuario->$key = $value;
            }
        }

        return $usuario;
    }
    
    public function verificarPassword($password){
        $auth = password_verify($password, $this->password);

        if($auth){
            session_start();
            $_SESSION["nombre"] = $this->nombre;
            $_SESSION["apellidos"] = $this->apellidos;
            $_SESSION["usuario"] = $this->usuario;
            $_SESSION["login"] = true;
            return true;
        }
        return false;
    }

    

}