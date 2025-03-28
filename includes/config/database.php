<?php

function conectarDB(): mysqli {
    $db =   mysqli_connect('localhost', 'root', 'root', 'pruba_pulperia');

    if (!$db) {
        echo 'Error: [No se pudo conectar con la base de datos]';
        exit;
    }

    return $db;
}