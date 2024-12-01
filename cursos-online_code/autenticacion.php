<?php
session_start();

require 'conectarbd/conectar.php';

if (!empty($_POST['usuario']) && !empty($_POST['clave'])) {

$userdata = $conexion->prepare('SELECT id, usuario, clave FROM usuarios WHERE usuario=:usuario');
$userdata->bindParam(':usuario', $_POST['usuario']);
$userdata->execute();
$resultados = $userdata->fetch(PDO::FETCH_ASSOC);

$msg = '';

if (count($resultados) > 0 && password_verify($_POST['clave'], $resultados['clave'])) {
    $_SESSION['usuario'] = $resultados['usuario'];
    header('Location: inicio.php');
} else {
    header('Location: iniciar-sesion.html?$error=datos incorrectos');
}
}