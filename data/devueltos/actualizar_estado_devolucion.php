<?php
require '../../includes/app.php';
$db = conectarDB();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigoDetalle = filter_var($_POST['codigo_detalle_devolucion'], FILTER_VALIDATE_INT);
    $estadoNuevo = filter_var($_POST['estado_devolucion'], FILTER_VALIDATE_INT);

    if (!$codigoDetalle || ($estadoNuevo !== 0 && $estadoNuevo !== 1)) {
        echo json_encode([
            'success' => false,
            'message' => 'Datos inválidos.'
        ]);
        exit;
    }

    $query = "UPDATE DetalleDevolucion SET estado_devolucion = ? WHERE codigo_detalle_devolucion = ?";
    $stmt = mysqli_prepare($db, $query);

    if (!$stmt) {
        echo json_encode([
            'success' => false,
            'message' => 'Error al preparar la consulta.'
        ]);
        exit;
    }

    mysqli_stmt_bind_param($stmt, 'ii', $estadoNuevo, $codigoDetalle);
    $resultado = mysqli_stmt_execute($stmt);

    if ($resultado) {
        echo json_encode([
            'success' => true,
            'message' => 'Estado actualizado correctamente.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al actualizar el estado.'
        ]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido.'
    ]);
}
?>
