<?php

require 'includes/app.php'; //importar la conexion

$db = conectarDB(); // asignar la conexion de la bd a la variable

//crear un usuario
$nombre = "Manuel";
$email = "correo@correo.com";
$password = "123456";
$passwordHash = password_hash($password, PASSWORD_DEFAULT); //hashear la contraseña

//query para crear el usuario
$query = "INSERT INTO usuarios(nombre, email, pass) VALUES ('$nombre', '$email', '$passwordHash');";

//debuguear($query);

//Agregarlo a la base
mysqli_query($db, $query);