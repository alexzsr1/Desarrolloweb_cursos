<?php
session_start();

require 'conectarbd/conectar.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: iniciar-sesion.php");
    exit;
}

$usuario = $_SESSION['usuario'];

try{
    //OBTENER ID A A PARTIR DEL USUARIO
    $inscribir = $conexion->prepare("SELECT id FROM usuarios WHERE usuario = :usuario LIMIT 1");
    $inscribir->bindParam(':usuario', $usuario, PDO::PARAM_STR);
    $inscribir->execute();

    if ($inscribir->rowCount() > 0) {
        $userdata = $inscribir->fetch(PDO::FETCH_ASSOC);
        $usuario_id = $userdata['id']; // El ID del usuario
    } else {
        echo "Usuario no encontrado.";
        exit;
    }

    $inscripcion_id =$_POST['inscripcion_id'];

    //obtener datos de inscripcion
    $nivel_experiencia = $_POST['nivel_experiencia'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $modalidad = $_POST['modalidad'];
    $comentarios = $_POST['comentarios'];

    if (empty($nivel_experiencia) || empty($fecha_inicio) || empty($modalidad)) {
        $_SESSION['mensaje_error'] = "Todos los campos son obligatorios.";
        header("Location: estudiantes/actualizar.php");
        exit;
    }

    //Actualizar datos ingresados
    $queryActualizar = $conexion->prepare("UPDATE inscripciones SET 
    nivel_experiencia = :nivel_experiencia,
    fecha_inicio = :fecha_inicio,
    modalidad = :modalidad,
    comentarios = :comentarios
    WHERE id = :inscripcion_id AND usuario_id = :usuario_id");

    $queryActualizar->bindParam(':nivel_experiencia', $nivel_experiencia);
    $queryActualizar->bindParam(':fecha_inicio', $fecha_inicio);
    $queryActualizar->bindParam(':modalidad', $modalidad);
    $queryActualizar->bindParam(':comentarios', $comentarios);
    $queryActualizar->bindParam(':inscripcion_id', $inscripcion_id);
    $queryActualizar->bindParam(':usuario_id', $usuario_id);

    
if ($queryActualizar->execute()) {
    $_SESSION['mensaje_exito'] = "Inscripcion actualizada con éxito.";
    header("Location: estudiantes/actualizar.php");
} else {
    $_SESSION['mensaje_error'] = "Error al actualizar la inscripción.";
        header("Location: estudiantes/actualizar.php");
}
} catch (PDOException $e) {
    header("Location: inscrito.php?error=Error al modificar la inscripción: " . $e->getMessage());
    exit;
}