<?php
session_start();
require_once '../model/conexion.php';
require_once '../model/gestor_usuarios.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $correo = $_POST["email"];
        $contra = $_POST["password"];

        $conexion = ConexionBD::obtenerConexion();
        $gestorUsuarios = new GestorUsuarios($conexion);
        $errorMensaje = $gestorUsuarios->iniciarSesion($correo, $contra);

        if ($errorMensaje) {
            // Redirigir con el mensaje de error
            header("Location: ../view/index.php?error=" . urlencode($errorMensaje));
            exit;
        }
    } else {
        // Redirigir con el mensaje de error de campos obligatorios
        header("Location: index.php?error=" . urlencode("Todos los campos son obligatorios."));
        exit;
    }
} else {
    // Redirigir si no es una solicitud POST
    header("Location: index.php");
    exit;
}
