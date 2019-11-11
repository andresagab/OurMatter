<?php
/**
 * @Class Evaluacion_Pregunta
 * @Autor Andres Geovanny Angulo Botina
 * @email andrescabj981@gmail.com
 */

class Evaluacion_Pregunta
{

    private $id;
    private $idEvaluacion;
    private $pregunta;

    /**
     * Evaluacion_Pregunta constructor.
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
                $sql = "SELECT id, id_evaluacion, pregunta FROM evaluacion_pregunta WHERE $field=$value $filter $order";
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
    public function getIdEvaluacion()
    {
        return $this->idEvaluacion;
    }

    /**
     * @param mixed $idEvaluacion
     */
    public function setIdEvaluacion($idEvaluacion)
    {
        $this->idEvaluacion = $idEvaluacion;
    }

    /**
     * @return mixed
     */
    public function getPregunta()
    {
        return $this->pregunta;
    }

    /**
     * @param mixed $pregunta
     */
    public function setPregunta($pregunta)
    {
        $this->pregunta = $pregunta;
    }

    /**
     * @return Evaluacion objeto de la clase evaluacion
     */
    public function getEvaluacion() {
        if ($this->idEvaluacion != null) return new Evaluacion('id', $this->idEvaluacion, null, null);
        else return new Evaluacion(null. null, null, null, null);
    }

    /**
     * @param $data : Vector con el campo id_evaluacion y su respectivo valor
     * @version Se define el valor de la propiedad idEvaluacion
     */
    private function setPropiertiesClass($data){
        $this->idEvaluacion = $data['id_evaluacion'];
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
        $sql = "SELECT id, id_evaluacion, pregunta FROM evaluacion_pregunta $filter $order";
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
        $data = Evaluacion_Pregunta::getList($filter, $order)['data'];
        $objects = array();
        for ($i = 0; $i < count($data); $i++) $objects[$i] = new Evaluacion_Pregunta($data[$i], null, null, null);
        return $objects;
    }

    /**
     * @version Este método valida si el registro cargado como objeto puede ser eliminado.
     * @return bool : True el registro se puede eliminar
     */
    public function canDelete(){
        $status = true;
        if ($this->getId() != null) {
            $sql = "select count(id) as quantity from evaluacion_opcion where id_evaluacionPregunta = {$this->getId()}";
            if (is_array($result = Conector::ejecutarQuery($sql, null))) {
                if (count($result) > 0) {
                    if (isset($result[0]['quantity']))
                        if ($result[0]['quantity'] > 0) $status = false;
                }
            }
        }
        return $status;
    }

    /**
     * @version Esta función permite insertar datos de los campos id_evaluacion y pregunta de la tabla evaluacion.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function add(){
        $sql = "INSERT INTO evaluacion_pregunta (id_evaluacion, pregunta) VALUES ({$this->idEvaluacion}, '{$this->pregunta}')";
        return Conector::executeAUD($sql);
    }

    /**
     * @version Esta función permite modificar datos de los campos id_evaluacion y pregunta de la tabla
     * evaluacion. apartir del id del registro u objeto que ya ha sido cargadp previamente.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function update(){
        $sql = "UPDATE evaluacion_pregunta SET id_evaluacion = {$this->idEvaluacion}, pregunta = '{$this->pregunta}' WHERE id = {$this->id}";
        return Conector::executeAUD($sql);
    }

    /**
     * @version Esta funcioón permite eliminar el registro que es filtrado por el id del objeto.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function delete(){
        $sql = "DELETE FROM evaluacion_pregunta WHERE id = '{$this->id}'";
        return Conector::executeAUD($sql);
    }

}