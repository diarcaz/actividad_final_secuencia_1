<?php
include 'vars.php';

# Verificar si se enviaron los parámetros requeridos
if (empty($_GET["id"])) {
    http_response_code(400);
    exit("Falta el ID"); # Terminar el script definitivamente
}

if (empty($_GET["nombre"])) {
    http_response_code(400);
    exit("Falta el nombre"); # Terminar el script definitivamente
}

if (empty($_GET["categoria"])) {
    http_response_code(400);
    exit("Falta la categoria"); # Terminar el script definitivamente
}

if (empty($_GET["precio"])) {
    http_response_code(400);
    exit("Falta el precio"); # Terminar el script definitivamente
}

if (empty($_GET["cantidad_en_stock"])) {
    http_response_code(400);
    exit("Falta la cantidad del stock"); # Terminar el script definitivamente
}

if (empty($_GET["proveedor"])) {
    http_response_code(400);
    exit("Falta el proveedor"); # Terminar el script definitivamente
}

# Crear una nueva conexión a la base de datos
$conex = new PDO("sqlite:" . $fichero);
$conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

# Crear un arreglo con los datos del formulario
$producto = [
    "id" => $_GET["id"],
    "nombre" => $_GET["nombre"],
    "categoria" => $_GET["categoria"],
    "precio" => $_GET["precio"],
    "cantidad_en_stock" => $_GET["cantidad_en_stock"],
    "proveedor" => $_GET["proveedor"]
];

try {
    # Preparar la consulta para insertar los datos del producto
    $sentencia = $conex->prepare("INSERT INTO Producto_hardware(id, nombre, categoria, precio, cantidad_en_stock, proveedor) VALUES (:id, :nombre, :categoria, :precio, :cantidad_en_stock, :proveedor);");
    
    # Ejecutar la consulta con los valores del producto
    $resultado = $sentencia->execute($producto);

    # Si se insertaron los datos correctamente, responder con un mensaje de éxito
    if ($resultado) {
        http_response_code(200);
        echo "Datos insertados correctamente";
    } else {
        # Si hubo algún error al insertar los datos, responder con un mensaje de error
        http_response_code(400);
        echo "Error al insertar los datos";
    }
} catch(PDOException $exc) {
    # Si hubo una excepción, responder con un mensaje de error
    http_response_code(400);
    echo "Lo siento, ocurrió un error: " . $exc->getMessage();
}

# Cerrar la conexión a la base de datos
$conex = null;
?>