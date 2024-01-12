<?php 
require '../../includes/templates/header.php';

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $usuario = Usuario::find($_SESSION["usuario"]);
    $receta = new Receta($_POST,$usuario);
    if($receta->crear()){
        header('Location: /admin/admin.php');
    }else{
        echo "Error al crear la receta";
    }
}
?>

<section class="crear">
    <h2>Crear Receta</h2>

    <form class="form-crear" method="POST" enctype="multipart/form-data">
        <div class="crear-datos">
            <input type="text" name="titulo" placeholder="Título" required autofocus maxlength="50">
            <input type="text" name="descripcion" placeholder="Breve Descripción (Máx: 150 letras)" required maxlength="150">
            <input type="file" name="imagen" value="Foto Receta">
            <textarea name="ingredientes" placeholder="Ingredientes" wrap="soft" required></textarea>
            <textarea name="elaboracion" placeholder="Elaboración" wrap="soft" required></textarea>
        </div>

        <input class="crear-submit" type="submit" value="Crear">        
    </form>
</section>


<?php 
require '../../includes/templates/footer.php';
?>