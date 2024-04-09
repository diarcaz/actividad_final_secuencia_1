<?php
include 'vars.php';

if (empty($_GET["id"])) {
    http_response_code(400);
    exit("Falta id"); 
}

if (empty($_GET["nombre"])) {
    http_response_code(400);
    exit("Falta nombre"); 
}

if (empty($_GET["categoria"])) {  
    http_response_code(400);
    exit("Falta categoría"); 
}

if (empty($_GET["precio"])) {
    http_response_code(400);
    exit("Falta precio"); 
}

if (empty($_GET["cantidad_en_stock"])) { 
    http_response_code(400);
    exit("Falta cantidad en stock"); 
}

if (empty($_GET["proveedor"])) { 
    http_response_code(400);
    exit("Falta proveedor");
}

$conex = new PDO("sqlite:" . $fichero);
$conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$producto = [
    "id" => $_GET["id"],
    "nombre" => $_GET["nombre"],
    "categoria" => $_GET["categoria"], 
    "precio" => $_GET["precio"],
    "cantidad_en_stock" => $_GET["cantidad_en_stock"],
    "proveedor" => $_GET["proveedor"] 
];

try {
    # Preparar la consulta para actualizar los datos del producto
    $sentencia = $conex->prepare("UPDATE Producto_hardware SET nombre=:nombre, categoria=:categoria, precio=:precio,
     cantidad_en_stock=:cantidad_en_stock, proveedor=:proveedor WHERE id=:id;");
    $resultado = $sentencia->execute($producto);

    # Si se actualizaron los datos correctamente, responder con un mensaje de éxito
    if ($resultado) {
        http_response_code(200);
        echo "Datos actualizados correctamente";
    } else {
        # Si hubo algún error al actualizar los datos, responder con un mensaje de error
        http_response_code(400);
        echo "Error al actualizar los datos";
    }
} catch(PDOException $exc) {
    # Si hubo una excepción, responder con un mensaje de error
    http_response_code(400);
    echo "Lo siento, ocurrió un error: " . $exc->getMessage();
}

# Cerrar la conexión a la base de datos
$conex = null;
?>
