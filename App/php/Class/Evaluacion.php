<?php
/**
 * @Class Evaluacion
 * @Autor Andres Geovanny Angulo Botina
 * @email andrescabj981@gmail.com
 */

class Evaluacion
{

    private $id;
    private $idTema;
    private $nombre;
    private $descripcion;
    private $fechaInicio;
    private $fechaFin;

    /**
     * Evaluacion constructor.
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
                $sql = "SELECT id, id_tema, nombre, descripcion, fechaInicio, fechaFin FROM evaluacion WHERE $field=$value $filter $order";
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
    public function getIdTema()
    {
        return $this->idTema;
    }

    /**
     * @param mixed $idTema
     */
    public function setIdTema($idTema)
    {
        $this->idTema = $idTema;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
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
     * @return Tema objeto de la clase tema
     */
    public function getTema(){
        if ($this->idTema != null) return new Tema('id', $this->idTema, null, null);
        else return new Tema(null. null, null, null, null);
    }

    /**
     * @param $data : Vector con el campo id_tema y su respectivo valor
     * @version Se define el valor de la propiedad idTema de la clase SubTema
     */
    private function setPropiertiesClass($data){
        $this->idTema = $data['id_tema'];
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
        $sql = "SELECT id, id_tema, nombre, descripcion, fechaInicio, fechaFin FROM evaluacion $filter $order";
        if (is_array($result = Conector::ejecutarQuery($sql, null))) {
            $data["status"] = true;
            $data["data"] = $result;
        }
        return $data;
    }

    /**
     * @param $filter : String con el filtro sql deseado, sin el where incluido.
     * @param $order : String con el orden deseado.
     * @return Evaluacion[] : Vector que contiene los registros en tipo de objeto 'Sitio'
     */
    public static function getObjects($filter, $order){
        $data = Evaluacion::getList($filter, $order)['data'];
        $objects = array();
        for ($i = 0; $i < count($data); $i++) $objects[$i] = new Evaluacion($data[$i], null, null, null);
        return $objects;
    }

    /**
     * @version Este método valida si el registro cargado como objeto puede ser eliminado.
     * @return bool : True el registro se puede eliminar
     */
    public function canDelete(){
        $status = true;
        if ($this->getId() != null) {
            $sql = "select count(id) as quantity from evaluacion_pregunta where id_evaluacion = {$this->getId()}";
            if (is_array($result = Conector::ejecutarQuery($sql, null))) {
                if (count($result) > 0) {
                    if (isset($result[0]['quantity'])) {
                        if ((Int) ($result[0]['quantity']) > 0) $status = false;
                    }
                }
            }
        }
        return $status;
    }

    /**
     * @version Esta función permite insertar datos de los campos id_tema, nombre, descripcion, fechaInicio y fechaFin de la tabla evaluacion.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function add(){
        $sql = "INSERT INTO evaluacion (id_tema, nombre, descripcion, fechaInicio, fechaFin) VALUES ({$this->idTema}, '{$this->nombre}', '{$this->descripcion}', '{$this->fechaInicio}', '{$this->fechaFin}')";
        return Conector::executeAUD($sql);
    }

    /**
     * @version Esta función permite modificar datos de los campos id_tema, nombre, descripcion, fechaInicio y fechaFin de la tabla
     * evaluacion. apartir del id del registro u objeto que ya ha sido cargadp previamente.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function update(){
        $sql = "UPDATE evaluacion SET id_tema = {$this->idTema}, nombre = '{$this->nombre}', descripcion = '{$this->descripcion}', fechaInicio = '{$this->fechaInicio}', fechaFin = '{$this->fechaFin}' WHERE id = {$this->id}";
        return Conector::executeAUD($sql);
    }

    /**
     * @version Esta funcioón permite eliminar el registro que es filtrado por el id del objeto.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function delete(){
        $sql = "DELETE FROM evaluacion WHERE id = '{$this->id}'";
        return Conector::executeAUD($sql);
    }

    /**
     * @return string Valor del estado de la evaluación, Disponible o cerrada
     * @throws Exception
     */
    public function statusEvaluacion(){
        $status = 'Disponible';
        if ($this->getId() != null) {
            $currentDate = new DateTime('now', new DateTimeZone('America/Bogota'));
            $endDate = new DateTime("{$this->getFechaFin()}", new DateTimeZone('America/Bogota'));
            if ($currentDate > $endDate) $status = 'Cerrada';
        }
        return $status;
    }

    /**
     * @param $status String Valor que retorna el método statusEvaluación
     * @return string Valor del color correspondiente al estado de la evaluación: success = Disponible, danger = Cerrada
     * y dark = Desconocido
     */
    public function getColorStatus($status){
        if (strtolower($status) == 'disponible') return 'success';
        else if (strtolower($status) == 'cerrada') return 'danger';
        else return 'dark';
    }

    /**
     * @param $idEstudiante Valor del id del estudiante que se desea comprobar
     * @param $nameStatus Boolean True si se quiere el nombre del estado, False si se quiere el numero del estado
     * @return int|String Valor correspondiente al estado de la evaluación del estudiante: 0 = Pendiente | 1 = Incompleta | 2 = Terminada
     */
    public function statusEvaluacionEstudiante($idEstudiante, $nameStatus){
        $status = 0;
        $name = 'Pendiente';
        if ($this->id != null) {
            //Cargamos las evaluaciones que el estudiante tiene registrada una realción
            $evaluacionEstudiante = new Evaluacion_Ejecucion('id_evaluacion', $this->id, "AND id_estudiante = $idEstudiante", 'order by id');
            if ($evaluacionEstudiante->getId() != null) {
                if ($evaluacionEstudiante->getFechaFin() == null || $evaluacionEstudiante == '') {
                    $status = 1;
                    $name = 'Incompleta';
                }
                else {
                    $status = 2;
                    $name = 'Terminada';
                }
            }
        }
        if ($nameStatus) return $name;
        else return $status;
    }

    /**
     * @param $status String Valor que retorna el método statusEvaluaciónEstudiante
     * @return string Valor del color correspondiente al estado de la evaluación del estudiante
     */
    public function getColorStatusEvaluacionEstudiante($status){
        switch ($status){
            case 0: return 'danger';
            case 1: return 'warning';
            case 2: return 'success';
            default: return 'dark';
        }
    }

    /**
     * @version Método que retorna el estado de la evaluación con respecto a respuestas de estudiantes
     * @return bool True la evaluación ha sido resuelta por algunos estudiantes, False la evaluación aún no ha sido resuelta
     */
    public function studentsAnswered(){
        $status = false;
        if ($this->id != null) {
            $sql = "SELECT count(id) as quantity FROM evaluacion_ejecucion WHERE id_evaluacion = {$this->id}";
            if (is_array($result = Conector::ejecutarQuery($sql, null))) {
                if (count($result) > 0) {
                    if (isset($result[0]['quantity']))
                        if ((int) $result[0]['quantity'] > 0) $status = true;
                }
            }
        }
        return $status;
    }

    /**
     * @version Método que nos genera el número de respuestas registradas para la evaluación
     * @return int Cantidad de respuestas registradas
     */
    public function getTotalAnswers(){
        $total = 0;
        if ($this->id != null) {
            $sql = "SELECT count(id) as quantity FROM evaluacion_ejecucion WHERE id_evaluacion = {$this->id}";
            if (is_array($result = Conector::ejecutarQuery($sql, null))) {
                if (count($result) > 0) {
                    if (isset($result[0]['quantity']))
                        if ((int) $result[0]['quantity'] > 0) $total = $result[0]['quantity'];
                }
            }
        }
        return $total;
    }

}
