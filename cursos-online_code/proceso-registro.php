<?php

session_start();

require 'conectarbd/conectar.php';

$msg = '';

//Verificar datos
if (!empty($_POST["nombre"]) && !empty($_POST["apellido"]) && !empty($_POST["correo"]) && !empty($_POST["usuario"]) && !empty($_POST["clave"]) && !empty($_POST["confirmar_clave"])) {

    //Verificar claves
    if ($_POST["clave"] !== $_POST["confirmar_clave"]) {
        $_SESSION['mensaje_error'] = "Las contraseñas no coinciden.";
        header("Location: registro.php");
        exit;
    }

    //Registrar datos en la base de datos
    $sql = "INSERT INTO usuarios (nombre, apellido, correo, usuario, clave) VALUES (:nombre, :apellido, :correo, :usuario, :clave)";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(":nombre", $_POST["nombre"]);
    $stmt->bindParam(":apellido", $_POST["apellido"]);
    $stmt->bindParam(":correo", $_POST["correo"]);
    $stmt->bindParam(":usuario", $_POST["usuario"]);
    $pass = password_hash($_POST["clave"], PASSWORD_BCRYPT);
    $stmt->bindParam(":clave", $pass);

    if ($stmt->execute()) {
        $_SESSION['mensaje_exito'] = "Usuario creado con éxito.";
        header("Location: registro.php");
        exit;
    } else {
        $_SESSION['mensaje_error'] = "Error al crear usuario.";
        header("Location: registro.php");
        exit;
    }
} else { 
$_SESSION['mensaje_error'] = "Por favor completa todos los campos.";
header("Location: registro.php");
exit;
}
