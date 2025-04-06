<?php
require '../../includes/app.php';
require '../../includes/data/productos.php';
estaAutenticado(); //verificar que $_SESSION sea true

//Conectar la bd
$db = conectarDB();

//escribir el query
$query_mostrar = "SELECT * FROM Producto limit 5;";

//consultar la bd y obtener resultado
$resultado_mostrar = mysqli_query($db, $query_mostrar);

// //Arreglo para validacion
// $errores = [];

// $codigo = '';
// $nombre = '';
// $precio = '';
// $descripcion = '';
// $categoria = '';
// // $imagen = '';


// verificar que se mando informacion al post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //debuguear($_POST);

    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {

        $query_eliminar = "DELETE FROM Producto WHERE codigo = $id;";
        $resultado_eliminar = mysqli_query($db, $query_eliminar);

        if ($resultado_eliminar) {
            header('Location: /admin/control/productos.php');
        }
    }
}

//     // Obtener los valores del POST y escapar las cadenas de texto para evitar inyecciones sql
//     $codigo = mysqli_real_escape_string($db, $_POST['txtCodigo']);
//     $nombre = mysqli_real_escape_string($db, $_POST['txtNombre']);
//     $precio = mysqli_real_escape_string($db, $_POST['txtPrecio']);
//     $descripcion = mysqli_real_escape_string($db, $_POST['txtDescripcion']);
//     $categoria = mysqli_real_escape_string($db, $_POST['cbCategoria']);

//     // si un campo esta vacio, mandar error
//     if (!$codigo || !$nombre || !$precio || !$descripcion || !$categoria) {
//         $errores[] = "Todos los campos son obligatorios";
//     }
//     // Validar precio
//     if (!is_numeric($precio)) {
//         $errores[] = "El precio debe ser un número válido.";
//     }

// if (!$codigo==='') {

//     $query_codigo = "SELECT * FROM Producto WHERE codigo = $codigo;";
//     $resultado_buscar_codigo = mysqli_query($db, $query_insertar);

//     if ($resultado_buscar_codigo) {
//         $errores[] = "Ya existe un producto con ese código";
//     }
// }


//debuguear($errores);

// si el arreglo de errores esta vacio, hacer la insercion
// if (empty($errores)) {

//     // Crear consulta con los valores
//     $query_insertar = "INSERT INTO Producto (codigo, nombre, precio_unitario, descripcion, categoria) VALUES ('$codigo', '$nombre', '$precio', '$descripcion', '$categoria');";

//     $resultado_insertar = mysqli_query($db, $query_insertar);

//     //debuguear($resultado_insertar);

//     // si el resultado devolvio una fila modificada mostrar que si se inserto
//     if ($resultado_insertar) {
//         header('Location: ' . $_SERVER['PHP_SELF'] . '?resultado=1');
//     } else {

//         header('Location: ' . $_SERVER['PHP_SELF'] . '?resultado=2');
//         //header('Location: admin/control/productos.php?mensaje=Error al Añadir el Producto');
//     }
//}
//}

$resultado_mensaje = $_GET['resultado'] ?? null;

incluirTemplate('header');
incluirTemplate('slidebar');
?>

<!-- class="main admin menu-toggle" -->

<main id="main" class="main admin main-admin menu-toggle">

    <?php if (intval($resultado_mensaje) === 1): ?>
        <p class="alerta exito">El producto se agregó correctamente</p>
    <?php elseif (intval($resultado_mensaje) === 2): ?>
        <p class="alerta exito">El producto se modificó correctamente</p>
    <?php endif; ?>

    <div class="contenedor-productos">

        <div class="contenedor-herramientas">

            <div class="contenedor-busqueda">

                <form method="POST" class="formulario busqueda">
                    <label for="campo">Buscar</label>
                    <input type="text" name="campo" id="campo" placeholder="Producto...">
                </form>

            </div>

            <a href="productos_crear.php" class="btn-agregar boton-azul">
                <img src="/build/img/icons/agregar.png" alt="+" class="icono-principal">
                <span>Nuevo</span>
            </a>

        </div>

        <div class="tabla-containe">
            <table class="tabla-productos">
                <thead>
                    <tr>
                        <th>#</th>
                        <!-- <th>imagen</th> -->
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <!-- <th>Imagen</th> -->
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    while ($producto = mysqli_fetch_assoc($resultado_mostrar)): ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <!-- <td><?php echo "imagen producto" ?></td> -->
                            <td><?php echo $producto['codigo']; ?></td>
                            <td><?php echo $producto['nombre']; ?></td>
                            <td><?php echo $producto['descripcion']; ?></td>
                            <td><?php echo $producto['cantidad']; ?></td>
                            <td><?php echo $producto['categoria']; ?></td>
                            <td><?php echo $producto['precio_unitario']; ?></td>
                            <td class="acciones-tabla">

                                <a href="productos_editar.php?id=<?php echo $producto['codigo']; ?>" class="boton-azul">✏️</a>

                                <form method="POST">
                                    <input type="hidden" name="id" value="<?php echo $producto['codigo']; ?>">
                                    <input type="submit" class="boton-rojo" value="🗑️">
                                </form>

                            </td>
                        </tr>
                    <?php $i++;
                    endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- ventana modal agregar -->
<!-- <input type="checkbox" id="btn-modal">
<div class="contenedor-modal">


    <div class="contenido-modal">

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form method="POST" class="formulario">
            <fieldset>
                <legend>Agregar Producto</legend>

                <label for="txtCodigo">Código</label>
                <input type="text" name="txtCodigo" placeholder="358685" id="txtCodigo" value="<?php echo $codigo; ?>">

                <label for="txtNombre">Nombre</label>
                <input type="text" name="txtNombre" placeholder="Leche Eskimo" id="txtNombre" value="<?php echo $nombre; ?>">

                <label for="txtPrecio">Precio unitario</label>
                <input type="number" name="txtPrecio" placeholder="40.00" id="txtPrecio" value="<?php echo $precio; ?>">

                <label for="imagen">Imagen:</label>
                <input type="file" name="imagen" id="imagen" accept="image/jpeg, image/png" disabled class="disabled">

                <label for="txtDescripcion">Descripción</label>
                <input type="text" name="txtDescripcion" placeholder="Leche Eskimo entera de 900ml..." id="txtDescripcion" value="<?php echo $descripcion; ?>">

                <label for="cbCategoria">Categoría</label>
                <select name="cbCategoria">
                    <option disabled selected>-- Seleccionar Categoría --</option>
                    <option value="1">Lacteos</option>
                </select>

            </fieldset>

            <div class="alinear-derecha separar-margin">

                <label class="boton-rojo" for="btn-modal">
                    <span>Cancelar</span>
                </label>

                <input type="submit" value="Agregar" class="boton-azul">

            </div>

        </form>

    </div>

    <label for="btn-modal" class="cerrar-modal"></label>
</div> -->
<!-- fin ventana modal -->

<!-- ventana modal editar -->
<!-- <input type="checkbox" id="btn-modal-editar">
<div class="contenedor-modal-editar">


    <div class="contenido-modal-editar">

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form method="POST" class="formulario">
            <fieldset>
                <legend>Editar Producto</legend>

                <label for="txtCodigo">Código</label>
                <input type="text" name="txtCodigo" placeholder="358685" id="txtCodigo" value="<?php echo $codigo; ?>">

                <label for="txtNombre">Nombre</label>
                <input type="text" name="txtNombre" placeholder="Leche Eskimo" id="txtNombre" value="<?php echo $nombre; ?>">

                <label for="txtPrecio">Precio unitario</label>
                <input type="number" name="txtPrecio" placeholder="40.00" id="txtPrecio" value="<?php echo $precio; ?>">

                <label for="imagen">Imagen:</label>
                <input type="file" name="imagen" id="imagen" accept="image/jpeg, image/png" disabled class="disabled">

                <label for="txtDescripcion">Descripción</label>
                <input type="text" name="txtDescripcion" placeholder="Leche Eskimo entera de 900ml..." id="txtDescripcion" value="<?php echo $descripcion; ?>">

                <label for="cbCategoria">Categoría</label>
                <select name="cbCategoria">
                    <option disabled selected>-- Seleccionar Categoría --</option>
                    <option value="1">Lacteos</option>
                </select>

            </fieldset>

            <div class="alinear-derecha separar-margin">

                <label class="boton-rojo" for="btn-modal-editar">
                    <span>Cancelar</span>
                </label>

                <input type="submit" value="Agregar" class="boton-azul">

            </div>

        </form>

    </div>

    <label for="btn-modal-editar" class="cerrar-modal-editar"></label>
</div> -->
<!-- fin ventana modal editar -->

<?php incluirTemplate('footer'); ?>