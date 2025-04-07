<?php
require '../../includes/app.php';
require '../../includes/data/proveedores.php';

estaAutenticado();
incluirTemplate('header');
incluirTemplate('slidebar');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_proveedor_eliminar'])) {
    $id_proveedor_eliminar = mysqli_real_escape_string($db, $_POST['id_proveedor_eliminar']);

    if (is_numeric($id_proveedor_eliminar)) {
        $query_eliminar = "DELETE FROM proveedor WHERE id = $id_proveedor_eliminar";
        $resultado_eliminar = mysqli_query($db, $query_eliminar);

        if ($resultado_eliminar) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Proveedor eliminado correctamente.'
                }).then(() => {
                    window.location.href = 'proveedores.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al eliminar el proveedor: " . mysqli_error($db) . "'
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'ID de proveedor inválido.'
            });
        </script>";
    }
}
?>

<main id="main" class="main admin main-admin menu-toggle">
    <h1>Proveedores</h1>

    <div class="contenedor">
        <div class="barra-busqueda">
            <input type="text" id="busqueda" placeholder="Buscar Proveedor...">
            <button id="agregar" onclick="window.location.href='proveedorForm.php';">
                <img src="/src/img/icons/agregar.png" width="40" height="45" alt="Agregar Proveedor">
            </button>
        </div>
        <div class="tabla-container">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Empresa</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($proveedores as $proveedor) : ?>
                        <tr>
                            <td><?php echo $proveedor['id']; ?></td>
                            <td><?php echo $proveedor['nombres']; ?></td>
                            <td><?php echo $proveedor['apellidos']; ?></td>
                            <td><?php echo $proveedor['empresa']; ?></td>
                            <td><?php echo $proveedor['telefono']; ?></td>
                            <td>
                            <a href="proveedores_editar.php?id=<?php echo $proveedor['id']; ?>" class="editar-btn">✏️ Editar</a>
                            <a href="compras.php?id=<?php echo $proveedor['id']; ?>" class="accion-btn"> Compras</a>
                            <a href="#" class="accion-btn eliminar-proveedor" data-id="<?php echo htmlspecialchars($proveedor['id']); ?>">❌ Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php incluirTemplate('footer'); ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const botonesEliminar = document.querySelectorAll('.eliminar-proveedor');
        botonesEliminar.forEach(boton => {
            boton.addEventListener('click', function(evento) {
                evento.preventDefault();
                const proveedorId = this.dataset.id;
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formulario = document.createElement('form');
                        formulario.method = 'POST';
                        formulario.action = '';
                        formulario.innerHTML = `<input type="hidden" name="id_proveedor_eliminar" value="${proveedorId}">`;
                        document.body.appendChild(formulario);
                        formulario.submit();
                    }
                });
            });
        });
    });
</script>