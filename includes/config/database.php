<?php 

function conectarBD(){
    $db = new mysqli("localhost", "root", "root", "irecipe");

    if(!$db){
        echo "Error en la al conectarse a la BD";
        exit;
    }else{
        return $db;

    }

}