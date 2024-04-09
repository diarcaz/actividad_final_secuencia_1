<?php
include 'vars.php';

# Verificar si se enviaron los parámetros requeridos
if (empty($_GET["id_venta"])) {
    http_response_code(400);
    exit("Falta el ID de la venta"); # Terminar el script definitivamente
}

if (empty($_GET["fecha_hora"])) {
    http_response_code(400);
    exit("Falta la fecha"); # Terminar el script definitivamente
}

if (empty($_GET["total_venta"])) {
    http_response_code(400);
    exit("Falta el total de ventas"); # Terminar el script definitivamente
}


# Crear una nueva conexión a la base de datos
$conex = new PDO("sqlite:" . $fichero);
$conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

# Crear un arreglo con los datos del formulario
$producto = [
    "id_venta" => $_GET["id_venta"],
    "fecha_hora" => $_GET["fecha_hora"],
    "total_venta" => $_GET["total_venta"]
];

try {
    # Preparar la consulta para insertar los datos del producto
    $sentencia = $conex->prepare("INSERT INTO ProcesoVenta(id_venta, fecha_hora, total_venta) VALUES (:id_venta, :fecha_hora, :total_venta);");
    
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