<?php

require '../includes/app.php';
estaAutenticado();

header('Content-Type: application/json');
echo json_encode($_SESSION, JSON_UNESCAPED_UNICODE);