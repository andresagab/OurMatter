<?php
/**
 * Class Usuario
 * Autor: Andres Geovanny Angulo Botina
 */
class Usuario
{

    private $usuario;
    private $password;
    private $estado;

    /**
     * Usuario constructor.
     */
    public function __construct($field, $value, $filter, $order)
    {
        if (is_array($field)){
            foreach ($field as $item => $val) $this->$item = $val;
            $this->setPropiertiesClass($field);
        } else {
            if ($value != null){
                $sql = "SELECT usuario, contrasena, estado FROM usuario WHERE $field='$value' $filter $order";
                $result = Conector::ejecutarQuery($sql, null);
                if (count($result) > 0){
                    foreach ($result[0] as $item => $val) $this->$item = $val;
                    $this->setPropiertiesClass($result[0]);
                }
            }
        }
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
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        if (strlen($password <= 32)) $this->password = md5($password);
        else $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * @param $data : Vector con el campo contraseña y su respectivo valor
     * Se define el valor de la propiedad password de la clase Usuario
     */
    private function setPropiertiesClass($data){
        $this->password = $data['contrasena'];
    }

    /**
     * @return string - $typeUSer : Retorna el tipo de usuario docente, estudiante o unknow
     *
     * @version
     * Este método usa el valor de la propiedad usuario de esta clase para compararlo con el registrado en la base de
     * datos en la tabla 'sitio', si la validación es verdadera se obtiene que el usuario es de tipo Docente en caso
     * contrario se lo define como tipo Estudiante
     *
     */
    private function getTypeUser(){
        $typeUser = "Unknow";
        if ($this->usuario != null) {
            $sql = "SELECT u.usuario FROM usuario as u, sitio as s where u.usuario='$this->usuario' and s.usuario=u.usuario limit 1";
            $result = Conector::ejecutarQuery($sql, null);
            if (count($result) > 0) $typeUser = "Docente";
            else $typeUser = "Estudiante";
        };
        return $typeUser;
    }

    public static function getDataJSON($type, $field, $value, $filter, $order, $extras){
        $JSON = array();
        if ($type){
            if ($value != null){
                $object = new Usuario($field, $value, $filter, $order);
                foreach ($object as $item => $val) $JSON["$item"] = $val;
                if ($extras) $JSON['typeUser'] = $object->getTypeUser();
            }
        } else {
            //PENDIENTE CODIFICAR PARA CARGAR TODOS LOS USUARIOS EN JSON
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    /**
     * @version Se evalua a un usuario y su contraseña en la base de datos para determinar se este es igual o no.
     * @param $user : String
     * @param $password : String
     * @return bool : true = el usuario y la contraseña coinciden con la base de datos, false los datos no coinciden con
     * los existentes en la base de datos
     */
    public static function validUser($user, $password){
        $valid = false;
        $object = new Usuario('usuario', $user, null, 'limit 1');
        if ($object->getUsuario() != null){
            if ($object->getPassword() == md5($password)) $valid = true;
        }
        return $valid;
    }

    /**
     * @version Esta función permite insertar datos de los campos usuario, contrasena y estado de la tabla usuario.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function add(){
        $sql = "INSERT INTO usuario (usuario, contrasena, estado) VALUES ('{$this->usuario}', '{$this->password}', '{$this->estado}')";
        return Conector::executeAUD($sql);
    }

    /**
     * @version Esta función permite modificar datos de los campos usuario, contrasena y estado de la tabla
     * usuario apartir del id del registro u objeto que ya ha sido cargadp previamente.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function update($pastUser){
        $sql = "UPDATE usuario SET usuario = '{$this->usuario}', contrasena = '{$this->password}' WHERE usuario.usuario = '$pastUser'";
        return Conector::executeAUD($sql);
    }

    /**
     * @version Esta funcioón permite eliminar el registro que es filtrado por el id del objeto.
     * @return bool False significa que la sentencia no fue ejecutada, True corresponde a que la sentencia fue
     * ejecutada, esto no asegura que el registro haya sido actualizado.
     */
    public function delete(){
        $sql = "DELETE FROM usuario WHERE usuario.usuario = '{$this->usuario}'";
        return Conector::executeAUD($sql);
    }

}