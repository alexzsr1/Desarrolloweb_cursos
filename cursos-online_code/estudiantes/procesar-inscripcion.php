<?php
session_start();
require '../conectarbd/conectar.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: ../iniciar-sesion.php"); // Redirige al formulario de inicio de sesión
    exit;
}

$msg='';
$error= '';

$usuario =$_SESSION['usuario'];
$curso = $_POST['curso'];
$nivel_experiencia = $_POST['nivel_experiencia'];
$fecha_inicio = $_POST['fecha_inicio'];
$modalidad = $_POST['modalidad'];
$comentarios = $_POST['comentarios'];

if (empty($curso)) {
    echo "Por favor selecciona un curso.";
    exit;
}

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

    //VERIFICAR SI ESTA INSCRITO
    $inscribir = $conexion->prepare("SELECT * FROM inscripciones WHERE usuario_id = :usuario_id AND curso_id = :curso_id");
    $inscribir->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $inscribir->bindParam(':curso_id', $curso, PDO::PARAM_INT);
    $inscribir->execute();

    if ($inscribir->rowCount() > 0) {
        $_SESSION['mensaje_error'] = "Ya estas inscrito en este curso.";
        header("Location: inscribirse.php");
        exit;
    }

    //INSERTAR INSCRIPCION
    $inscribir = $conexion->prepare('INSERT INTO inscripciones (usuario_id, curso_id, nivel_experiencia, fecha_inicio, modalidad, comentarios) 
                                            VALUES (:usuario_id, :curso_id, :nivel_experiencia, :fecha_inicio, :modalidad, :comentarios)');
    $inscribir->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $inscribir->bindParam(':curso_id', $curso, PDO::PARAM_INT);
    $inscribir->bindParam(':nivel_experiencia', $nivel_experiencia, PDO::PARAM_INT);
    $inscribir->bindParam(':fecha_inicio', $fecha_inicio, PDO::PARAM_INT);
    $inscribir->bindParam(':modalidad', $modalidad, PDO::PARAM_INT);
    $inscribir->bindParam(':comentarios', $comentarios, PDO::PARAM_INT);

if ($inscribir->execute()){
    $_SESSION['mensaje_exito'] = "Inscripcion exitosa.";
    header('Location: inscribirse.php');
} else{
    $_SESSION['mensaje_error'] = "Error al procesar la inscripción.";
    header('Location: inscribirse.php');
}
} catch(PDOException $e) {
    // Manejar errores de inscripción
    if ($e->getCode() == '23000') {
        // Código de error para entrada duplicada
        $_SESSION['mensaje_error'] = "Ya estas inscrito en este curso.";
        header("Location: inscribirse.php");
    } else {
        // Otro tipo de error
        $_SESSION['mensaje_error'] = "Error al inscribirse.";
        header("Location: inscribirse.php");
    }
}
