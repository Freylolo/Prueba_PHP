<?php
require_once 'conexion.php';

// Verifica si se paso el id de la cita 
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Verifica que el id sea un número valido
    if (is_numeric($id)) {
        $sql = "DELETE FROM citas WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        // Redirigir a la pagina de listado de citas despues de eliminar
        header("Location: index.php");
        exit;
    } else {
        // Si el ID no es valido
        echo "ID inválido.";
        exit;
    }
} else {
    echo "No se ha especificado el ID de la cita.";
    exit;
}
?>
