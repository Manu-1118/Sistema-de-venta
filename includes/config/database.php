<?php


function conectarDB(): mysqli {
    $db =   mysqli_connect('localhost', 'root', '', 'pruba_pulperia');

    if (!$db) {
        echo 'Error: [No se puede conectar con la base de datos]';
        exit;
    }

    return $db;
}