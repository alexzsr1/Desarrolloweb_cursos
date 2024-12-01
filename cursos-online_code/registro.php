<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="registro-body">

    <header class="header">
        <h1><a href="index.html">Inicio</a></h1>
    </header>

    <div class="login-registro">
    <div class="head">
    <span>Registrarse</span>
    <p class="msg">Registrate para acceder a los cursos</p>
    </div>

        <?php if (isset($_SESSION['mensaje_error'])): ?>
        <p class="mensaje-error"><?php echo $_SESSION['mensaje_error']; unset($_SESSION['mensaje_error']); ?></p>
    <?php endif; ?>

    <?php if (isset($_SESSION['mensaje_exito'])): ?>
        <p class="mensaje-exito"><?php echo $_SESSION['mensaje_exito']; unset($_SESSION['mensaje_exito']); ?></p>
    <?php endif; ?>
    
        <form class="form-registro" action="proceso-registro.php" method="post">

            <label class="label" for="nombre"></label>
            <input class="input" type="text" name="nombre" placeholder="Nombre" id="nombre" required title="Por favor, ingresa tu nombre">

            <label for="apellido"></label>
            <input class="input" type="text" name="apellido" placeholder="Apellido" id="apellido" required title="Por favor, ingresa tu apellido">

            <label for="correo"></label>
            <input class="input" type="email" name="correo" placeholder="Correo Electronico" id="correo" required title="Por favor, ingresa un correo electronico">

            <label for="usuario"></label>
            <input class="input" type="text" name="usuario" placeholder="Usuario" id="usuario" required title="Por favor, ingresa un usuario">
    
            <label for="clave"></label>
            <input class="input" type="password" name="clave" placeholder="Contraseña"
             id="clave" required title="Por favor, ingresa una contraseña">

            <label for="confirmar_clave"></label>
            <input class="input" type="password" name="confirmar_clave" placeholder="Confirmar contraseña"
            id="confirmar_clave">

             <button type="submit">Registrarse</button>

             <span>¿Ya tienes cuenta? <a href="iniciar-sesion.html">Inicia sesión</a></span>
        </form>
    </div>
</body>
</html>
