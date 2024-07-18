<?php
session_start();
if (!isset($_SESSION['correo']) || empty($_SESSION['correo'])) {
    header("Location: index.php");
    exit();
}

require_once '../model/conexion.php';
require_once '../model/gestor_noticias.php';
require_once '../model/vistanoticias.php';

// Obtener la categoría seleccionada
$categoria_id = isset($_GET['categoria_id']) ? intval($_GET['categoria_id']) : 0;

// Configuración de la base de datos
$conexion = ConexionBD::obtenerConexion();
$gestorContenido = new GestorContenido($conexion);
$vistaNoticias = new VistaNoticias($gestorContenido);

// Obtener la fecha actual
$fechaActual = date("d/m/Y"); // Formato de fecha: día/mes/año
//obtener nombre de categoria para el titulo//
if ($categoria_id>0){
$categoria_name = $gestorContenido->obtenerCategoriaPorId($categoria_id);
}
// Obtener artículos relacionados con la categoría seleccionada
$articulos = [];
if ($categoria_id > 0) {
    $articulos = $gestorContenido->listarArticulosPorCategoria($categoria_id);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NEWWINS</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/style.css"> <!-- Agrega tu archivo CSS personalizado aquí -->
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid bg-light px-lg-5">
        <div class="row align-items-center">
            <div class="col-lg-4">
                <a href="" class="navbar-brand d-none d-lg-block">
                    <h1 class="m-0 display-5 text-uppercase"><span class="text-danger">New</span>Wins</h1>
                </a>
            </div>

            <div class="col-lg-8 text-center text-lg-end">
                <img class="img-fluid" src="img/ads-700x70.jpg" alt="">
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-light navbar-light py-2 px-lg-5">
        <div class="container-fluid">
            <a class="navbar-brand d-block d-lg-none" href="#">
                <h1 class="m-0 display-5 text-uppercase"><span class="text-primary">New</span>Wins</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="articulos.php">Inicio</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categorías
                    </a>
                    <?php
                    // Incluir el archivo de conexión y creación de instancia de GestorContenido si no está incluido
                    require_once('../model/conexion.php');
                    require_once('../model/gestor_noticias.php');

                    // Crear instancia del gestor de contenido
                    $conexion = ConexionBD::obtenerConexion();
                    $gestorContenido = new GestorContenido($conexion);

                    // Obtener las categorías
                    $categorias = $gestorContenido->listarCategorias();

                    // Verificar si hay categorías disponibles
                    if ($categorias->num_rows > 0) {
                        echo '<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
                        while ($categoria = $categorias->fetch_assoc()) {
                            echo '<li><a class="dropdown-item" href="../view/listar_categorias_user.php?categoria_id=' . $categoria['id'] . '">' . $categoria['nombre'] . '</a></li>';
                        }
                        echo '</ul>';
                    } else {
                        echo '<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"><a class="dropdown-item">No hay categorías disponibles</a></div>';
                    }
                    ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Envía tu noticia</a>
                </li>
            </ul>

            <div class="col-md-8 d-flex align-items-center">
                <div class="bg-danger text-white text-center py-2" style="width: 100px;">Tendencia</div>
                <form class="input-group" action="../controller/buscar_noticias.php" method="GET" style="flex: 1; max-width: 500px;">
                    <input type="text" class="form-control" name="q" placeholder="Buscar" required>
                    <button class="input-group-text text-secondary" type="submit"><i class="fa fa-search"></i></button>
                </form>

                <div class="col-md-1 text-md">
                    <?php echo $fechaActual; ?>
                </div>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class='bx bxs-user'></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="perfil_user.php">Ver perfil</a></li>
                        <li><a id="cerrarSesionUser" class="dropdown-item" href="#">Cerrar sesión</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Main Content Start -->
    <div class="container mt-4">
        <?php if ($categoria_id > 0 && !empty($articulos)) : ?>
            <h2 class="mb-4">Artículos en la categoría: <?php echo htmlspecialchars($categoria_name['nombre']); ?></h2>
            <div class="row">
                <?php foreach ($articulos as $articulo) : ?>
                    <?php $vistaNoticias->mostrarArticulo($articulo); ?>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p>No se encontraron artículos para esta categoría.</p>
        <?php endif; ?>
    </div>
    <!-- Main Content End -->

    <?php include('footer_user.php'); ?>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/owlcarousel/owl.carousel.min.js"></script>
    <script src="../js/main.js"></script>
</body>

</html>