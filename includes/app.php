<?php

require __DIR__ . '/config/database.php';
require __DIR__ . '/funciones.php';
require __DIR__ . '/../classes/usuario.php';
require __DIR__ . '/../classes/receta.php';

$db = conectarBD();

Usuario::setDataBase($db);
Receta::setDataBase($db);