<?php
require '../includes/templates/header.php';
$receta = Receta::find($_GET["id"]);

if($receta == null){
    header("Location: /");
}
?>
<section class="receta-box">
    <div class="titulo-receta">
        <h2><?php echo $receta->getTitulo() ?></h2>

        <p><?php echo $receta->getDescripcion() ?></p>

        <span>@<?php echo $receta->getUsuario()->getUsuario() ?></span>
    </div>

    <div class="ingr">
        <h3>Ingredientes</h3>

        <p><?php echo $receta->getIngredientes() ?></p>
    </div>

    <div class="ela">
        <h3>Elaboración</h3>

        <p><?php echo $receta->getElaboracion() ?></p>
    </div>

    <img src="/imagenes/<?php echo $receta->getImagen()?>" alt="Foto de receta">

    <?php if($receta->getUsuario()->getUsuario() === $_SESSION["usuario"]){ ?>
    <div class="admin">
        <a href="/admin/recetas/actualizar.php?id=<?php echo $receta->getId()?>" class="btn-editar">Editar</a>

        <a href="/admin/recetas/eliminar.php?id=<?php echo $receta->getId()?>" class="btn-eliminar">Eliminar</a>
    </div>
    <?php } ?>
</section>
<?php require '../includes/templates/footer.php' ?>
