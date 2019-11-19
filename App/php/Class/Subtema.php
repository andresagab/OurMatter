<?php
/**
 * @Class Subtema
 * @Autor Andres Geovanny Angulo Botina
 * @email andrescabj981@gmail.com
 */

class Subtema
{

    private $id;
    private $idTema;
    private $nombre;
    private $contenido;
    private $img;

    /**
     * Subtema constructor.
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
                $sql = "SELECT id, id_tema, nombre, contenido, img FROM sub_tema WHERE $field=$value $filter $order";
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
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * @param mixed $contenido
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;
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
     * @return Tema objeto de la clase tema
     */
    public function getTema(){
        if ($this->id != null) return new Tema('id', $this->idTema, null, null);
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
        $sql = "SELECT id, id_tema, nombre, contenido, img FROM sub_tema $filter $order";
        if (is_array($result = Conector::ejecutarQuery($sql, null))) {
            $data["status"] = true;
            $data["data"] = $result;
        }
        return $data;
    }

    /**
     * @param $filter : String con el filtro sql deseado, sin el where incluido.
     * @param $order : String con el orden deseado.
     * @return Subtema[] : Vector que contiene los registros en tipo de objeto 'Sitio'
     */
    public static function getObjects($filter, $order){
        $data = Subtema::getList($filter, $order)['data'];
        $objects = array();
        for ($i = 0; $i < count($data); $i++) $objects[$i] = new Subtema($data[$i], null, null, null);
        return $objects;
    }

    /**
     * @version Este método valida si el registro cargado como objeto puede ser eliminado.
     * @return bool : True el registro se puede eliminar
     */
    public function canDelete(){
        $status = true;
        if ($this->getId() != null) {
            $sql = "select count(id) as quantity from recurso where id_subtema = {$this->getId()}";
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
     * @version Esta función permite insertar datos de los campos id_tema, nombre, contenido e img de la tabla sub_tema.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function add(){
        $sql = "INSERT INTO sub_tema (id_tema, nombre, contenido, img) VALUES ({$this->idTema}, '{$this->nombre}', '{$this->contenido}', '{$this->img}')";
        return Conector::executeAUD($sql);
    }

    /**
     * @version Esta función permite modificar datos de los campos id_tema, nombre, contenido e img de la tabla
     * sub_tema. apartir del id del registro u objeto que ya ha sido cargadp previamente.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function update(){
        $sql = "UPDATE sub_tema SET id_tema = {$this->idTema}, nombre = '{$this->nombre}', contenido = '{$this->contenido}', img = '{$this->img}' WHERE id = {$this->id}";
        return Conector::executeAUD($sql);
    }

    /**
     * @version Esta funcioón permite eliminar el registro que es filtrado por el id del objeto.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function delete(){
        $sql = "DELETE FROM sub_tema WHERE id = '{$this->id}'";
        return Conector::executeAUD($sql);
    }

}