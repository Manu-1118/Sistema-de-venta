<?php
require '../../../includes/app.php';
$db = conectarDB();
estaAutenticado(); 

require '../../../data/devueltos/detalles.php';

$total = 0; 

function traducirEstadoDevolucion($estado_numero) {
    switch ($estado_numero) {
        case 0:
            return "Devuelto";
        case 1:
            return "Cambiado";
        default:
            return "Desconocido"; 
    }
}

incluirTemplate('header');
incluirTemplate('slidebar');
?>

<main id="main" class="main admin main-admin menu-toggle">

    <div id="messages" class="success-message" style="display:none; padding: 10px; border-radius: 5px; margin-bottom: 15px;"></div>
    <div class="contenedor-productos">
        <div class="contenedor-tabla-datos">
            <table class="tabla-plantilla">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Precio unitario</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1; 

                    if (!empty($resultado_mostrar_detalle_array)) {
                        foreach ($resultado_mostrar_detalle_array as $detalles) {
                            $estado_actual_numero = (int)$detalles['estado_devolucion'];
                    ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo htmlspecialchars($detalles['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($detalles['precio_unitario']); ?></td>
                            <td><?php echo htmlspecialchars($detalles['cantidad']); ?></td>
                            <td><?php echo htmlspecialchars($detalles['subtotal']); ?></td>
                            <td>
                                <span id="estado-display-<?php echo htmlspecialchars($detalles['codigo_detalle_devolucion']); ?>">
                                    <?php echo htmlspecialchars(traducirEstadoDevolucion($estado_actual_numero)); ?>
                                </span>
                            </td>
                            <td>
                                <form class="form-actualizar-estado" data-id-detalle="<?php echo htmlspecialchars($detalles['codigo_detalle_devolucion']); ?>">
                                    <input type="hidden" name="codigo_detalle_devolucion" value="<?php echo htmlspecialchars($detalles['codigo_detalle_devolucion']); ?>">
                                    <select name="estado_devolucion">
                                        <option value="0" class="boton-azul" <?php echo ($estado_actual_numero === 0) ? 'selected' : ''; ?>>Devuelto</option>
                                        <option value="1" <?php echo ($estado_actual_numero === 1) ? 'selected' : ''; ?>>Cambiado</option>
                                        </select>
                                    <button type="submit">Guardar</button>
                                </form>
                            </td>
                        </tr>
                    <?php
                        $i++;
                        $total += $detalles['subtotal']; 
                        } 
                    } else {
                        echo "<tr><td colspan='7'>No hay datos de detalles de devolución disponibles.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <div class="alinear-derecha separar-margin">
                <div>
                    <label>Total del registro</label>
                    <input disabled type="text" value="<?php echo htmlspecialchars(number_format($total_contado, 2)); ?>">
                </div>

                <a class="boton-rojo" href="devueltos.php">
                    <span>Retroceder</span>
                </a>
            </div>
        </div>
    </div>
</main>

<?php
?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const estadoTraduccion = {
            "0": "Devuelto",
            "1": "Cambiado"
        };

        document.querySelectorAll('.form-actualizar-estado').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); 

                const codigoDetalle = this.dataset.idDetalle; 
                const nuevoEstadoNumerico = this.querySelector('select[name="estado_devolucion"]').value; 

                const formData = new FormData();
                formData.append('codigo_detalle_devolucion', codigoDetalle);
                formData.append('estado_devolucion', nuevoEstadoNumerico); 

                fetch('../../../data/devueltos/actualizar_estado_devolucion.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json(); 
                })
                .then(data => {
                    const messagesDiv = document.getElementById('messages');
                    messagesDiv.style.display = 'block';

                    if (data.success) {
                        messagesDiv.className = 'success-message';
                        messagesDiv.textContent = data.message;
                        const nuevoEstadoTexto = estadoTraduccion[nuevoEstadoNumerico];
                        document.getElementById(`estado-display-${codigoDetalle}`).textContent = nuevoEstadoTexto;
                    } else {
                        messagesDiv.className = 'error-message';
                        messagesDiv.textContent = 'Error: ' + data.message;
                    }
                    setTimeout(() => {
                        messagesDiv.style.display = 'none';
                    }, 5000);
                })
                .catch(error => {
                    console.error('Error en la solicitud Fetch:', error);
                    const messagesDiv = document.getElementById('messages');
                    messagesDiv.style.display = 'block';
                    messagesDiv.className = 'error-message';
                    messagesDiv.textContent = 'Ocurrió un error al intentar actualizar el estado.';
                    setTimeout(() => {
                        messagesDiv.style.display = 'none';
                    }, 5000);
                });
            });
        });
    });
</script>

<?php incluirTemplate('footer', true); ?>