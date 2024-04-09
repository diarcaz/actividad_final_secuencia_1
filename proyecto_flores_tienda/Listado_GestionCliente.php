<?php
include 'vars.php';

class conexSqlite3{
    private $fichero="";
    private $conexion=[
        "conex"=>NULL,
        "error"=>NULL
    ];
    function __construct($nf) {
        $this->fichero=$nf;
    }
    function open(){
        if (file_exists($this->fichero)) {
            $conex = new PDO("sqlite:" . $this->fichero);
            $conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion["conex"]=$conex;
            $this->conexion["error"]=NULL;
            return $this->conexion;
        }else{
            $this->conexion["conex"]=NULL;
            $this->conexion["error"]="No existe";
            return $this->conexion;
        }
    
    }
    function close(){
        $this->conexion["conex"]=NULL;
    }
}


$obj=new conexSqlite3($fichero);

$conexion=$obj->open();
if(is_null($conexion["error"])){
    $conex=$conexion["conex"];
    try{
        $stmt = $conex->prepare('SELECT * FROM GestionCliente;');
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt=null;
        $obj->close();
        http_response_code(200);
        echo json_encode($data);
    }catch(PDOException $exc){
        http_response_code(400);
        echo "Error no se pudo abrir la base de datos----->".$exc->getMessage();
    }
}else{
    http_response_code(400);
    echo "Error no se pudo abrir la base de datos: ".$conexion["error"];
}

?>