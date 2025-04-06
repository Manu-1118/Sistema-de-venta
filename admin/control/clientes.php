<?php
require '../../includes/app.php';
require '../../includes/data/clientes.php';

incluirTemplate('header');
incluirTemplate('slidebar');

// Procesamiento de eliminación de clientes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_cliente_eliminar'])) {
    $id_cliente_eliminar = $_POST['id_cliente_eliminar'];

    if (is_numeric($id_cliente_eliminar)) {
        $id_cliente_eliminar = mysqli_real_escape_string($db, $id_cliente_eliminar);

        // 1. Verificar si el cliente tiene créditos asociados
        $query_creditos = "SELECT COUNT(*) FROM credito WHERE id_cliente = $id_cliente_eliminar";
        $resultado_creditos = mysqli_query($db, $query_creditos);
        $num_creditos = mysqli_fetch_array($resultado_creditos)[0];

        if ($num_creditos > 0) {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se puede eliminar el cliente. Tiene créditos asociados.'
                });
            </script>";
        } else {
            // 2. Eliminar el cliente si no tiene créditos
            $query_eliminar = "DELETE FROM cliente WHERE id = $id_cliente_eliminar";
            $resultado_eliminar = mysqli_query($db, $query_eliminar);

            if ($resultado_eliminar) {
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Cliente eliminado correctamente.'
                    }).then(() => {
                        window.location.href = 'clientes.php';
                    });
                </script>";
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al eliminar el cliente: " . mysqli_error($db) . "'
                    });
                </script>";
            }
        }
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'ID de cliente inválido.'
            });
        </script>";
    }
}
?>

<main id="main" class="main admin main-admin menu-toggle">
    <h1>Clientes</h1>

    <div class="contenedor">
        <div class="barra-busqueda">
            <input type="text" id="busqueda" placeholder="Buscar cliente...">
            <a id="agregar" href="clientesForm.php">
                <img src="/src/img/icons/agregar.png" width="40" height="45" alt="Agregar cliente">
            </a>
        </div>
        <div class="tabla-container">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cliente['id']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['nombres']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['apellidos']); ?></td>
                            <td>
                                <a href="#" class="accion-btn editar-cliente" data-id="<?php echo urlencode($cliente['id']); ?>" data-nombres="<?php echo htmlspecialchars($cliente['nombres']); ?>" data-apellidos="<?php echo htmlspecialchars($cliente['apellidos']); ?>">✏️ Editar</a>
                                <a href="creditos.php?id=<?php echo urlencode($cliente['id']); ?>" class="accion-btn">Créditos</a>
                                <a href="#" class="accion-btn eliminar-cliente" data-id="<?php echo htmlspecialchars($cliente['id']); ?>">❌ Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const botonesEliminar = document.querySelectorAll('.eliminar-cliente');
        const botonesEditar = document.querySelectorAll('.editar-cliente');

        botonesEliminar.forEach(boton => {
            boton.addEventListener('click', function (event) {
                event.preventDefault();

                const idCliente = this.dataset.id;
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: '¿Deseas eliminar este cliente?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    width: '600px'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Verifica si ya existe un formulario de eliminación y lo elimina
                        const formExistente = document.getElementById('form-eliminar-cliente');
                        if (formExistente) {
                            formExistente.remove();
                        }

                        // Crea un nuevo formulario para enviar la petición POST
                        const form = document.createElement('form');
                        form.id = 'form-eliminar-cliente';
                        form.method = 'POST';
                        form.style.display = 'none';

                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'id_cliente_eliminar';
                        input.value = idCliente;

                        form.appendChild(input);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });

        botonesEditar.forEach(boton => {
    boton.addEventListener('click', function (event) {
        event.preventDefault();

        const idCliente = this.dataset.id;
        const nombresCliente = this.dataset.nombres;
        const apellidosCliente = this.dataset.apellidos;

        Swal.fire({
            title: 'Editar Cliente',
            html: `
                <input type="text" id="nombres" class="swal2-input" placeholder="Nombres" value="${nombresCliente}">
                <input type="text" id="apellidos" class="swal2-input" placeholder="Apellidos" value="${apellidosCliente}">
            `,
            showCancelButton: true,
            confirmButtonText: 'Guardar',
            cancelButtonText: 'Cancelar',
            focusConfirm: false,
            preConfirm: () => {
                const nombres = Swal.getPopup().querySelector('#nombres').value;
                const apellidos = Swal.getPopup().querySelector('#apellidos').value;
                if (!nombres || !apellidos) {
                    Swal.showValidationMessage('Por favor, ingresa nombres y apellidos');
                    return false;
                }
                return { nombres: nombres, apellidos: apellidos };
            },
            width: '600px'
        }).then((result) => {
            if (result.isConfirmed) {
                const { nombres, apellidos } = result.value;
                // Envía los datos a clientes_editar.php
                fetch('clientes_editar.php?id=' + idCliente, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `primer_nombre=${encodeURIComponent(nombres.split(' ')[0])}&segundo_nombre=${encodeURIComponent(nombres.split(' ')[1] || '')}&primer_apellido=${encodeURIComponent(apellidos.split(' ')[0])}&segundo_apellido=${encodeURIComponent(apellidos.split(' ')[1] || '')}`,
                })
                .then(response => {
                    if (response.ok) {
                        Swal.fire('Actualizado', 'Cliente actualizado correctamente', 'success').then(() => {
                            location.reload(); // Recarga la página para mostrar los cambios
                        });
                    } else {
                        Swal.fire('Error', 'Error al actualizar el cliente', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Error al actualizar el cliente', 'error');
                });
            }
        });
    });
});
       
    });
</script>

<?php incluirTemplate('footer'); ?>