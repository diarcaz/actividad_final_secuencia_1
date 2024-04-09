<?php
include 'vars.php';


if (empty($_GET["id"])) {
    http_response_code(400);
    exit("Falta id"); 
}

$conex = new PDO("sqlite:" . $fichero);
$conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$producto_id = $_GET["id"];

try {
    $sentencia = $conex->prepare("DELETE FROM Producto_hardware WHERE id = :id");
    $sentencia->bindParam(':id', $producto_id, PDO::PARAM_INT);
    $resultado = $sentencia->execute();

    if ($resultado) {
        http_response_code(200);
        echo "Producto eliminado correctamente";
    } else {
        # Si hubo algún error al eliminar el producto, responder con un mensaje de error
        http_response_code(400);
        echo "Error al eliminar el producto";
    }
} catch(PDOException $exc) {
    # Si hubo una excepción, responder con un mensaje de error
    http_response_code(400);
    echo "Lo siento, ocurrió un error: " . $exc->getMessage();
}

# Cerrar la conexión a la base de datos
$conex = null;
?>
