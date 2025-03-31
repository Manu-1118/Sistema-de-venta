<?php

/** Creacion de constantes **/
define('TEMPLATES_URL', __DIR__ . '/template');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');

function incluirTemplate(string $nombre, $inicio = false)
{
    include TEMPLATES_URL . "/{$nombre}.php";
}

function estaAutenticado() //funcion para verificar si inicio sesion
{
    session_start();

    if (!$_SESSION['login']) {
        return header('Location: /');
    }
}


//unicamente uso para visualizar las variables, arreglos, etc...
function debuguear($contenido)
{
    echo "<pre>";
    var_dump($contenido);
    echo "</pre>";
    exit;
}
