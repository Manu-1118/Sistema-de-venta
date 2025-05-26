<?php

require 'includes/app.php'; //importar la conexion

$db = conectarDB(); // asignar la conexion de la bd a la variable

//crear un usuario
$nombre = "Brandon";
$apellido = "Mayorga";
$email = "brandon23@gmail.com";
$password = "brandon123";
$passwordHash = password_hash($password, PASSWORD_DEFAULT); //hashear la contraseña
$imagen = "foto1.png";

//query para crear el usuario
$query = "INSERT INTO Administrador(nombre, apellido, correo, clave, imagen) VALUES ('$nombre', '$apellido', '$email', '$passwordHash', '$imagen');";
//Agregarlo a la base
mysqli_query($db, $query);


$mensaje = "Usuario registrado correctamente. REDIRECCIONANDO ...";
echo $mensaje;
sleep(3);
header('Location: /');

# contraseña de aplicacion(zetassj78): kssm brcl peyt ftwe 