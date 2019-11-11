<?php
/**
 * @Class Evaluacion_Opcion
 * @Autor Andres Geovanny Angulo Botina
 * @email andrescabj981@gmail.com
 */

class Evaluacion_Opcion
{

    private $id;
    private $idEvaluacionPregunta;
    private $opcion;
    private $correcta;

    /**
     * Evaluacion_Opcion constructor.
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
                $sql = "SELECT id, id_evaluacionPregunta, opcion, correcta FROM evaluacion_opcion WHERE $field=$value $filter $order";
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
    public function getIdEvaluacionPregunta()
    {
        return $this->idEvaluacionPregunta;
    }

    /**
     * @param mixed $idEvaluacionPregunta
     */
    public function setIdEvaluacionPregunta($idEvaluacionPregunta)
    {
        $this->idEvaluacionPregunta = $idEvaluacionPregunta;
    }

    /**
     * @return mixed
     */
    public function getOpcion()
    {
        return $this->opcion;
    }

    /**
     * @param mixed $opcion
     */
    public function setOpcion($opcion)
    {
        $this->opcion = $opcion;
    }

    /**
     * @return mixed
     */
    public function getCorrecta()
    {
        return $this->correcta;
    }

    /**
     * @param mixed $correcta
     */
    public function setCorrecta($correcta)
    {
        $this->correcta = $correcta;
    }

    /**
     * @return Evaluacion_Pregunta objeto de la clase Evalucion_Pregunta
     */
    public function getEvaluacionPregunta() {
        if ($this->idEvaluacionPregunta != null) return new Evaluacion_Pregunta('id', $this->idEvaluacionPregunta, null, null);
        else return new Evaluacion_Pregunta(null. null, null, null, null);
    }

    /**
     * @param $data : Vector con el campo id_evaluacionPregunta y su respectivo valor
     * @version Se define el valor de la propiedad idEvaluacionPregunta
     */
    private function setPropiertiesClass($data){
        $this->idEvaluacionPregunta = $data['id_evaluacionPregunta'];
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
        $sql = "SELECT id, id_evaluacionPregunta, opcion, correcta FROM evaluacion_opcion $filter $order";
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
        $data = Evaluacion_Opcion::getList($filter, $order)['data'];
        $objects = array();
        for ($i = 0; $i < count($data); $i++) $objects[$i] = new Evaluacion_Opcion($data[$i], null, null, null);
        return $objects;
    }

    /**
     * @version Este método valida si el registro cargado como objeto puede ser eliminado.
     * @return bool : True el registro se puede eliminar
     */
    public function canDelete(){
        $status = true;
        if ($this->getId() != null) {
            $sql = "select count(id) as quantity from evaluacion_respuesta where id_evaluacionOpcion = {$this->getId()}";
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
     * @version Este método valida si todas las opciones de respuesta pueden ser eliminadas en conjunto
     * @param Evaluacion_Opcion $data Array con objetos de dicha clase
     * @return bool : True los registros se pueden eliminar - False los registros no se pueden eliminar
     */
    public static function canDeleteOptions($data){
        $status = true;
        for ($i = 0; $i < count($data); $i++) {
            if (!$data[$i]->canDelete()) {
                $status = false;
                break;
            }
        }
        return $status;
    }

    /**
     * @version Esta función permite insertar datos de los campos id_evaluacionPregunta ,opcion y correcta de la tabla evaluacion_opcion.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function add(){
        $sql = "INSERT INTO evaluacion_opcion (id_evaluacionPregunta, opcion, correcta) VALUES ({$this->idEvaluacionPregunta}, '{$this->opcion}', '{$this->correcta}')";
        return Conector::executeAUD($sql);
    }

    /**
     * @version Esta función permite modificar datos de los campos id_evaluacionPregunta ,opcion y correcta de la tabla
     * evaluacion_opcion apartir del id del registro u objeto que ya ha sido cargadp previamente.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function update(){
        $sql = "UPDATE evaluacion_opcion SET id_evaluacionPregunta = {$this->idEvaluacionPregunta}, opcion = '{$this->opcion}', correcta = '{$this->correcta}' WHERE id = {$this->id}";
        return Conector::executeAUD($sql);
    }

    /**
     * @version Esta funcioón permite eliminar el registro que es filtrado por el id del objeto.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function delete(){
        if ($this->canDelete()) {
            $sql = "DELETE FROM evaluacion_opcion WHERE id = '{$this->id}'";
            return Conector::executeAUD($sql);
        } else return false;
    }

    /**
     * @return string con el valor checked o null
     */
    public function getCheckedRadioHtml(){
        if ($this->correcta) return 'checked';
        else return '';
    }

}