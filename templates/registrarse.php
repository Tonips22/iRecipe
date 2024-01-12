<?php
require '../includes/templates/header.php';

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $usuario = new Usuario($_POST);
    $existe_usuario = $usuario->existeUsuario();
    $errores;
    $mensajes;

    if(!$existe_usuario){
        $usuario->crear();
        Usuario::addMensaje("Usuario creado con éxito");
        $mensajes = Usuario::getMensajes();
        


    }else {
        Usuario::addError("Ya existe un usuario con este nombre");
        $errores = Usuario::getErrores();


    }
    
}

?>

<section class="ini-seccion">
    <form class="ini-card" method="POST">
        <h2>Registrarse</h2>

        <div class="ini-datos">
                <input type="text" name="nombre" id="nombre" placeholder="Nombre" required autofocus>
                <input type="text" name="apellidos" id="apellidos" placeholder="Apellidos" required>
                <input type="email" name="email" id="e-mail" placeholder="E-mail" required>
                <input type="text" name="usuario" id="usuario" placeholder="Usuario" required>
                <input type="password" name="password" id="password" placeholder="Constraseña" required>
        </div>

        <div class="submit-reg">
            <input type="submit" value="Registrarse">
            <p>¿Tienes ya una cuenta? <a href="/templates/iniciar-sesion.php">Iniciar Sesión</a></p>
        </div>
    </form>
</section>

<?php if($existe_usuario){ ?>
    <div class="errores">
        <?php foreach($errores as $error){ ?>
            <p class="error-notify"> <?php echo $error ?> </p>
        <?php } ?>
    </div>
<?php }else{ ?>
    <div class="mensajes">
        <?php foreach($mensajes as $mensaje){ ?>
            <p class="msg-notify"> <?php echo $mensaje ?> </p>
        <?php } ?>
    </div>
<?php } ?>

<?php require '../includes/templates/footer.php' ?>