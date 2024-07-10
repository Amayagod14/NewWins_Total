<?php
session_start();
include '../model/conexion.php';
include '../model/gestor_noticias.php';

$conexion = ConexionBD::obtenerConexion();
$gestorNoticias = new GestorContenido($conexion);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['titulo']) && isset($_POST['contenido']) && isset($_POST['url']) && isset($_POST['categoria_id'])) {
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $url = $_POST['url'];
    $categoria_id = $_POST['categoria_id'];

    // Llamar al método para subir noticia
    $noticia_subida = $gestorNoticias->subirNoticia($titulo, $contenido, $url, $categoria_id);

    if ($noticia_subida) {
        $_SESSION['mensaje_exito'] = "Noticia subida con éxito";
        header("Location: ../view/admin_dashboard.php?noticia=exito");
        exit();
    } else {
        $_SESSION['mensaje_error'] = "Error al subir la noticia";
        header("Location: ../view/admin_dashboard.php?noticia=error");
        exit();
    }
}
