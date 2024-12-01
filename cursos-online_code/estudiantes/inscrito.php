<?php
session_start();

require '../conectarbd/conectar.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: iniciar-sesion.php"); // Redirige al formulario de inicio de sesión
    exit;
}

$usuario = $_SESSION['usuario'];

$cursos_inscritos =[];

//OBTENER ID DE USUARIO
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

//CONSULTA DE CURSOS EN LOS QUE ESTA EL USUARIO
$inscritoQuery = $conexion->prepare("
SELECT i.id AS inscripcion_id, i.nivel_experiencia, i.fecha_inicio, i.modalidad, i.comentarios, i.reg_date,
c.titulo AS curso_id
FROM inscripciones i
JOIN cursos c ON i.curso_id = c.id
WHERE i.usuario_id = :usuario_id");

$inscritoQuery->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
$inscritoQuery->execute();

$cursos_inscritos = $inscritoQuery->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
echo "Error al obtener los cursos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos inscritos</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="inscrito">

<header class="header">
    <h1>Inicio</h1>
</header>


<div class="nav">
<nav class = "navtop">
    <ul class="nav-list">
      <li><a href="../inicio.php">Inicio</a></li>
      <li><a href="perfil.php">Perfil</a></li>  
      <li><a href="inscribirse.php">Inscribirse a un curso</a></li>  
      <li><a href="../cerrar-sesion.php">Cerrar Sesión</a></li>  
    </nav>
    </ul>
    </div>

    <div class="content-inscrito">
    <h1>Mis cursos inscritos</h1>

    <?php if (isset($_SESSION['mensaje_error'])): ?>
        <p class="mensaje-error"><?php echo $_SESSION['mensaje_error']; unset($_SESSION['mensaje_error']); ?></p>
    <?php endif; ?>

    <?php if (isset($_SESSION['mensaje_exito'])): ?>
        <p class="mensaje-exito"><?php echo $_SESSION['mensaje_exito']; unset($_SESSION['mensaje_exito']); ?></p>
    <?php endif; ?>


<?php if (!empty($cursos_inscritos)) : ?>
    <table>
        <thead>
            <tr>
                <th>Curso</th>
                <th>Nivel de experiencia</th>
                <th>Fecha de Inicio</th>
                <th>Modalidad</th>
                <th>Comentarios</th>
                <th>Fecha de inscripcion</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($cursos_inscritos as $curso) : ?>
                <tr>
                    <td><?= htmlspecialchars($curso['curso_id']); ?></td>
                    <td><?= htmlspecialchars($curso['nivel_experiencia']); ?></td>
                    <td><?= htmlspecialchars($curso['fecha_inicio']); ?></td>
                    <td><?= htmlspecialchars($curso['modalidad']); ?></td>
                    <td><?= htmlspecialchars($curso['comentarios']); ?></td>
                    <td><?= htmlspecialchars($curso['reg_date']); ?></td>
                    <td>
                    <a href="../eliminar-inscripcion.php?inscripcion_id=<?= htmlspecialchars($curso['inscripcion_id']); ?>" 
                       onclick="return confirm('¿Estás seguro de eliminar esta inscripción?')">Eliminar</a>
                    </td>
                    <td>
                    <a href="actualizar.php?curso_id=<?= htmlspecialchars($curso['curso_id']); ?>">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>No estás inscrito en ningún curso.</p>
<?php endif; ?>
</div>
</body>
</html>