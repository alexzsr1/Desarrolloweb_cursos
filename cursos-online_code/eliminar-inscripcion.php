<?php
session_start();

require 'conectarbd/conectar.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: iniciar-sesion.php"); // Redirige al formulario de inicio de sesión
    exit;
}


// Obtener el curso_id de la URL
if (isset($_GET['inscripcion_id']) && !empty($_GET['inscripcion_id'])) {
    $inscripcion_id = intval($_GET['inscripcion_id']); // Convertir a entero por seguridad

    try {
        // Obtener el usuario_id basado en la sesión
        $usuario = $_SESSION['usuario'];
        $queryUsuario = $conexion->prepare("SELECT id FROM usuarios WHERE usuario = :usuario");
        $queryUsuario->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $queryUsuario->execute();

        if ($queryUsuario->rowCount() > 0) {
            $userdata = $queryUsuario->fetch(PDO::FETCH_ASSOC);
            $usuario_id = $userdata['id'];
            

            // Eliminar la inscripción

            // Verificación de la inscripción
            $queryVerificar = $conexion->prepare("SELECT * FROM inscripciones WHERE id = :inscripcion_id AND usuario_id = :usuario_id");
            $queryVerificar->bindParam(':inscripcion_id', $inscripcion_id, PDO::PARAM_INT);
            $queryVerificar->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $queryVerificar->execute();

            if ($queryVerificar->rowCount() > 0) {
                // Eliminar la inscripción
                $queryEliminar = $conexion->prepare("DELETE FROM inscripciones 
                WHERE id = :inscripcion_id AND usuario_id = :usuario_id");
                $queryEliminar->bindParam(':inscripcion_id', $inscripcion_id, PDO::PARAM_INT);
                $queryEliminar->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);

                // Ejecutar la consulta de eliminación
                $queryEliminar->execute();

                if ($queryEliminar->rowCount() > 0) {
                    $_SESSION['mensaje_exito'] = "Inscripción eliminada correctamente.";
                    header("Location: estudiantes/inscrito.php");
                    exit;
                } else {
                    $_SESSION['mensaje_error'] = "No se pudo eliminar la inscripción.";
                    header("Location: estudiantes/inscrito.php");
                    exit;
                }
            } else {
                $_SESSION['mensaje_error'] = "No existe una inscripción asociada a este usuario.";
                header("Location: estudiantes/inscrito.php");
                exit;
            }
        } else {
            header("Location: estudiantes/inscrito.php?error=Usuario no encontrado");
            exit;
        }
    } catch (PDOException $e) {
        header("Location: estudiantes/inscrito.php?error=Error al eliminar la inscripción: " . $e->getMessage());
        exit;
    }
} else {
    header("Location: estudiantes/inscrito.php?error=Inscripción no válida");
    exit;
}