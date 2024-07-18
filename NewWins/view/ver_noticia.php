<?php

include('header_user.php');

// detalle_noticia.php
require_once '../model/conexion.php';
require_once '../model/gestor_noticias.php';
require_once '../model/gestor_usuarios.php';
if (!isset($_SESSION['correo'])) {
    header("Location: admin.php");
    exit();
}
$articulo_id = $_GET['id'];
$userEmail = $_SESSION['correo'];
$idNoticia = intval($_GET['id']);
$conexion = ConexionBD::obtenerConexion();
$gestorContenido = new GestorContenido($conexion);
$noticia = $gestorContenido->obtenerNoticiaPorId($idNoticia);
$comentarios = $gestorContenido->obtenerComentariosPorArticuloId($articulo_id);

if (!$noticia) {
    echo "Noticia no encontrada.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title><?php echo $noticia['titulo']; ?> - NEWWINS</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css"> <!-- Agrega tu archivo CSS personalizado aquí -->
</head>

<body>

    <div class="container mt-4">
        <h1 class="mb-4"><?php echo $noticia['titulo']; ?></h1>
        <img src="<?php echo $noticia['url']; ?>" class="img-fluid mb-8" alt="<?php echo $noticia['titulo']; ?>">
        <p><?php echo $noticia['contenido']; ?></p> <!-- Ajusta el índice según tu base de datos -->
    </div>
    <div class="container md-2">
        <h3>Comentarios</h3>
        <form action="../controller/enviar_comentario.php" method="POST">
            <div class="mb-3">
                <textarea class="form-control" name="texto" placeholder="Escribe tu comentario aquí..." required></textarea>
            </div>
            <input type="hidden" name="articulo_id" value="<?php echo $articulo_id; ?>">
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>
    <div class="container md-2">
        <!-- Mostrar comentarios -->
        <h2>Comentarios</h2>
        <?php if (!empty($comentarios)) : ?>
            <?php foreach ($comentarios as $comentario) : ?>
                <div>
                    <strong><?php echo htmlspecialchars($comentario['usuario']); ?></strong>
                    <span><?php echo htmlspecialchars($comentario['fecha_hora']); ?></span>
                    <p><?php echo htmlspecialchars($comentario['texto']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No hay comentarios aún. ¡Sé el primero en comentar!</p>
        <?php endif; ?>
    </div>
    <?php
    include('footer_user.php')
    ?>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/main.js"></script>
</body>

</html>