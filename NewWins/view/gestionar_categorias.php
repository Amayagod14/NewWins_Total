<?php
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['correo'])) {
    header("Location: admin.php");
} else if (isset($_SESSION['correo']) == "") {
    header("Location: admin.php");
}

include 'header.php';
?>
<head>
    <title>Gestion de categorias</title>
</head>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="mt-4">
                <?php
                include '../model/conexion.php';
                include '../model/gestor_noticias.php';

                $conexion = ConexionBD::obtenerConexion();
                $gestor = new GestorContenido($conexion);

                // Obtener las categorías
                $categorias = $gestor->listarCategorias();

                // Verificar si hay categorías disponibles
                if ($categorias) {
                    // Verificar si hay al menos una categoría
                    if (!empty($categorias)) {
                         // Contenedor con scroll vertical
                        echo '<div class="table-responsive">';
                        echo '<table class="table table-bordered table-striped">';
                        echo '<thead class="table-dark">';
                        echo '<tr>';
                        echo '<th>ID</th>';
                        echo '<th>Nombre</th>';
                        echo '<th>Descripción</th>';
                        echo '<th>Imagen</th>';
                        echo '<th>Acciones</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        foreach ($categorias as $categoria) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($categoria["id"]) . '</td>';
                            echo '<td>' . htmlspecialchars($categoria["nombre"]) . '</td>';
                            echo '<td>' . htmlspecialchars($categoria["descripcion"]) . '</td>';
                            echo '<td><img src="' . htmlspecialchars($categoria["imagen"]) . '" alt="' . htmlspecialchars($categoria["nombre"]) . '" class="img-thumbnail" style="max-width: 150px; max-height: 150px;"></td>';
                            echo '<td>';
                            echo '<a href="../controller/eliminar_categoria.php?id=' . htmlspecialchars($categoria["id"]) . '" class="btn btn-danger btn-sm">Eliminar <i class="bx bxs-trash"></i></a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                    } else {
                        echo '<p class="text-muted">No hay categorías disponibles.</p>';
                    }
                } else {
                    echo '<p class="text-danger">Ocurrió un error al obtener las categorías.</p>';
                }

                // Cerrar la conexión a la base de datos
                $conexion->close();
                ?>
            </div>
        </div>
    </div>
</div>
</body>

</html>