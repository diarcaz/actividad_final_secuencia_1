<?php
include 'vars.php';

# Verificar si vienen los parámetros requeridos
if (empty($_GET["id_cliente"])) {
    http_response_code(400);
    exit("Falta id"); # Terminar el script definitivamente
}

$conex = new PDO("sqlite:" . $fichero);
$conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$producto_id = $_GET["id_cliente"];

try {
    # Preparar la consulta para eliminar el producto
    $sentencia = $conex->prepare("DELETE FROM GestionCliente WHERE id_cliente = :id_cliente");
    $sentencia->bindParam(':id_cliente', $producto_id, PDO::PARAM_STR);
    $resultado = $sentencia->execute();

    # Si se eliminó el producto correctamente, responder con un mensaje de éxito
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