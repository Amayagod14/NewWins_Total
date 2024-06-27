<?php
include('../model/gestor_usuarios.php'); // Incluir la clase GestorUsuarios

// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $nombreUsuario = $_POST["nombre_user"];
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];
    $pais = $_POST["pais"];

    // Instanciar la clase GestorUsuarios
    $gestorUsuarios = new GestorUsuarios();

    // Intentar registrar al usuario
    $registroExitoso = $gestorUsuarios->registrarUsuario($nombre, $apellido, $nombreUsuario, $correo, $contrasena, $pais);

    if ($registroExitoso) {
        // Registro exitoso
        $response = [
            'status' => 'success',
            'message' => 'Se ha registrado correctamente.'
        ];
    } else {
        // Error en el registro
        $response = [
            'status' => 'error',
            'message' => 'Hubo un error en el registro. Por favor, inténtalo de nuevo.'
        ];
    }

    // Devolver respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
