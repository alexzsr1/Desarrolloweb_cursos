<?php
    session_start();
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscribirse</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="inscribirse">

<header class="header">
    <h1>Inicio</h1>
</header>

    <div class="nav">
    <nav class = "navtop">
        <ul class="nav-list">
        <li><a href="../inicio.php">Inicio</a></li>
        <li><a href="perfil.php">Perfil</a></li>
        <li><a href="inscrito.php">Cursos inscritos</a></li>
        <li><a href="../cerrar-sesion.php">Cerrar Sesión</a></li>
    </nav>
    </ul>
    </div>

    <div class="content-inscribirse">
        <h1>Inscribete a un curso</h1>

        <?php if (isset($_SESSION['mensaje_error'])): ?>
        <p class="mensaje-error"><?php echo $_SESSION['mensaje_error']; unset($_SESSION['mensaje_error']); ?></p>
    <?php endif; ?>

    <?php if (isset($_SESSION['mensaje_exito'])): ?>
        <p class="mensaje-exito"><?php echo $_SESSION['mensaje_exito']; unset($_SESSION['mensaje_exito']); ?></p>
    <?php endif; ?>
    

    <form action="procesar-inscripcion.php" method="post">
        <label for="curso">Selecciona un curso:</label>
        <select name="curso" id="curso" required>
        <option value="" disabled selected>-- Selecciona un curso --</option>
            <?php
            require '../conectarbd/conectar.php';

            $consulta="SELECT id, titulo FROM cursos";
            $resultado=$conexion->query($consulta);

            if(count($resultado) > 0) {
            while ($curso = $resultado->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . htmlspecialchars($curso['id']) . "'>" . htmlspecialchars($curso['titulo']) . "</option>";
            } 
            }else {
                echo "<option value=''>No hay cursos disponibles</option>";
            }
            ?>
        </select>

        <label for="nivel_experiencia">Nivel de experiencia:</label>
            <select id="nivel_experiencia" name="nivel_experiencia" required>
            <option value="" disabled selected>-- Experiencia --</option>
            <option value="principiante">Principiante</option>
            <option value="intermedio">Intermedio</option>
            <option value="avanzado">Avanzado</option>
        </select>

        <label for="fecha_inicio" required>Fecha de inicio preferida:</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio">

        <label for="modalidad">Modalidad del curso:</label>
        <select id="modalidad" name="modalidad" required>
        <option value="" disabled selected>-- Modalidad preferida --</option>
        <option value="online">Online</option>
        <option value="presencial">Presencial</option>
        </select>

        <label for="comentarios">Comentarios/Observaciones:</label>
        <textarea id="comentarios" name="comentarios" placeholder="Opcional" rows="4" cols="50"></textarea>


        
        <input type="hidden" name="usuario" value="<?php echo htmlspecialchars($_SESSION['usuario']); ?>">
        <button type="submit">Inscribirse</button>

    </form>
    </div>
</body>
</html>