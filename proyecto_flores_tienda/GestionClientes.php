<?php
include 'vars.php';

# Verificar si se enviaron los parámetros requeridos
if (empty($_GET["id_cliente"])) {
    http_response_code(400);
    exit("Falta el ID del cliente"); # Terminar el script definitivamente
}

if (empty($_GET["nombre_cliente"])) {
    http_response_code(400);
    exit("Falta el nombre del cliente"); # Terminar el script definitivamente
}

if (empty($_GET["direccion"])) {
    http_response_code(400);
    exit("Falta la dirección del cliente"); # Terminar el script definitivamente
}

if (empty($_GET["num_telefono"])) {
    http_response_code(400);
    exit("Falta el número de teléfono del cliente"); # Terminar el script definitivamente
}

# Crear una nueva conexión a la base de datos
$conex = new PDO("sqlite:" . $fichero);
$conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

# Crear un arreglo con los datos del formulario
$cliente = [
    "id_cliente" => $_GET["id_cliente"],
    "nombre_cliente" => $_GET["nombre_cliente"],
    "direccion" => $_GET["direccion"],
    "num_telefono" => $_GET["num_telefono"]
];

try {
    # Preparar la consulta para insertar los datos del cliente
    $sentencia = $conex->prepare("INSERT INTO GestionCliente(id_cliente, nombre_cliente, direccion, num_telefono) VALUES (:id_cliente, :nombre_cliente, :direccion, :num_telefono);");
    
    # Ejecutar la consulta con los valores del cliente
    $resultado = $sentencia->execute($cliente);

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
