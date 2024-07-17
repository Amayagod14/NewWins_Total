<?php
// articulos.php
session_start();
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['correo'])) {
    header("Location: articulos.php");
    exit();
} else if (empty($_SESSION['correo'])) {
    header("Location: index.php");
    exit();
}
require_once '../model/conexion.php';
require_once '../model/gestor_noticias.php';
require_once '../model/vistanoticias.php';

// Configuración de la base de datos
$conexion = ConexionBD::obtenerConexion();
$gestorContenido = new GestorContenido($conexion);
$vistaNoticias = new VistaNoticias($gestorContenido);
// Obtener la fecha actual
$fechaActual = date("d/m/Y"); // Formato de fecha: día/mes/año
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <meta charset="utf-8">
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
    <div class="container-fluid">
        <div class="row align-items-center bg-light px-lg-5">
            <div class="col-12 col-md-8">
                <div class="d-flex justify-content-between">
                    <div class="bg-danger text-white text-center py-2" style="width: 100px;">Tendencia</div>
                    <div class="col-8" style="width: calc(100% - 100px); padding-left: 90px;">
                        <div class="text-truncate"><a class="text-secondary" href="">Comienza el día 2 de una Convención Republicana centrada en Trump</a></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-right  d-md-block">
                <?php echo $fechaActual; ?>
            </div>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class='bx bxs-user'></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="perfil.php">Ver perfil</a></li>
                    <li><a id="cerrarSesionUser" class="dropdown-item" href="#">Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
        <div class="row align-items-center py-2 px-lg-5">
            <div class="col-lg-4">
                <a href="" class="navbar-brand d-none d-lg-block">
                    <h1 class="m-0 display-5 text-uppercase"><span class="text-danger">New</span>Wins</h1>
                </a>
            </div>
            <div class="col-lg-8 text-center text-lg-right">
                <img class="img-fluid" src="img/ads-700x70.jpg" alt="">
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid p-0 mb-3">
        <nav class="navbar navbar-expand-lg bg-light navbar-light py-2 py-lg-0 px-lg-5">
            <a href="" class="navbar-brand d-block d-lg-none">
                <h1 class="m-0 display-5 text-uppercase"><span class="text-primary">New</span>Wins</h1>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between px-0 px-lg-3" id="navbarCollapse">
                <div class="navbar-nav mr-auto py-0">
                    <a href="articulos.php" class="nav-item nav-link active">Inicio</a>
                    <a href="#" class="nav-item nav-link">Categorias</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="#" class="dropdown-item">Menu item 1</a>
                            <a href="#" class="dropdown-item">Menu item 2</a>
                            <a href="#" class="dropdown-item">Menu item 3</a>
                        </div>
                    </div>
                    <a href="contact.html" class="nav-item nav-link">Envianos tu notícia</a>
                </div>
                <div class="input-group ml-auto" style="width: 100%; max-width: 300px;">
                    <input type="text" class="form-control" placeholder="Buscar">
                    <div class="input-group-append">
                        <button class="input-group-text text-secondary"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('cerrarSesionUser').addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Cerrando sesión',
                    icon: 'info',
                    showConfirmButton: false,
                    timer: 1500 // Duración en milisegundos
                }).then(function() {
                    window.location.href = '../controller/logout.php';
                });
            });
        });
    </script>