<?php

require '../includes/app.php';
estaAutenticado(true); // Para poder usar los datos en fuera de la sesion (NO TOCAR)
$db = conectarDB(); // Conectarse a la bd

$HTML_tabla = ''; // texto para generar las filas de las tablas

// Obtenemos los datos de la sesion para consular a la bd
$columnas = $_SESSION['columnas'];
$tabla = $_SESSION['tabla'];
$texto_boton = $_SESSION['btn_texto'];
$ruta_imagen = $_SESSION['ruta'];
$inner = $_SESSION['inner']; // en caso que exista consulta con mas de una tabla
$enlace = $_SESSION['enlace'];

// Verifivar que se escriba algo en la busqueda y evitar inyecciones SQL
$campo = isset($_POST['campo-buscar']) ? mysqli_real_escape_string($db, $_POST['campo-buscar']) : null;

$where = ''; // Variable para los productos buscados

// verificar que el where no este vacio
if ($campo != null) {

    $where = "WHERE (";
    $contar = count($columnas);
    for ($i = 0; $i < $contar; $i++) {
        $where .= $columnas[$i] . " LIKE '%" . $campo . "%' OR ";
    }

    $where = substr_replace($where, "", -3); //Eliminar el'OR' de la ultima concatenacion 
    $where .= ")"; // cerrar el 'where(uno OR dos OR tres)'
}

if (count($tabla) === 1) {

    $consulta = "SELECT " . implode(', ', $columnas) . " FROM $tabla[0] $where";
} else {

    $consulta = "SELECT " . implode(', ', $columnas) . " FROM $inner $where";
}


$resultado = mysqli_query($db, $consulta);

$num_filas = mysqli_num_rows($resultado);

if ($num_filas > 0) {

    // obtener una fila de la bd
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $HTML_tabla .= '<tr>'; // abrir la fila

        // agregar columna por columna a la tabla
        for ($i = 0; $i < count($columnas); $i++) {

            if ($columnas[$i] === 'imagen') {

                $HTML_tabla .= "<td><img class='img-producto' src='/{$ruta_imagen}/" . $fila[$columnas[$i]] . "' alt = 'imagen producto'></img> </td>";
            } else {

                $HTML_tabla .= '<td>' . $fila[$columnas[$i]] . '</td>';
            }   
        }

        // la siguiente linea es el boton de 'accion', enlace[0] es la pagina a donde se dirige y enlace[1] es el identificador de la tabla que se esta consultando
        $HTML_tabla .= "<td><a class='boton-azul' href='{$enlace[0]}" . $fila[$enlace[1]] . "'>" . $texto_boton . "</a></td>"; // boton de la accion
        $HTML_tabla .= '</tr>'; // cerrar la fila
    }
} else { // indicar que no hay resultados

    $HTML_tabla .= '<tr>';
    $HTML_tabla .= '<td colspan=' . count($columnas) + 1 . '>Sin resultados</td>';
    $HTML_tabla .= '</tr>';
}

// enviar los valores al JS para procesarlos y mostrarlos en el cliente(DOM)
echo json_encode($HTML_tabla, JSON_UNESCAPED_UNICODE);