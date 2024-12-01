<?php
session_start();
require '../conectarbd/conectar.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: iniciar-sesion.php");
    exit;
}

$usuario = $_SESSION['usuario'];

// Obtener el ID del usuario
try {
    $usuarioQuery = $conexion->prepare("SELECT id FROM usuarios WHERE usuario = :usuario LIMIT 1");
    $usuarioQuery->bindParam(':usuario', $usuario, PDO::PARAM_STR);
    $usuarioQuery->execute();

if ($usuarioQuery->rowCount() > 0) {
    $userdata = $usuarioQuery->fetch(PDO::FETCH_ASSOC);
    $usuario_id = $userdata['id']; // ID del usuario
} else {
    echo "Usuario no encontrado.";
    exit;
}


// Obtener los datos de la inscripción del usuario
$queryData = $conexion->prepare("SELECT * FROM inscripciones WHERE usuario_id = :usuario_id LIMIT 1");
$queryData->bindParam(':usuario_id', $usuario_id);
$queryData->execute();

$inscripcion = $queryData->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error al obtener los cursos: " . $e->getMessage();
    }
?>

<!-- Formulario HTML para editar los datos -->
 <!DOCTYPE html>
 <html lang="es">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar inscripcion</title>
    <link rel="stylesheet" href="../css/style.css">
 </head>
 <body class="actualizar">

    <div class="content-actualizar">
        <h1>Modificar datos de inscripción</h1>

        <?php if (isset($_SESSION['mensaje_error'])): ?>
        <p class="mensaje-error"><?php echo $_SESSION['mensaje_error']; unset($_SESSION['mensaje_error']); ?></p>
    <?php endif; ?>

    <?php if (isset($_SESSION['mensaje_exito'])): ?>
        <p class="mensaje-exito"><?php echo $_SESSION['mensaje_exito']; unset($_SESSION['mensaje_exito']); ?></p>
    <?php endif; ?>

    
<form method="POST" action="../actualizar-inscripcion.php">
    
<input type="hidden" name="inscripcion_id" value="<?php echo $inscripcion['id']; ?>">

    <label for="nivel_experiencia">Nivel de Experiencia:</label>
    <select name="nivel_experiencia" id="nivel_experiencia">
        <option value="" disabled selected>-- Experiencia --</option>
        <option value="principiante" <?php echo ($inscripcion['nivel_experiencia'] == 'principiante') ? 'selected' : ''; ?>>Principiante</option>
        <option value="intermedio" <?php echo ($inscripcion['nivel_experiencia'] == 'intermedio') ? 'selected' : ''; ?>>Intermedio</option>
        <option value="avanzado" <?php echo ($inscripcion['nivel_experiencia'] == 'avanzado') ? 'selected' : ''; ?>>Avanzado</option>
    </select><br>

    <label for="fecha_inicio">Fecha de Inicio:</label>
    <input type="date" name="fecha_inicio" id="fecha_inicio" value="<?php echo htmlspecialchars($inscripcion['fecha_inicio']); ?>"><br>

    <label for="modalidad">Modalidad:</label>
    <select name="modalidad" id="modalidad">
        <option value="" disabled selected>-- Modalidad --</option>
        <option value="online" <?php echo ($inscripcion['modalidad'] == 'online') ? 'selected' : ''; ?>>Online</option>
        <option value="presencial" <?php echo ($inscripcion['modalidad'] == 'presencial') ? 'selected' : ''; ?>>Presencial</option>
    </select><br>

    <label for="comentarios">Comentarios:</label>
    <textarea name="comentarios" id="comentarios" placeholder="Opcional"><?php echo htmlspecialchars($inscripcion['comentarios']); ?></textarea><br>

    <div>
    <input type="submit" value="Actualizar">
    <a href="inscrito.php"><input type="button" value="Cancelar"></input></a>
    </div>
</form>
</div>
</body>
</html>