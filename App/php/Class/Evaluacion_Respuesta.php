<?php
/**
 * @Class Evaluacion_Respuesta
 * @Autor Andres Geovanny Angulo Botina
 * @email andrescabj981@gmail.com
 */

class Evaluacion_Respuesta
{

    private $id;
    private $idEvaluacionEjecucion;
    private $idEvaluacionOpcion;
    private $fecha;

    /**
     * Evaluacion_Respuesta constructor.
     * @param $field : String con el campo a consulta o Array (vector) con todos los campos de la clase
     * @param $value : Valor del campo a consultar
     * @param $filter : String sql con el filtro adicional que se deseá (incluir campo AND u OR)
     * @param $order : String sql con el orden deseado para la consulta
     */
    public function __construct($field, $value, $filter, $order)
    {
        if (is_array($field)) {
            foreach ($field as $item => $val) $this->$item = $val;
            $this->setPropiertiesClass($field);
        }
        else {
            if ($value != null){
                $sql = "SELECT id, id_evaluacionEjecucion, id_evaluacionOpcion, fecha FROM evaluacion_respuesta WHERE $field=$value $filter $order";
                $result = Conector::ejecutarQuery($sql, null);
                if (count($result) > 0) {
                    foreach ($result[0] as $item => $val) $this->$item = $val;
                    $this->setPropiertiesClass($result[0]);
                }
            }
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIdEvaluacionEjecucion()
    {
        return $this->idEvaluacionEjecucion;
    }

    /**
     * @param mixed $idEvaluacionEjecucion
     */
    public function setIdEvaluacionEjecucion($idEvaluacionEjecucion)
    {
        $this->idEvaluacionEjecucion = $idEvaluacionEjecucion;
    }

    /**
     * @return mixed
     */
    public function getIdEvaluacionOpcion()
    {
        return $this->idEvaluacionOpcion;
    }

    /**
     * @param mixed $idEvaluacionOpcion
     */
    public function setIdEvaluacionOpcion($idEvaluacionOpcion)
    {
        $this->idEvaluacionOpcion = $idEvaluacionOpcion;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @return Evaluacion_Ejecucion objeto de la clase
     */
    public function getEvaluacionEjecucion() {
        if ($this->idEvaluacionEjecucion != null) return new Evaluacion_Ejecucion('id', $this->idEvaluacionEjecucion, null, null);
        else return new Evaluacion_Ejecucion(null. null, null, null, null);
    }

    /**
     * @return Evaluacion_Opcion objeto de la clase
     */
    public function getEvaluacionOpcion() {
        if ($this->idEvaluacionOpcion != null) return new Evaluacion_Opcion('id', $this->idEvaluacionOpcion, null, null);
        else return new Evaluacion_Opcion(null. null, null, null, null);
    }

    /**
     * @param $data : Vector con el campo id_evaluacionEjecucion y su respectivo valor
     * @version Se define el valor de la propiedad idEvaluacionEjecucion
     */
    private function setPropiertiesClass($data){
        $this->idEvaluacionEjecucion = $data['id_evaluacionEjecucion'];
        $this->idEvaluacionOpcion = $data['id_evaluacionOpcion'];
    }

    /**
     * @param $filter : String con el filtro sql deseado, sin el where incluido.
     * @param $order : String con el orden deseado.
     * @return array|bool : Array con el campo 'status' (false: error al cargar los datos, true: datos cargados) y
     * 'data' el cual contiene la lista de elemntos cargados.
     */
    public static function getList($filter, $order){
        $data = array();
        $data["status"] = false;
        $data["data"] = array();
        $filter = validFilterSQL($filter);
        $sql = "SELECT id, id_evaluacionEjecucion, id_evaluacionOpcion, fecha FROM evaluacion_respuesta $filter $order";
        if (is_array($result = Conector::ejecutarQuery($sql, null))) {
            $data["status"] = true;
            $data["data"] = $result;
        }
        return $data;
    }

    /**
     * @param $filter : String con el filtro sql deseado, sin el where incluido.
     * @param $order : String con el orden deseado.
     * @return array : Vector que contiene los registros en tipo de objeto 'Sitio'
     */
    public static function getObjects($filter, $order){
        $data = Evaluacion_Respuesta::getList($filter, $order)['data'];
        $objects = array();
        for ($i = 0; $i < count($data); $i++) $objects[$i] = new Evaluacion_Respuesta($data[$i], null, null, null);
        return $objects;
    }


    /**
     * @version Esta función permite insertar datos de los campos id_evaluacionEjecucion ,id_evaluacionOpcion y fecha de la tabla evaluacion_respuesta.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function add(){
        $sql = "INSERT INTO evaluacion_respuesta (id_evaluacionEjecucion, id_evaluacionOpcion, fecha) VALUES ({$this->idEvaluacionEjecucion}, {$this->idEvaluacionOpcion}, '{$this->fecha}')";
        return Conector::executeAUD($sql);
    }

    /**
     * @version Esta función permite modificar datos de los campos id_evaluacionEjecucion ,id_evaluacionOpcion y fecha de la tabla
     * evaluacion_respuesta apartir del id del registro u objeto que ya ha sido cargadp previamente.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function update(){
        $sql = "UPDATE evaluacion_respuesta SET id_evaluacionEjecucion = {$this->idEvaluacionEjecucion}, id_evaluacionOpcion = {$this->idEvaluacionOpcion}, fecha = '{$this->fecha}' WHERE id = {$this->id}";
        return Conector::executeAUD($sql);
    }

    /**
     * @version Esta funcioón permite eliminar el registro que es filtrado por el id del objeto.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function delete(){
        $sql = "DELETE FROM evaluacion_respuesta WHERE id = '{$this->id}'";
        return Conector::executeAUD($sql);
    }
}