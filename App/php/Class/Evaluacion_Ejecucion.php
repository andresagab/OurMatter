<?php
/**
 * @Class Evaluacion_Ejecucion
 * @Autor Andres Geovanny Angulo Botina
 * @email andrescabj981@gmail.com
 */

class Evaluacion_Ejecucion
{

    private $id;
    private $idEvaluacion;
    private $idEstudiante;
    private $fechaInicio;
    private $fechaFin;

    /**
     * Evaluacion_Ejecucion constructor.
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
                $sql = "SELECT id, id_evaluacion, id_estudiante, fechaInicio, fechaFin FROM evaluacion_ejecucion WHERE $field = $value $filter $order";
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
    public function getIdEstudiante()
    {
        return $this->idEstudiante;
    }

    /**
     * @param mixed $idEstudiante
     */
    public function setIdEstudiante($idEstudiante)
    {
        $this->idEstudiante = $idEstudiante;
    }

    /**
     * @return mixed
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * @param mixed $fechaInicio
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;
    }

    /**
     * @return mixed
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    /**
     * @param mixed $fechaFin
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;
    }

    /**
     * @return Evaluacion objeto de la clase Evalucion
     */
    public function getEvaluacion() {
        if ($this->idEvaluacion != null) return new Evaluacion('id', $this->idEvaluacion, null, null);
        else return new Evaluacion(null. null, null, null, null);
    }

    /**
     * @return Estudiante objeto de la clase Estudiante
     */
    public function getEstudiante() {
        if ($this->idEstudiante != null) return new Estudiante('id', $this->idEstudiante, null, null);
        else return new Estudiante(null. null, null, null, null);
    }

    /**
     * @param $data : Vector con el campo id_evaluacionPregunta y su respectivo valor
     * @version Se define el valor de la propiedad idEvaluacion
     */
    private function setPropiertiesClass($data){
        $this->idEvaluacion = $data['id_evaluacion'];
        $this->idEstudiante = $data['id_estudiante'];
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
        $sql = "SELECT id, id_evaluacion, id_estudiante, fechaInicio, fechaFin FROM evaluacion_ejecucion $filter $order";
        if (is_array($result = Conector::ejecutarQuery($sql, null))) {
            $data["status"] = true;
            $data["data"] = $result;
        }
        return $data;
    }

    /**
     * @param $filter : String con el filtro sql deseado, sin el where incluido.
     * @param $order : String con el orden deseado.
     * @return Evaluacion_Ejecucion[]: Vector que contiene los registros en tipo de objeto 'Sitio'
     */
    public static function getObjects($filter, $order){
        $data = Evaluacion_Ejecucion::getList($filter, $order)['data'];
        $objects = array();
        for ($i = 0; $i < count($data); $i++) $objects[$i] = new Evaluacion_Ejecucion($data[$i], null, null, null);
        return $objects;
    }

    /**
     * @version Este método valida si el registro cargado como objeto puede ser eliminado.
     * @return bool : True el registro se puede eliminar
     */
    public function canDelete(){
        $status = true;
        if ($this->getId() != null) {
            $sql = "select count(id) as quantity from evaluacion_respuesta where id_evaluacionEjecucion = {$this->getId()}";
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
     * @version Esta función permite insertar datos de los campos id_evaluacion ,idEstudiante y fechaInicio de la tabla evaluacion_ejecucion.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function add(){
        $sql = "INSERT INTO evaluacion_ejecucion (id_evaluacion, id_estudiante, fechaInicio) VALUES ({$this->idEvaluacion}, {$this->idEstudiante}, '{$this->fechaInicio}')";
        return Conector::executeAUD($sql);
    }

    /**
     * @version Esta función permite modificar datos de los campos id_evaluacion ,idEstudiantem fechaInicio y fechaFin de la tabla
     * evaluacion_ejecucion apartir del id del registro u objeto que ya ha sido cargadp previamente.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function update(){
        $sql = "UPDATE evaluacion_ejecucion SET id_evaluacion = {$this->idEvaluacion}, id_estudiante = {$this->idEstudiante}, fechaInicio = '{$this->fechaInicio}', fechaFin = {$this->fechaFin} WHERE id = {$this->id}";
        return Conector::executeAUD($sql);
    }

    /**
     * @version Esta funcioón permite eliminar el registro que es filtrado por el id del objeto.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function delete(){
        if ($this->canDelete()) {
            $sql = "DELETE FROM evaluacion_ejecucion WHERE id = '{$this->id}'";
            return Conector::executeAUD($sql);
        } else return false;
    }

    public function isComplete(){
        $status = true;
        if ($this->id != null) {
            $sql = "select count(id) FROM evaluacion_pregunta WHERE id_evaluacion = {$this->idEvaluacion}";
            if (is_array($result = Conector::ejecutarQuery($sql, null))) {
                if (count($result) > 0) {
                    if (isset($result[0][0])) {
                        $totalOpciones = (Int) $result[0][0] * 4;
                        $sql = "select count(id) as quantity from evaluacion_opcion where id NOT IN (select id_evaluacionOpcion FROM evaluacion_respuesta WHERE id_evaluacionEjecucion = {$this->id}) AND id_evaluacionPregunta IN (SELECT id FROM evaluacion_pregunta WHERE id_evaluacion = {$this->idEvaluacion})";
                        if (is_array($result = Conector::ejecutarQuery($sql, null))) {
                            if (count($result) > 0) {
                                if (isset($result[0]['quantity'])) {
                                    if ((Int) $result[0]['quantity'] == $totalOpciones) $status = false;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $status;
    }

    /**
     * @return int Valor con el número de preguntas que tiene la evaluacion
     */
    public function getTotalPreguntas(){
        $total = 0;
        if ($this->id != null) {
            $sql = "SELECT count(id) as total FROM evaluacion_pregunta where id_evaluacion = {$this->idEvaluacion}";
            if (is_array($result = Conector::ejecutarQuery($sql, null))) {
                if (count($result) > 0) {
                    if (isset($result[0]['total'])) $total = (Int) $result[0]['total'];
                }
            }
        }
        return $total;
    }

    /**
     * @return int Valor con el número de respuestas correctas
     */
    public function getTotalRespuestasCorrectas(){
        $total = 0;
        if ($this->id != null) {
            $sql = "SELECT count(eo.id) as total FROM evaluacion_opcion eo INNER JOIN evaluacion_respuesta er on eo.id = er.id_evaluacionOpcion WHERE er.id_evaluacionEjecucion = {$this->id} AND eo.correcta=1";
            if (is_array($result = Conector::ejecutarQuery($sql, null))) {
                if (count($result) > 0) {
                    if (isset($result[0]['total'])) $total = (Int) $result[0]['total'];
                }
            }
        }
        return $total;
    }

    /**
     * @param $totalPreguntas int Total de preguntas de la evaluación
     * @param $totalRespuestasCorrectas int Total de respuestas correctas de la evaluación
     * @return float|int Total de respuestas incorrectas de la evaluación
     */
    public static function getTotalRespuestasIncorrectas($totalPreguntas, $totalRespuestasCorrectas){
        return abs($totalPreguntas - $totalRespuestasCorrectas);
    }

    /**
     * @param $totalPreguntas int Total de preguntas de la evaluación
     * @param $totalRespuestasCorrectas int Total de respuestas correctas de la evaluación
     * @return float|int Valor de la calificación
     */
    public static function getCalificacion($totalPreguntas, $totalRespuestasCorrectas){
        return round(($totalRespuestasCorrectas * 5) / $totalPreguntas, 1);
    }

    /**
     * @param $calificacion float|int Valor de la calificación de una evaluación
     * @return string Color de la calificación para ser usado con bootstrap
     */
    public static function getColorCalificacion($calificacion){
        if ($calificacion > 3) return 'success';
        else return 'danger';
    }

}