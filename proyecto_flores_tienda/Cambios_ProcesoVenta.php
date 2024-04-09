<?php
include 'vars.php';

if (empty($_GET["id_venta"])) {
    http_response_code(400);
    exit("Falta ID de venta"); 
}

if (empty($_GET["fecha_hora"])) {
    http_response_code(400);
    exit("Falta fecha y hora"); 
}

if (empty($_GET["total_venta"])) {
    http_response_code(400);
    exit("Falta total de la venta"); 
}

$conex = new PDO("sqlite:" . $fichero);
$conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$venta = [
    "id_venta" => $_GET["id_venta"],
    "fecha_hora" => $_GET["fecha_hora"],
    "total_venta" => $_GET["total_venta"]
];

try {
    # Preparar la consulta para insertar los datos de la venta como un producto
    $sentencia = $conex->prepare("INSERT INTO ProcesoVenta (id_venta, fecha_hora, total_venta)
        VALUES (:id_venta, :fecha_hora, :total_venta);");
    $resultado = $sentencia->execute($venta);

    # Si se insertaron los datos correctamente, responder con un mensaje de éxito
    if ($resultado) {
        http_response_code(200);
        echo "Venta registrada correctamente como producto";
    } else {
        # Si hubo algún error al insertar los datos, responder con un mensaje de error
        http_response_code(400);
        echo "Error al registrar la venta como producto";
    }
} catch(PDOException $exc) {
    # Si hubo una excepción, responder con un mensaje de error
    http_response_code(400);
    echo "Lo siento, ocurrió un error: " . $exc->getMessage();
}

# Cerrar la conexión a la base de datos
$conex = null;
?>
