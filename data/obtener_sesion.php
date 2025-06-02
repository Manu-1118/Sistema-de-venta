<?php

require '../includes/app.php';
estaAutenticado(true);
// session_start();

header('Content-Type: application/json');
echo json_encode($_SESSION, JSON_UNESCAPED_UNICODE);

// if($_SESSION['direccion'] == "perfil.php") {
//     header('Location: /admin/control/administrador/administradores.php?resultado=2');
// }