<?php
require '../../includes/templates/header.php';
$receta = Receta::find($_GET["id"]);
if($_SERVER["REQUEST_METHOD"] === "POST"){
    if($receta->actualizar($_POST)){
        header("Location: /admin/admin.php");
    }
}
?>
<section class="crear">
    <h2>Crear Receta</h2>

    <form class="form-crear" method="POST" enctype="multipart/form-data">
        <div class="crear-datos">
            <input type="text" name="titulo" placeholder="Título" value="<?php echo $receta->getTitulo()?>" required maxlength="50">
            <input type="text" name="descripcion" placeholder="Breve Descripción (Máx: 150 letras)" value="<?php echo $receta->getDescripcion()?>" required maxlength="150">
            <div class="mantener-imagen">
                <img src="/imagenes/<?php echo $receta->getImagen()?>" alt="<?php echo $receta->getTitulo()?>">

                <div class="contenedor-check">
                    <label for="mantener_imagen">Quiero mantener esta imagen</label>
                    <input type="checkbox" id="mantener_imagen" name="mantener_imagen" checked>
                </div>
            </div>
            <input class="subir-imagen" type="file" name="imagen" value="Foto Receta">
            <textarea name="ingredientes" placeholder="Ingredientes" wrap="soft" required><?php echo $receta->getIngredientes()?></textarea>
            <textarea name="elaboracion" placeholder="Elaboración" wrap="soft" required><?php echo $receta->getElaboracion()?></textarea>
        </div>

        <div class="admin">
        <input type="submit" class="btn-actualizar" value="Actualizar">

        <a href="/admin/recetas/eliminar.php?id=<?php echo $receta->getId()?>" class="btn-eliminar">Eliminar</a>
    </div>      
    </form>
</section>
<?php require '../../includes/templates/footer.php' ?>