<?php

require '../includes/templates/header.php';


if($_SERVER["REQUEST_METHOD"] === "POST"){
    $usuario = new Usuario($_POST);
    $existe = $usuario->existeUsuario();
    $errores;

    if(!$existe){
        Usuario::addError("Usuario o contraseña incorrecta");
        $errores = Usuario::getErrores();

    }else{

        $usuario_real = Usuario::find($usuario->getUsuario());
        $resultado = $usuario_real->verificarPassword($_POST["password"]);

        if($resultado){
            header("Location: /admin/admin.php");
            mostrar($_SESSION);
        }else{
            Usuario::addError("Usuario o contraseña incorrecta");
            $errores = Usuario::getErrores();
        }
    }
}

?>

<section class="ini-seccion">
    <form class="ini-card" method="POST">
        <h2>Iniciar Sesion</h2>

        <div class="ini-datos">
                <input type="text" name="usuario" id="usuario" placeholder="Usuario" required autofocus>
                <input type="password" name="password" id="password" placeholder="Constraseña" required>
        </div>

        <div class="submit-reg">
            <input type="submit" value="Iniciar Sesion">
            <p>¿No tienes una cuenta? <a href="/templates/registrarse.php">Registrarse</a></p>
        </div>
    </form>
</section>

<?php if(!$existe || !$resultado){ ?>
    <div class="errores">
        <?php foreach($errores as $error){ ?>
            <p class="error-notify"> <?php echo $error ?> </p>
        <?php } ?>
    </div>
<?php } ?>

<?php require '../includes/templates/footer.php' ?>
