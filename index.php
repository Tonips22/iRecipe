<?php

require 'includes/templates/header.php';

$usuario = Usuario::find($_SESSION["usuario"]);
$recetas = Receta::all();

?>

<?php if(empty($recetas)){ ?>
<div class="vacio-index">
    <h2>No tienes Recetas creadas</h2>
</div>
<?php } ?>

<?php if(!empty($recetas)){ ?>
<section class="recetas container">

    <?php foreach($recetas as $receta){?>
    <a class="receta" href="/templates/receta.php?id=<?php echo $receta->getId()?>">
        <h2><?php echo $receta->getTitulo(); ?></h2>

        <img src="/imagenes/<?php echo $receta->getImagen() ?>" alt="receta">

        <div class="info-receta">
            <h2><?php echo $receta->getTitulo(); ?></h2>

            <p><?php echo $receta->getDescripcion(); ?></p>

            <p class="usuario">@<?php echo $receta->getUsuario()->getUsuario(); ?></p>
        </div>
    </a>
    <?php } ?>


</section>
<?php } ?>

<?php require 'includes/templates/footer.php' ?>