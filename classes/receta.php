<?php

class Receta {
    protected static $db;
    protected static $errores = [];
    protected static $mensajes = [];

    private $titulo;
    private $descripcion;
    private $imagen;
    private $ingredientes;
    private $elaboracion;
    private $usuario;

    private function manejarImagen(){
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
            $nombreOriginal = $_FILES['imagen']['name'];
            $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
    
            // Generar un nombre único para la imagen
            $nombreUnico = uniqid('imagen_') . '.' . 'webp'; // Cambiando a formato WebP
    
            $rutaTemporal = $_FILES['imagen']['tmp_name'];
            $rutaDestino = '../../imagenes/' . $nombreUnico;
    
            // Cambiar el formato de JPEG a WebP
            $imagenOriginal = imagecreatefromjpeg($rutaTemporal);
            imagewebp($imagenOriginal, $rutaDestino, 80); // 80 es la calidad (0-100)
            imagedestroy($imagenOriginal);
    
            // Cambiar el tamaño de la imagen
            $imagenRedimensionada = imagescale($imagenOriginal, 700, 280);
            imagejpeg($imagenRedimensionada, $rutaDestino, 100); // 80 es la calidad (0-100)
            imagedestroy($imagenRedimensionada);
    
            // Mover la imagen a la carpeta destino
            // move_uploaded_file($rutaTemporal, $rutaDestino); // Ya no es necesario, ya que la imagen se ha movido y optimizado
    
            return $nombreUnico; // O puedes almacenar solo el nombre único del archivo, dependiendo de tus necesidades.
        }
    
        return ""; // No se cargó ninguna imagen
    }

    // Elimina el archivo
    public function borrarImagen() {
        // Comprobar si existe el archivo
        $existeArchivo = file_exists('../../imagenes/' . $this->imagen);
        if($existeArchivo) {
            unlink('../../imagenes/' . $this->imagen);
        }
    }
    
    
    

    public function __construct(array $args, Usuario $usuario = null){
        $this->titulo = $args["titulo"] ?? "";
        $this->descripcion = $args["descripcion"] ?? "";
        $this->ingredientes = nl2br($args["ingredientes"]) ?? "";
        $this->elaboracion = nl2br($args["elaboracion"]) ?? "";
        $this->usuario = $usuario ?? null;
        $this->imagen = $this->manejarImagen();
    }

    public function getTitulo(){
        return $this->titulo;
    }
    public function getDescripcion(){
        return $this->descripcion;
    }
    public function getIngredientes(){
        return $this->ingredientes;
    }
    public function getElaboracion(){
        return $this->elaboracion;
    }

    public function getUsuario() : Usuario{
        return $this->usuario;
    }

    public function getId(){
        $query = "SELECT id FROM receta WHERE titulo = ? AND usuario = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param("ss", $this->titulo, $this->usuario->getUsuario());
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        $id = $resultado["id"];

        return $id;
    }

    public function getImagen(){
        return $this->imagen;
    }

    public function setUsuario(Usuario $usuario){
         $this->usuario = $usuario;
    }

    public function crear(){
        $query = 'INSERT INTO receta (titulo, descripcion, imagen, ingredientes, elaboracion, usuario) VALUES (?, ?, ?, ?, ?, ?)';
        $stmt = self::$db->prepare($query);
        $stmt->bind_param("ssssss", $this->titulo, $this->descripcion, $this->imagen, $this->ingredientes, $this->elaboracion, $this->usuario->getUsuario());
        $resultado = $stmt->execute();

        return $resultado;

    }
    public function actualizar(array $args){

        $id = $this->getId();
        if ($id === null) {
            // Manejar el caso en que getId() devuelve null
            return "mariquita";
        }
        $this->titulo = $args["titulo"] ?? "";
        $this->descripcion = $args["descripcion"] ?? "";
        $this->ingredientes = $args["ingredientes"] ?? "";
        $this->elaboracion = $args["elaboracion"] ?? "";
        if(!isset($args["mantener_imagen"])){
            $this->borrarImagen();
            $this->imagen = $this->manejarImagen();
        }
    
        $query = "UPDATE receta SET titulo = ?, descripcion = ?, ingredientes = ?, elaboracion = ?, imagen = ? WHERE id = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param("sssssi", $this->titulo, $this->descripcion, $this->ingredientes, $this->elaboracion, $this->imagen, $id);
        $resultado = $stmt->execute();
    
        return $resultado;
    }
    public function eliminar(){
        $this->borrarImagen();

        $query = 'DELETE FROM receta WHERE id = ?';
        $stmt = self::$db->prepare($query);
        $stmt->bind_param("i", $this->getId());
        $resultado = $stmt->execute();

        return $resultado;

    }

    protected static function crearObjeto($registro, Usuario $usuario) : Receta{
        $receta = new Receta($registro, $usuario);

        foreach($registro as $key => $value ) {
            if(property_exists( $receta, $key  )) {
                $receta->$key = $value;
            }
        }

        $receta->setUsuario($usuario);

        return $receta;
    }

    public static function find($id) : ?Receta{
        $query = "SELECT * FROM receta WHERE id = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        if(!$resultado){
            return null;
        }
        $usuario = Usuario::find($resultado['usuario']);
        $receta = self::crearObjeto($resultado, $usuario);

        return $receta;

    }

    public static function all(){
        $query = "SELECT * FROM receta";
        $stmt = self::$db->prepare($query);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    
        $recetas = [];
        foreach($resultado as $registro) {
            $usuario = Usuario::find($registro['usuario']); // Asume que tienes un método find en la clase Usuario que devuelve un objeto Usuario basado en el ID del usuario.
            $recetas[] = self::crearObjeto($registro, $usuario);
        }

    return $recetas;
    }

    public static function allUser(Usuario $usuario){
        $query = "SELECT * FROM receta WHERE usuario = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param("s", $usuario->getUsuario());
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    
        $recetas = [];
        foreach($resultado as $registro) {
            $recetas[] = self::crearObjeto($registro, $usuario);
        }

        return $recetas;
    }

    public static function setDataBase($db){
        self::$db = $db;
    }
    
}