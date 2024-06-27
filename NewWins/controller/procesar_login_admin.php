<?php
session_start();

include '../model/gestor_usuarios.php';

// Verificar si la solicitud es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se enviaron los campos requeridos
    if (isset($_POST["emailadmin"]) && isset($_POST["passwordadmin"])) {
        // Obtener los datos del formulario
        $correo = $_POST["emailadmin"];
        $contrasena = $_POST["passwordadmin"];

        // Obtener conexión y crear instancia de GestorUsuarios
        $conexion = ConexionBD::obtenerConexion();
        $gestorUsuarios = new GestorUsuarios($conexion);

        // Intentar iniciar sesión
        $exito = $gestorUsuarios->iniciarSesionAdmin($correo, $contrasena);

        if ($exito) {
            // Inicio de sesión exitoso, guardar el correo en sesión
            $_SESSION['correo'] = $correo;
            // Enviar respuesta JSON de éxito
            echo json_encode(array('success' => true));
            exit();
        } else {
            // Inicio de sesión fallido, enviar respuesta JSON con mensaje de error
            echo json_encode(array('success' => false, 'message' => 'Credenciales incorrectas. Por favor, verifica tu correo y contraseña.'));
            exit();
        }
    } else {
        // No se proporcionaron los campos requeridos, enviar respuesta JSON con mensaje de error
        echo json_encode(array('success' => false, 'message' => 'No se recibieron todos los campos requeridos.'));
        exit();
    }
} else {
    // Si no es una solicitud POST, redirigir a la página de inicio de admin
    header("Location: ../view/admin.php");
    exit();
}
?>
