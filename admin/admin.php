<?php
require '../includes/templates/header.php';
estaLogeado();

$usuario = Usuario::find($_SESSION["usuario"]);
$recetas = Receta::allUser($usuario);




?>

<?php if(empty($recetas)){ ?>
<div class="vacio">
    <h2>No hay recetas creadas</h2>
</div>
<?php } ?>

<?php if(!empty($recetas)){ ?>
<section class="recetas container">

    <?php foreach($recetas as $receta){ ?>
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

<section class="admin">
    <a class="btn-crear" href="/admin/recetas/crear.php">Crear Receta</a>
</section>


<?php require '../includes/templates/footer.php' ?>

