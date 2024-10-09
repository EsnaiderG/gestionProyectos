<?php
require_once '../db_conexion.php';

class Resource
{
    // Método para crear un nuevo recurso
    public function createResource($id_recurso, $nombre, $descripcion, $valor, $unidad_medida)
    {
        global $pdo;
        $sql = "INSERT INTO recursos (id_recurso, nombre, descripcion, valor, unidad_medida) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_recurso, $nombre, $descripcion, $valor, $unidad_medida]);
    }

    // Método para actualizar un recurso existente
    public function updateResource($id_recurso, $nombre, $descripcion, $valor, $unidad_medida)
    {
        global $pdo;
        $sql = "UPDATE recursos SET nombre = ?, descripcion= ?, valor = ?, unidad_medida = ? WHERE id_recurso = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nombre, $descripcion, $valor, $unidad_medida, $id_recurso]);
    }

    // Opcionalmente, podrías añadir métodos para eliminar o recuperar recursos si es necesario
}
?>
