<?php
/**
 * Class Sitio
 * Autor: Andres Geovanny Angulo Botina
 */

class Sitio extends Usuario
{

    private $id;
    private $name_materia;
    private $descripcion_materia;
    private $img_materia;
    private $img_materiaInformacion;
    private $name_institucion;
    private $grado;
    private $name_docente;
    private $email_docente;
    private $cel_docente;
    private $foto_docente;
    private $usuario;


    /**
     * Sitio constructor.
     * @param $field : String con el campo a consulta o Array (vector) con todos los campos de la clase
     * @param $value : Valor del campo a consultar
     * @param $filter : String sql con el filtro adicional que se deseá (incluir campo AND u OR)
     * @param $order : String sql con el orden deseado para la consulta
     */
    public function __construct($field, $value, $filter, $order)
    {
        if (is_array($field)){
            foreach ($field as $item => $val) $this->$item = $val;
            parent::__construct('usuario', $this->usuario, null, 'limit 1');
            //$this->setPropiertiesClass($field);
        } else {
            if ($value != null){
                $sql = "SELECT id, name_materia, descripcion_materia, img_materia, img_materiaInformacion, name_institucion, grado, name_docente, email_docente, cel_docente, foto_docente, usuario FROM sitio WHERE $field='$value' $filter $order";
                $result = Conector::ejecutarQuery($sql, null);
                if (count($result) > 0){
                    foreach ($result[0] as $item => $val) $this->$item = $val;
                    parent::__construct('usuario', $this->usuario, null, 'limit 1');
                    //$this->setPropiertiesClass($result[0]);
                }
            }
        }
    }

    /**
     * @param $data : Vector con el campo contraseña y su respectivo valor
     * Se define el valor de la propiedad password de la clase Usuario
     */
    private function setPropiertiesClass($data){
        //$this->password = $data['contrasena'];
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
    public function getNameMateria()
    {
        return $this->name_materia;
    }

    /**
     * @param mixed $name_materia
     */
    public function setNameMateria($name_materia)
    {
        $this->name_materia = $name_materia;
    }

    /**
     * @return mixed
     */
    public function getDescripcionMateria()
    {
        return $this->descripcion_materia;
    }

    /**
     * @param mixed $descripcion_materia
     */
    public function setDescripcionMateria($descripcion_materia)
    {
        $this->descripcion_materia = $descripcion_materia;
    }

    /**
     * @return mixed
     */
    public function getImgMateria()
    {
        return $this->img_materia;
    }

    /**
     * @param mixed $img_materia
     */
    public function setImgMateria($img_materia)
    {
        $this->img_materia = $img_materia;
    }

    /**
     * @return mixed
     */
    public function getImgMateriaInformacion()
    {
        return $this->img_materiaInformacion;
    }

    /**
     * @param mixed $img_materiaInformacion
     */
    public function setImgMateriaInformacion($img_materiaInformacion)
    {
        $this->img_materiaInformacion = $img_materiaInformacion;
    }

    /**
     * @return mixed
     */
    public function getNameInstitucion()
    {
        return $this->name_institucion;
    }

    /**
     * @param mixed $name_institucion
     */
    public function setNameInstitucion($name_institucion)
    {
        $this->name_institucion = $name_institucion;
    }

    /**
     * @return mixed
     */
    public function getGrado()
    {
        return $this->grado;
    }

    /**
     * @param mixed $grado
     */
    public function setGrado($grado)
    {
        $this->grado = $grado;
    }

    /**
     * @return mixed
     */
    public function getNameDocente()
    {
        return $this->name_docente;
    }

    /**
     * @param mixed $name_docente
     */
    public function setNameDocente($name_docente)
    {
        $this->name_docente = $name_docente;
    }

    /**
     * @return mixed
     */
    public function getEmailDocente()
    {
        return $this->email_docente;
    }

    /**
     * @param mixed $email_docente
     */
    public function setEmailDocente($email_docente)
    {
        $this->email_docente = $email_docente;
    }

    /**
     * @return mixed
     */
    public function getCelDocente()
    {
        return $this->cel_docente;
    }

    /**
     * @param mixed $cel_docente
     */
    public function setCelDocente($cel_docente)
    {
        $this->cel_docente = $cel_docente;
    }

    /**
     * @return mixed
     */
    public function getFotoDocente()
    {
        return $this->foto_docente;
    }

    /**
     * @param mixed $foto_docente
     */
    public function setFotoDocente($foto_docente)
    {
        $this->foto_docente = $foto_docente;
    }

    /**
     * @return mixed : valor en la propiedad $usuario o el objeto de la Clase Usuairo.
     * @param $object : Valor booleano que sirve para identificar si la función retornará un objeto o simplemente el
     * valor en la propiedad $usuario
     */
    public function getUsuarioFO($object)
    {
        if ($object) return new Usuario('usuario', $this->usuario, null, 'limit 1');
        else return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @param $filter : String con el filtro sql deseado, sin el where incluido.
     * @param $order : String con el orden deseado.
     * @return array|bool : Array con el campo 'status' (false: error al cargar los datos, true: datos cargados) y
     * 'data' el cual contiene la lista de elemntos cargados.
     */
    public static function getList($filter, $order){
        $filter = validFilterSQL($filter);
        $sql = "SELECT id, name_materia, descripcion_materia, img_materia, img_materiaInformacion, name_institucion, grado, name_docente, email_docente, cel_docente, foto_docente, usuario FROM sitio $filter $order";
        $result = Conector::ejecutarQuery($sql, null);
        $data = array();
        $data["status"] = false;
        $data["data"] = array();
        if (is_array($result)) {
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
        $data = Sitio::getList($filter, $order)['data'];
        $objects = array();
        for ($i = 0; i < count($data); $i++) $objects[$i] = new Sitio($data[$i], null, null, null);
        return $objects;
    }

    /**
     * @param $type : Int que define el tipo de operación a ejecutar: 'True' carga un solo dato en formato JSON y
     * 'False' carga todos los registros de la tabla 'Sitio' en formato JSON
     * @param $field : String con el campo a consulta o Array (vector) con todos los campos de la clase
     * @param $value : Valor del campo a consultar
     * @param $filter : String sql con el filtro adicional que se deseá (incluir campo AND u OR)
     * @param $order : String sql con el orden deseado para la consulta
     * @param $extras : True se cargan los campos extras al registro o los registros.
     * @return false|string : JSON con los datos cargados (Un único registro o varios registros)
     */
    public static function getDataJSON($type, $field, $value, $filter, $order, $extras){
        $JSON = array();
        if ($type){
            if ($value != null){
                $object = new Sitio($field, $value, $filter, $order);
                foreach ($object as $item => $val) $JSON["$item"] = $val;
                if ($extras) $JSON['dataUsuario'] = json_decode(Usuario::getDataJSON(true, 'usuario', $object->getUsuarioFO(false), null, null, false));
            }
        } else {
            $data = Sitio::getObjects($filter, $order);
            for ($i = 0; $i < count($data); $i++) {
                $object = array();
                foreach ($data[$i] as $item => $val) $object["$item"] = $val;
                if ($extras) $object['dataUsuario'] = json_decode(Usuario::getDataJSON(true, 'usuario', $data[$i]->getUsuarioFO(false), null, null, false));
                array_push($JSON, $object);
            }
        }
        return json_encode($JSON, JSON_INVALID_UTF8_IGNORE);
    }

    /**
     * @version Esta función permite actualizar los campos name_institucion y grado de la tabla 'Sitio'
     * @return bool : False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function update_General(){
        $sql = "UPDATE sitio set name_institucion='{$this->name_institucion}', grado='{$this->grado}' WHERE id=$this->id";
        return Conector::executeAUD($sql);
    }

    /**
     * @version Esta función permite actualizar los campos name_docente, email_docente, cel_docente y foto_docente de la tabla 'Sitio'
     * @return bool : False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function update_Docente(){
        $sql = "UPDATE sitio set name_docente='{$this->name_docente}', email_docente='{$this->email_docente}', cel_docente='{$this->cel_docente}', foto_docente='{$this->foto_docente}' WHERE id=$this->id";
        return Conector::executeAUD($sql);
    }

    /**
     * @version Esta función permite actualizar los campos name_materia, descripcion_materia, img_materia e img_materiaInformacion de la tabla 'Sitio'
     * @return bool : False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function update_Materia(){
        $sql = "UPDATE sitio set name_materia='{$this->name_materia}', descripcion_materia='{$this->descripcion_materia}', img_materia='{$this->img_materia}', img_materiaInformacion='{$this->img_materiaInformacion}' WHERE id=$this->id";
        return Conector::executeAUD($sql);
    }

}