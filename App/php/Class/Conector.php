<?php
class Conector {
    private $servidor;
    private $puerto;
    private $controlador;
    private $usuario;
    private $clave;
    private $bd;
    private $conexion;
    
    function __construct() {
        $this->servidor = 'localhost';
        $this->puerto = '3306';
        $this->controlador = 'mysql';
        $this->usuario = 'root';
        $this->clave = '';
        $this->bd = 'ourmatter';
    }

    private function conectar($bd){
        $connect = false;
        try {
            if ($bd==null) $bd=$this->bd;
            $opciones=array();
            $this->conexion=new PDO("$this->controlador:host=$this->servidor;port=$this->puerto;dbname=$bd",$this->usuario, $this->clave,$opciones);
            $connect = true;
        } catch (Exception $exc) {
            $this->conexion=null;            
            echo 'Error en la conexion con la bd ' . $exc->getMessage();
        }
        return $connect;
    }
    
    private function desconectar(){
        $this->conexion=null;
    }
    
    public static function ejecutarQuery($sql, $bd){
        $conector = new Conector();
        if ($conector->conectar($bd)) {
            $sentencia = $conector->conexion->prepare($sql);
            if (!$sentencia->execute()){
                echo "Error al ejecutar $sql en $bd";
                $conector->desconectar();
                return(false);
            } else {
                $consulta=$sentencia->fetchAll();
                $sentencia->closeCursor();
                $conector->desconectar();
                return($consulta);//comprobar que retorna en un insert, delete y update
            }
        } else return false;
    }

    public static function executeAUD($sql){
        $status = false;
        $connect = new Conector();
        $connect->conectar(null);
        $statement = $connect->conexion->prepare($sql);
        if ($statement->execute()){
            $status = true;
        } else echo "Error al ejecutar $sql";
        //$statement->closeCursor();
        $connect->desconectar();
        return $status;
    }
    
}
