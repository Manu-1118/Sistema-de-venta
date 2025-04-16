<!-- Plantilla para mostrar el slidebar donde se convoque -->
<?php $pagina = basename($_SERVER['PHP_SELF']); ?>
<div class="contenedor-admin sidebar" id="sidebar">
    <nav>
        <ul>
            <li>
                <a href="/admin/control/productos.php" class="<?php echo ($pagina === "productos.php") ? 'seleccionado' : ''; ?>">
                    <img class="icono-principal" src="/build/img/icons/productos.png" alt="icono">
                    <span>Productos</span>
                </a>
            </li><!--.opcion 1-->
            <li>
                <a href="/admin/control/contado.php" class="<?php echo ($pagina === "contado.php") ? 'seleccionado' : ''; ?>">
                    <img class="icono-principal" src="/build/img/icons/contado.png" alt="icono">
                    <span>Al Contado</span>
                </a>
            </li><!--.opcion 2-->
            <li>
                <a href="/admin/control/creditos.php" class="<?php echo ($pagina === "creditos.php") ? 'seleccionado' : ''; ?>">
                    <img class="icono-principal" src="/build/img/icons/credito.png" alt="icono">
                    <span>Al Crédito</span>
                </a>
            </li><!--.opcion 3-->
            <li>
                <a href="/admin/control/compras.php" class="<?php echo ($pagina === "compras.php") ? 'seleccionado' : ''; ?>">
                    <img class="icono-principal" src="/build/img/icons/compra.png" alt="icono">
                    <span>Compras</span>
                </a>
            </li><!--.opcion 4-->
            <li>
                <a href="/admin/control/devueltos.php" class="<?php echo ($pagina === "devueltos.php") ? 'seleccionado' : ''; ?>">
                    <img class="icono-principal" src="/build/img/icons/dañado.png" alt="icono">
                    <span>Devueltos</span>
                </a>
            </li><!--.opcion 5-->
            <li>
                <a href="/admin/control/consumidos.php" class="<?php echo ($pagina === "consumidos.php") ? 'seleccionado' : ''; ?>">
                    <img class="icono-principal" src="/build/img/icons/consumido.png" alt="icono">
                    <span>Consumidos</span>
                </a>
            </li><!--.opcion 6-->
            <li>
                <a href="/admin/control/clientes.php" class="<?php echo ($pagina === "clientes.php") ? 'seleccionado' : ''; ?>">
                    <img class="icono-principal" src="/build/img/icons/cliente.png" alt="icono">
                    <span>Clientes</span>
                </a>
            </li><!--.opcion 7-->
            <li>
                <a href="/admin/control/proveedores.php" class="<?php echo ($pagina === "proveedores.php") ? 'seleccionado' : ''; ?>">
                    <img class="icono-principal" src="/build/img/icons/proveedor.png" alt="icono">
                    <span>Proveedores</span>
                </a>
            </li><!--.opcion 8-->
            <li>
                <a href="/admin/control/administradores.php" class="<?php echo ($pagina === "administradores.php") ? 'seleccionado' : ''; ?>">
                    <img class="icono-principal" src="/build/img/icons/admin.png" alt="icono">
                    <span>Administradores</span>
                </a>
            </li><!--.opcion 9-->
        </ul>
    </nav>

    <a href="/logout.php" class="logout">
        <img class="icono-principal" src="/build/img/icons/logout.png" alt="icono">
        <span>Cerrar Sesión</span>
    </a>

</div><!--.Menu desplegable-->