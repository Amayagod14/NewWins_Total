<?php

class GestorContenido
{
    private $conn;

    public function __construct($conexion)
    {
        $this->conn = $conexion;
    }

    public function subirNoticia($titulo, $contenido, $url, $categoria_id)
    {
        $fecha_publicacion = date("Y-m-d");

        if (!empty($titulo) && !empty($contenido) && !empty($url) && !empty($categoria_id)) {
            $sql = "INSERT INTO articulos (titulo, fecha_publicacion, contenido, url, categoria_id) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssssi", $titulo, $fecha_publicacion, $contenido, $url, $categoria_id);

            if ($stmt->execute()) {
                return true; // Devolver true si la inserción fue exitosa
            } else {
                return false; // Devolver false si hubo un error en la inserción
            }
        } else {
            return false; // Devolver false si faltan datos
        }
    }

    public function listarCategorias()
    {
        $sql = "SELECT * FROM categorias";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function listarNoticias()
    {
        $sql = "SELECT a.id, c.nombre AS categoria, a.titulo, a.contenido, a.url 
                FROM articulos a
                JOIN categorias c ON a.categoria_id = c.id";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function eliminarNoticia($id)
    {
        $sql = "DELETE FROM articulos WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

public function eliminarCategoria($id)
{
    // Iniciar una transacción
    $this->conn->begin_transaction();

    try {
        // Primero, eliminar todos los artículos relacionados con la categoría
        $sql_articulos = "DELETE FROM articulos WHERE categoria_id = ?";
        $stmt_articulos = $this->conn->prepare($sql_articulos);
        $stmt_articulos->bind_param("i", $id);
        $stmt_articulos->execute();

        // Luego, eliminar la categoría
        $sql_categoria = "DELETE FROM categorias WHERE id = ?";
        $stmt_categoria = $this->conn->prepare($sql_categoria);
        $stmt_categoria->bind_param("i", $id);
        $stmt_categoria->execute();

        // Si ambas operaciones fueron exitosas, confirmar la transacción
        $this->conn->commit();
        return true;
    } catch (Exception $e) {
        // Si hubo un error, revertir la transacción
        $this->conn->rollback();
        return false;
    }
}


    public function crearCategoria($nombre, $descripcion, $imagen)
    {
        if (!empty($nombre) && !empty($descripcion)) {
            $stmt = $this->conn->prepare("INSERT INTO categorias (nombre, descripcion, imagen) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombre, $descripcion, $imagen);

            if ($stmt->execute()) {
                return true; // Devolver true si la inserción fue exitosa
            } else {
                return false; // Devolver false si hubo un error en la inserción
            }
        } else {
            return false; // Devolver false si faltan datos
        }
    }

    public function editarNoticia($id, $titulo, $contenido, $url, $categoria_id)
    {
        $sql = "UPDATE articulos SET titulo = ?, contenido = ?, url = ?, categoria_id = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssii", $titulo, $contenido, $url, $categoria_id, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
