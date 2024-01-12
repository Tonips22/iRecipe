<?php 
    include '../includes/app.php';
    include '../../includes/app.php';
    include 'includes/app.php';

    if(!isset($_SESSION)) {
        session_start();
    }

    $auth = $_SESSION['login'] ?? false;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Social media where post your best recipes">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iRecipe</title>

    <!--Styles-->
    <link rel="stylesheet" href="/assets/css/app.css">

    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:ital,wght@0,400;0,700;1,400;1,700&family=Poppins:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <!--Icons-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
    <header>
        <h1 class="title"><a href="\"><span>i</span>Recipe</a></h1>

        <svg class="menu-nav display-none" xmlns="http://www.w3.org/2000/svg" height="20" width="17.5" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"/></svg>

        <div class="nav-bar">
            <ul>
                <li><a href="/templates/nosotros.php">¿Qué es iRecipe?</a></li>
                <li><a href="/">Recetas</a></li>
                <li><a href="/templates/contacto.php">Contacto</a></li>
                <?php if($auth){ ?>
                <li><a href="/admin/admin.php">Administrar</a></li>
                <?php } ?>    
                
            </ul>
        </div>

        <?php if(!$auth){ ?>
        <a href="/templates/iniciar-sesion.php" class="btn-sesion">Iniciar Sesión</a>        
        <?php }else{ ?>
        <a href="/templates/cerrar-sesion.php" class="btn-cerrar-sesion">Cerrar Sesion</a>        
        <?php } ?>    
    </header>