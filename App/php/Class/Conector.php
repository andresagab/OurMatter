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
        $this->clave = '12345';
        $this->bd = 'ourmatter';
    }

    private function conectar($bd){
        try {
            if ($bd==null) $bd=$this->bd;
            $opciones=array();
            $this->conexion=new PDO("$this->controlador:host=$this->servidor;port=$this->puerto;dbname=$bd",$this->usuario, $this->clave,$opciones);
        } catch (Exception $exc) {
            $this->conexion=null;            
            echo 'Error en la conexion con la bd ' . $exc->getMessage();
            die();
        }
    }
    
    private function desconectar(){
        $this->conexion=null;
    }
    
    public static function ejecutarQuery($sql, $bd){
        $conector = new Conector();
        $conector->conectar($bd);
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
    }

    public static function ejecutarQueryMultiple($cadenaSQL,$bd){
        $cadenasSQL= explode(';', $cadenaSQL);
        $conector=new Conector();
        $conector->conectar($bd);
        
        for ($i = 0; $i < count($cadenasSQL); $i++) {
            $cadenaSQL=$cadenasSQL[$i];
            $sentencia=$conector->conexion->prepare($cadenaSQL);//seguramente hay error aqui
            if (!$sentencia->execute()){
                echo "Error al ejecutar $cadenaSQL en $bd";
                $conector->desconectar();
                return(false);
            } else {
                $consulta=$sentencia->fetchAll();
                $sentencia->closeCursor();
            }            
        }
        $conector->desconectar();
        return(true);
    }

    public static function getConsultaEnJSON($sql,$bd){
        $conector=new Conector();
        $conector->conectar($bd);
        $sentencia=$conector->conexion->prepare($sql);//seguramente hay error aqui
        if (!$sentencia->execute()){
            echo "Error al ejecutar $sql en $bd";
            $conector->desconectar();
            return(false);
        } else {
            $resultadoOrdenado=array();
            $consulta= mysqli_query($conector->conexion, $sql);
            while ($row = mysqli_fetch_array($resultado)){

                $objeto=array();
                $objeto["id"]=$row['id'];
                $objeto["nombre"]=$row['nombre'];
                $objeto["descripcion"]=$row['descripcion'];
                $objeto["imagen"]=$row['imagen'];
                array_push($resultadoOrdenado, $objeto);
            }
            $sentencia->closeCursor();
            $conector->desconectar();
            return($consulta);//comprobar qu� retorna en un insert, delete y update
        }
    }
    
}
