<?php
/**
 * Class Tema
 * Autor: Andres Geovanny Angulo Botina
 */

class Tema
{

    private $id;
    private $nombre;
    private $descripcion;
    private $img;

    /**
     * Tema constructor.
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
                $sql = "SELECT id, nombre, descripcion, img FROM tema WHERE $field=$value $filter $order";
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
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img)
    {
        $this->img = $img;
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
        $sql = "SELECT id, nombre, descripcion, img FROM tema $filter $order";
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
        $data = Tema::getList($filter, $order)['data'];
        $objects = array();
        for ($i = 0; $i < count($data); $i++) $objects[$i] = new Tema($data[$i], null, null, null);
        return $objects;
    }

    /**
     * @version Este método valida si el registro cargado como objeto puede ser eliminado.
     * @return bool : True el registro se puede eliminar
     */
    public function canDelete(){
        $status = true;
        if ($this->getId() != null) {
            $sql = "select count(id) as quantity from sub_tema where id_tema = {$this->getId()}";
            if (is_array($result = Conector::ejecutarQuery($sql, null))) {
                if (count($result) > 0) {
                    if (isset($result['quantity']))
                        if ($result['quantity'] > 0) $status = false;
                }
            }
        }
        return $status;
    }

    /**
     * @version Esta función permite insertar datos de los campos nombre, descripción e img de la tabla tema.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function add(){
        $sql = "INSERT INTO tema (nombre, descripcion, img) VALUES ('{$this->nombre}', '{$this->descripcion}', '{$this->img}')";
        return Conector::executeAUD($sql);
    }

    /**
     * @version Esta función permite modificar datos de los campos nombre, descripción e img de la tabla tema apartir
     * del id del registro u objeto que ya ha sido cargadp previamente.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function update(){
        $sql = "UPDATE tema SET nombre = '{$this->nombre}', descripcion = '{$this->descripcion}', img = '{$this->img}' WHERE id = '{$this->id}'";
        return Conector::executeAUD($sql);
    }

    /**
     * @version Esta funcioón permite eliminar el registro que es filtrado por el id del objeto.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function delete(){
        $sql = "DELETE FROM tema WHERE id = '{$this->id}'";
        return Conector::executeAUD($sql);
    }

}