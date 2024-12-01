<?php
session_start();

require '../conectarbd/conectar.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: iniciar-sesion.php"); // Redirige al formulario de inicio de sesión
    exit;
}

$usuario = $_SESSION['usuario'];

$sql = "SELECT nombre, apellido, correo, usuario, clave FROM usuarios WHERE usuario=:usuario";
$stms = $conexion->prepare($sql);
$stms->bindParam(':usuario', $usuario);
$stms->execute();
$resultado = $stms->fetch(PDO::FETCH_ASSOC);

// Asigna los valores a variables para usarlas en HTML
$nombre = $resultado['nombre'];
$apellido = $resultado['apellido'];
$correo = $resultado['correo'];
$usuario = $resultado['usuario'];
$clave = $resultado['clave'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="perfil">

<header class="header">
    <h1>Inicio</h1>
</header>

<div class="nav">
    
<nav class = "navtop">
<ul class="nav-list">
        <li><a href="../inicio.php">Inicio</a></li>
        <li><a href="inscribirse.php">Inscribirse a un curso</a></li>
        <li><a href="inscrito.php">Cursos inscritos</a></li>
        <li><a href="../cerrar-sesion.php">Cerrar Sesión</a></li>
    </nav>
    </ul>
    </div>

    <div class = "content-perfil">
        <h2>Información del Usuario</h2>

        <div>
            <p>La siguiente información esta registrada en tu cuenta: </p>
            <table>
            <tr>
                <td class="left">Nombres:</td>
                <td class="right"><?= isset($nombre) ? htmlspecialchars($nombre. " ".$apellido) : 'no' ?></td>
            </tr>
            <tr>
                <td class="left">Correo electronico:</td>
                <td class="right"><?php echo htmlspecialchars($correo); ?></td>
            </tr>
            <tr>
                <td class="left">Usuario:</td>
                <td class="right"><?php echo htmlspecialchars($usuario); ?></td>
            </tr>
            </table>
        </div>
    </div>

    
</body>
</html>