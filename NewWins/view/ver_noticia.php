<?php
// detalle_noticia.php
require_once '../model/conexion.php';
require_once '../model/gestor_noticias.php';

if (!isset($_GET['id'])) {
    echo "ID de noticia no proporcionado.";
    exit();
}

$idNoticia = intval($_GET['id']);

$conexion = ConexionBD::obtenerConexion();
$gestorContenido = new GestorContenido($conexion);
$noticia = $gestorContenido->obtenerNoticiaPorId($idNoticia);

if (!$noticia) {
    echo "Noticia no encontrada.";
    exit();
}
?>
<?php
include('header_user.php')
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

    <?php
    include('footer_user.php')
    ?>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/main.js"></script>
</body>

</html>