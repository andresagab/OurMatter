<?php
/**
 * @Class Estudiante
 * @Autor Andres Geovanny Angulo Botina
 * @email andrescabj981@gmail.com
 */
class Estudiante
{

    private $id;
    private $nombres;
    private $apellidos;
    private $usuario;

    /**
     * Estudiante constructor.
     * @param $field : String con el campo a consulta o Array (vector) con todos los campos de la clase
     * @param $value : Valor del campo a consultar
     * @param $filter : String sql con el filtro adicional que se deseá (incluir campo AND u OR)
     * @param $order : String sql con el orden deseado para la consulta
     */
    public function __construct($field, $value, $filter, $order)
    {
        if (is_array($field)) foreach ($field as $item => $val) $this->$item = $val;
        else {
            if ($value != null){
                $sql = "SELECT id, nombres, apellidos, usuario FROM estudiante WHERE $field=$value $filter $order";
                $result = Conector::ejecutarQuery($sql, null);
                if (count($result) > 0) foreach ($result[0] as $item => $val) $this->$item = $val;
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
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * @param mixed $nombres
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;
    }

    /**
     * @return mixed
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @param mixed $apellidos
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return Usuario Objeto de la clase Usuario
     */
    public function getUsuarioObject(){
        if ($this->usuario != null) return new Usuario('usuario', $this->usuario, null, null);
        else return new Usuario(null, null, null, null);
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
        $sql = "SELECT id, nombres, apellidos, usuario FROM estudiante $filter $order";
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
        $data = Estudiante::getList($filter, $order)['data'];
        $objects = array();
        for ($i = 0; $i < count($data); $i++) $objects[$i] = new Estudiante($data[$i], null, null, null);
        return $objects;
    }

    /**
     * @version Este método valida si el registro cargado como objeto puede ser eliminado.
     * @return bool : True el registro se puede eliminar
     */
    public function canDelete(){
        $status = true;
        if ($this->getId() != null) {
            $sql = "select count(id) as quantity from evaluacion_ejecucion where id_estudiante = {$this->getId()}";
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
     * @version Esta función permite insertar datos de los campos nombres, apellidos y usuario de la tabla estudiante.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function add(){
        $sql = "INSERT INTO estudiante (nombres, apellidos, usuario) VALUES ('{$this->nombres}', '{$this->apellidos}', '{$this->usuario}')";
        return Conector::executeAUD($sql);
    }

    /**
     * @version Esta función permite modificar datos de los campos nombres, apellidos y usuario de la tabla
     * estudiante apartir del id del registro u objeto que ya ha sido cargadp previamente.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function update(){
        $sql = "UPDATE estudiante SET nombres = '{$this->nombres}', apellidos = '{$this->apellidos}', usuario = '{$this->usuario}' WHERE id = {$this->id}";
        return Conector::executeAUD($sql);
    }

    /**
     * @version Esta funcioón permite eliminar el registro que es filtrado por el id del objeto.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function delete(){
        $sql = "DELETE FROM estudiante WHERE id = '{$this->id}'";
        return Conector::executeAUD($sql);
    }

    /**
     * @version Métodos que permiter obtener las evaluaciones pendientes del estudiante
     * @return array - Arreglo vacio o con objetos de la clase Evaluacion
     */
    public function getEvaluacionesPendientes() {
        $objects = array();
        if ($this->id != null) {
            $sql = "select ev.id, ev.id_tema, ev.nombre, ev.descripcion, ev.fechaInicio, ev.fechaFin
                    from evaluacion ev WHERE ev.id NOT IN (SELECT id_evaluacion FROM evaluacion_ejecucion WHERE id_estudiante = {$this->id})";
            /*$sql = "select ev.id, ev.id_tema, ev.nombre, ev.descripcion, ev.fechaInicio, ev.fechaFin
                    from
                         evaluacion ev inner join evaluacion_ejecucion ee ON ev.id = ee.id_evaluacion
                         INNER JOIN estudiante e on ee.id_estudiante = e.id WHERE e.id = {$this->id} ORDER BY ev.fechaFin DESC";*/
            /*$sql = "select ev.id, ev.id_tema, ev.nombre, ev.descripcion, ev.fechaInicio, ev.fechaFin
                    from
                         evaluacion ev inner join evaluacion_pregunta ep on ev.id = ep.id_evaluacion
                             inner join evaluacion_opcion eo ON eo.id_evaluacionPregunta = ep.id
                             inner join evaluacion_respuesta er ON er.id_evaluacionOpcion = eo.id
                             inner join estudiante e on er.id_estudiante = e.id WHERE e.id = {$this->id} ORDER BY ev.fechaFin DESC";*/
            if (is_array(($result = Conector::ejecutarQuery($sql, null)))) {
                for ($i = 0; $i < count($result); $i++) {
                    if (isset($result[$i]['id'])) $objects[$i] = new Evaluacion($result[$i], null, null, null);
                }
            }
        }
        return $objects;
    }

}