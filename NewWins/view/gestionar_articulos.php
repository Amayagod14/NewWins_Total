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
    <title>Gestion de articulos</title>
</head>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div id="noticias" class="mt-4">
                <h4>Noticias</h4>
                <div class="mt-4">
                    <?php
                    include '../model/conexion.php';
                    include '../model/gestor_noticias.php';

                    $conexion = ConexionBD::obtenerConexion();
                    $gestor = new GestorContenido($conexion);
                    $result = $gestor->listarNoticias();

                    if ($result->num_rows > 0) {
                        echo '<div class="table-responsive">';
                        echo '<table class="table table-bordered table-striped">';
                        echo '<thead class="table-dark">';
                        echo '<tr><th>ID<br> <i class="bx bx-hash"></i></th><th>Categoría<br> <i class="bx bxs-category-alt"></i></th><th>Título<br> <i class="bx bx-list-ul"></i></th><th>Contenido<br> <i class="bx bxs-book-content"></i></th><th>Imagen<br><i class="bx bx-images"></i></th><th>Acciones<br><i class="bx bx-slider"></i></th></tr>';
                        echo '</thead>';
                        echo '<tbody>';

                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row["id"]) . '</td>';
                            echo '<td>' . htmlspecialchars($row["categoria"]) . '</td>';
                            echo '<td>' . htmlspecialchars($row["titulo"]) . '</td>';
                            echo '<td>' . htmlspecialchars($row["contenido"]) . '</td>';

                            // Mostrar la imagen si la URL no está vacía
                            if (!empty($row["url"])) {
                                echo '<td><img src="' . htmlspecialchars($row["url"]) . '" class="img-thumbnail" style="max-width: 150px; max-height: 150px;"></td>';
                            } else {
                                echo '<td>No hay imagen disponible</td>';
                            }

                            echo '<td>';
                            echo '<a href="../controller/eliminar_noticia.php?id=' . htmlspecialchars($row["id"]) . '" class="btn btn-danger btn-sm">Eliminar <i class="bx bxs-trash"></i></a><br><br>';
                            echo ' <a href="edit_news.php?id=' . htmlspecialchars($row["id"]) . '" class="btn btn-danger btn-sm">Editar <i class="bx bx-edit"></i></a>';
                            echo '</td>';
                            echo '</tr>';
                        }

                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>'; // Cierra table-responsive
                    } else {
                        echo '<p>No hay noticias disponibles.</p>';
                    }

                    $conexion->close();
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <?php
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $conexion = ConexionBD::obtenerConexion();
                $stmt = $conexion->prepare("SELECT * FROM articulos WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $articulo = $result->fetch_assoc();
            ?>
                <div class="card mt-4">
                    <div class="card-header">Editar Noticia</div>
                    <div class="card-body">
                        <form action="../controller/editar_noticia.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($articulo['id']); ?>">
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título</label>
                                <input type="text" id="titulo" name="titulo" class="form-control" value="<?php echo htmlspecialchars($articulo['titulo']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="contenido" class="form-label">Contenido</label>
                                <textarea id="contenido" name="contenido" class="form-control" rows="5" required><?php echo htmlspecialchars($articulo['contenido']); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="url" class="form-label">URL de la Imagen</label>
                                <input type="text" id="url" name="url" class="form-control" value="<?php echo htmlspecialchars($articulo['url']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="categoria_id" class="form-label">Categoría</label>
                                <select id="categoria_id" name="categoria_id" class="form-control" required>
                                    <?php
                                    $categorias = $gestor->listarCategorias();
                                    while ($categoria = $categorias->fetch_assoc()) {
                                        $selected = ($categoria['id'] == $articulo['categoria_id']) ? 'selected' : '';
                                        echo "<option value='" . htmlspecialchars($categoria['id']) . "' $selected>" . htmlspecialchars($categoria['nombre']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </form>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>