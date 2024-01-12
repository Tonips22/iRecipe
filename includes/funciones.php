<?php

// define('FUNCIONES_URL', __DIR__ . '/funciones.php');
// define('APP_URL', __DIR__ . '/app.php');
// define('CLASSES_URL', __DIR__ . '/../clases/');
// define('HEADER_URL', __DIR__ . '/templates/header.php');
// define('FOOTER_URL', __DIR__ . '/templates/footer.php');

function mostrar($contenido){
    echo "<pre>";
    var_dump($contenido);
    echo "</pre>";
}

function estaLogeado(){
    session_start();
    if($_SESSION["login"] == false){
        header("Location: /");
    }
}