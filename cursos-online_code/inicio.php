<?php 
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: iniciar-sesion.php"); // Redirige al formulario de inicio de sesión
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class = "loggedin">
 <div>
    <header class="header">
        <h1>Inicio</h1>
    </header>
    </div>

    <div class="nav">
    <nav class = "navtop">
        <ul class="nav-list">
        <li><a href="estudiantes/perfil.php">Información de Usuario</a></li>
        <li><a href="estudiantes/inscribirse.php">Inscribirse a un curso</a></li>
        <li><a href="estudiantes/inscrito.php">Cursos inscritos</a></li>
        <li><a href="cerrar-sesion.php">Cerrar sesión</a></li>
        </ul>
    </nav>
    </div>

    <div class = "content-inicio">
        <h2>Página de inicio</h2>
        <p>Hola, <?= $_SESSION['usuario']?>!!</p>
    </div>    
</body>
</html>