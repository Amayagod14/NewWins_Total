<?php
require_once('conexion.php');
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
        $sql = "SELECT a.id, c.nombre AS categoria, a.titulo, a.contenido, a.url, a.fecha_publicacion
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
        $sql = "DELETE FROM categorias WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
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
    public function obtenerCategoriaPorId($id)
    {
        $sql = "SELECT * FROM categorias WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new RuntimeException("Error preparando la consulta: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            throw new RuntimeException("No se encontró la categoría con ID $id.");
        }
        return $result->fetch_assoc();
    }
    public function obtenerNoticiaPorId($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM articulos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }
    public function listarNoticiasConPaginacion($limite, $offset)
    {
        $sql = "SELECT a.id, c.nombre AS categoria, a.titulo, a.contenido, a.url, a.fecha_publicacion 
            FROM articulos a
            JOIN categorias c ON a.categoria_id = c.id
            LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limite, $offset);
        $stmt->execute();
        return $stmt->get_result();
    }

}
