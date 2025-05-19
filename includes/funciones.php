<?php

/** Creacion de constantes **/
define('TEMPLATES_URL', __DIR__ . '/template');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');

function incluirTemplate(string $nombre, $inicio = false)
{
    include TEMPLATES_URL . "/{$nombre}.php";
}

function estaAutenticado($cliente = false) //funcion para verificar si inicio sesion
{
    session_start();

    if (!$_SESSION['login'] && $cliente === false) {
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

function ArreglosDeDatos($columnas = [], $tabla, $texto_boton): array
{
    $Contenedor = [
        'columnas' => $columnas,
        'tabla' => $tabla,
        'btn_texto' => $texto_boton
    ];

    return $Contenedor;
}


// funcion para obtener la imagen subida y moverla a la carpeta indicada en el servidor
function guardarImagen($carpeta, $imagen): string
{
    // si la carpeta donde se guardara la imagen no existe, que se cree
    $carpetaImagenes = '../../../img/' . $carpeta . '/';
    if (!is_dir($carpetaImagenes)) {
        mkdir($carpetaImagenes);
    }

    // generar nombre unico para cada imagen
    $nombreImagen = md5(uniqid(rand(), true)) . '.jpg';

    // guardar la imagen cargada en el servidor
    move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);

    return $nombreImagen;
}

// funcion para eliminar imagen pasada si se actualiza
function modificarImagen($carpeta, $entidad)
{

    // obtener la carpeta para ubicar el archivo
    $carpetaImagenes = '../../../img/' . $carpeta . '/';

    // eliminar el archivo
    unlink($carpetaImagenes . $entidad['imagen']);
}


//funcion para crear la carpeta img de la raiz para almacenar todas las imagenes
function crearContenedorImagenes()
{

    $carpetaImagenesRaiz = '../../../img/';
    if (!is_dir($carpetaImagenesRaiz)) {
        mkdir($carpetaImagenesRaiz);
    }
}
