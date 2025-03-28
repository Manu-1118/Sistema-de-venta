<?php

/** Creacion de constantes **/
define('TEMPLATES_URL', __DIR__ . '/template');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');

// VARIABLES GLOBALES
$pagina_actual = "";

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

function seleccion($pagina, $opcion) {
    
    if ($pagina === $opcion) {
        return true;
    }

    return false;
}


//unicamente uso para visualizar las variables, arreglos, etc...
function debuguear($contenido)
{
    echo "<pre>";
    var_dump($contenido);
    echo "</pre>";
    exit;
}
