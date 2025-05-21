<?php
require 'includes/app.php';
estaAutenticado(true); //verificar que $_SESSION sea true
$db = conectarDB();

$encabezados = ['Imagen', 'Código', 'Nombre', 'Descripción', 'Disponible', 'Precio']; //encabezados de la tabla correspondiente
// variables para añadirlas al archivo "/data/obtener_datos.php"
$columnas = ['imagen', 'codigo_producto', 'nombre', 'descripcion', 'cantidad', 'precio_unitario'];
$tabla[] = 'Producto';
$btn_texto = 'Añadir';
$ruta_imagen = 'img/productos/';
$enlace = ['lista.php?id=', 'codigo_producto'];
$_SESSION['encabezados'] = $encabezados;
$_SESSION['columnas'] = $columnas;
$_SESSION['tabla'] = $tabla;
$_SESSION['btn_texto'] = $btn_texto;
$_SESSION['ruta'] = $ruta_imagen;
$_SESSION['enlace'] = $enlace;


// Verficar que exista el arreglo para almacenar los productos que llevara el cliente
if (!isset($_SESSION['lista_productos'])) {
    $_SESSION['lista_productos'] = []; // si no existe se crea
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET)) { // verificar que no este vacio el metodo get

    // debuguear($_GET);
    $codigo = filter_var($_GET['id'], FILTER_VALIDATE_INT); // obtener el codigo del producto a editar y verificar que sea un valor correcto
    $borrar = filter_var($_GET['borrar'], FILTER_VALIDATE_INT);
    $eliminar = filter_var($_GET['eliminar_id'], FILTER_VALIDATE_INT);

    if (!$codigo) { // verificar que el valor del metodo get no sea diferente a un codigo int
        header('Location: lista.php'); // redirigir a la pagina si no se digita algo correcto
    }

    if (!$eliminar) { // verificar si se selecciono la eliminacion de un elemento seleccionado
        header('Location: lista.php'); // redirigir a la pagina si no se digita algo correcto
    } else {

        $contador = 0; //contador para eliminar la posicion del elemento del arreglo
        foreach ($_SESSION['lista_productos'] as $producto) { // recorrer los elementos
            if ($producto['codigo_producto'] != $eliminar) {

                $contador++;
            } else {
                unset($_SESSION['lista_productos'][$contador]); // eliminar el producto
                $_SESSION['lista_productos'] = array_values($_SESSION['lista_productos']); // reordenar el arreglo
            }
        }
    }

    if (!$borrar) { // verificar que el valor del metodo get no sea diferente a un codigo int

        header('Location: lista.php'); // redirigir a la pagina si no se digita algo correcto
    } else if ($borrar === 1) {
        $_SESSION['lista_productos'] = [];
    } else {
        header('Location: lista.php'); // redirigir a la pagina si no se digita algo correcto
    }

    $encontrarProducto = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM Producto WHERE codigo_producto = $codigo"));
    $_SESSION['lista_productos'][] = $encontrarProducto;

}
$ListaProductos = $_SESSION['lista_productos'];

// debuguear($ListaProductos);

incluirTemplate('header', true);
?>

<section class="imagen-lista-compras">
    <img src="/build/img/banner-lista-compra.png" alt="Banner encabezado">
</section>

<main id="main" class="principal fondo crear-lista">

    <div class="contenedor-lista">
        <?php incluirTemplate('tabla_datos'); ?>
    </div>

    <div class="contenedor-seleccionados">
        <h2>Productos Seleccionados</h2>
        <div class="productos-seleccionados">
            <ul>

                <?php foreach ($ListaProductos as $producto): ?>
                    <div class="row-lista">
                        <li class="row">

                            <a class="producto" href="lista.php?eliminar_id=<?php echo $producto['codigo_producto']; ?>">
                                <span> <img src="/build/img/icons/delete.svg" alt="X- "><?php echo $producto['nombre']; ?></span>
                            </a>

                            <div class="input-cantidad">
                                <input type="number" name="txtCantidad" id="txtCantidad" min='1' placeholder="cant.">
                            </div>

                        </li>
                    </div>
                <?php endforeach; ?>
            </ul>

        </div>

    </div>
    <div class="botones alinear-derecha">
        <a class="boton-verde">Generar Lista</a>
        <a class="boton-rojo" href="lista.php?borrar=1">Borrar Lista</a>
    </div>

</main>

<?php
incluirTemplate('footer');
?>