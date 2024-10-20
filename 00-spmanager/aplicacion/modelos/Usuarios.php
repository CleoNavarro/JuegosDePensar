<?php
class Usuarios extends CActiveRecord {

    protected function fijarNombre(): string {
        return 'usuarios';
    }

    protected function fijarTabla():string {
        return "usuarios";
    }
    
    protected function fijarId():string {
        return "cod_usuario";
    }

    protected function fijarAtributos(): array {
        return array(
            "cod_usuario", "nombre", "nick", "contrasenia", 
            "repite_contrasenia" ,"descripcion", "mail", 
            "telefono", "pronombres", "foto", "fecha_registrado", 
            "verificado", "borrado", "cod_acl_role"
        );
    }

    protected function fijarDescripciones(): array {
        return array(
            "cod_usuario" => "Código Usuario", 
            "nombre" => "Nombre",
            "nick" => "Nick", 
            "contrasenia" => "Contraseña",
            "repite_contrasenia" => "Repite Contraseña",
            "descripcion" => "Sobre mí",
            "mail" => "Mail", 
            "telefono" => "Teléfono", 
            "pronombres" => "Tratamiento (pronombres)",
            "foto" => "Foto",
            "fecha_registrado" => "Fecha de registro",
            "verificado" => "Usuario Verificado",
            "borrado" => "Usuario Borrado",
            "cod_acl_role" => "Asignar rol"
        );
    }

    protected function fijarRestricciones(): array {
        return
            array(
                array(
                    "ATRI" => "nombre,nick,contrasenia,mail,telefono",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "cod_usuario", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "nombre", "TIPO" => "CADENA", "TAMANIO" => 255
                ),
                array(
                    "ATRI" => "nick", "TIPO" => "CADENA", "TAMANIO" => 100
                ),
                array(
                    "ATRI" => "nick", "TIPO" => "FUNCION",
                    "FUNCION" => "nickNoExiste",
                    "MENSAJE" => "Ya hay un usuario registrado con este nick"
                ),
                array(
                    "ATRI" => "contrasenia", "TIPO" => "CADENA", "TAMANIO" => 50
                ),
                array(
                    "ATRI" => "repite_contrasenia", "TIPO" => "CADENA", "TAMANIO" => 50
                ),
                array(
                    "ATRI" => "repite_contrasenia", "TIPO" => "FUNCION",
                    "FUNCION" => "validarContrasenia",
                    "MENSAJE" => "Las contraseñas deben ser idénticas"
                ),
                array(
                    "ATRI" => "descripcion", "TIPO" => "CADENA", "TAMANIO" => 400
                ),
                array(
                    "ATRI" => "mail", "TIPO" => "CADENA", "TAMANIO" => 255
                ),
                array(
                    "ATRI" => "mail", "TIPO" => "FUNCION",
                    "FUNCION" => "validarMail",
                    "MENSAJE" => "No es un mail válido"
                ),
                array(
                    "ATRI" => "telefono",  "TIPO" => "CADENA", "TAMANIO" => 15
                ),
                array(
                    "ATRI" => "pronombres",  "TIPO" => "ENTERO", "MIN" => 0,
                    "DEFECTO" => 0
                ),
                array(
                    "ATRI" => "pronombres", "TIPO" => "RANGO",
                    "RANGO" => array_keys(Usuarios::damePronombres()),
                    "MENSAJE" => "Pronombre no existente"
                ),
                array(
                    "ATRI" => "foto", "TIPO" => "CADENA", "TAMANIO" => 255
                ),
                array( 
                    "ATRI" => "fecha", "TIPO" => "FECHA"
                ),
                array(
                    "ATRI" => "verificado", "TIPO" => "ENTERO",
                    "RANGO" => [0, 1], "DEFECTO" => 0
                ),
                array(
                    "ATRI" => "borrado", "TIPO" => "ENTERO",
                    "RANGO" => [0, 1], "DEFECTO" => 0
                ),
                array(
                    "ATRI" => "cod_acl_role",  "TIPO" => "ENTERO", "MIN" => 0,
                    "DEFECTO" => 2
                ),
                array(
                    "ATRI" => "cod_acl_role", "TIPO" => "RANGO",
                    "RANGO" => array_keys(Usuarios::dameRoles()),
                    "MENSAJE" => "Rol no existente"
                ),


            );
    }

    protected function afterCreate(): void {
        
        $this->cod_usuario = 0;
        $this->nombre = "";
        $this->nick = "";
        $this->contrasenia = "";
        $this->repetir_contrasenia = "";
        $this->descripcion = "";
        $this->mail = "";
        $this->telefono = "";
        $this->pronombres = 0;
        $this->foto = "fotoUsuarioPorDefecto.png";
        $this->verificado = 0;
        $this->borrado = 0;
        $this->cod_acl_role = 2;
    }

    /**
     * Undocumented function
     *
     * @param integer|null $cod_usu
     * @return mixed
     */
    public static function dameUsuarios(?int $cod_usu = null) : mixed {

        $sentencia = "SELECT * from usuarios";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);
    
        $filas=$consulta->filas();

        if (is_null($filas))
            return false;

        $usuarios = [];

        foreach ($filas as $fila) {
            $usuarios[intval($fila["cod_usuario"])] = $fila;
        }

        if ($cod_usu === null)
            return $usuarios;
        else {
            if (isset($usuarios[$cod_usu]))
                return $usuarios[$cod_usu];
            else
                return false;
        }
    }

    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function nickNoExiste () : bool {

        $arrayUsuarios = Usuarios::dameUsuarios();

        foreach ($arrayUsuarios as $clave=>$valor) {
            if ($clave!=$this->cod_cliente && $valor["nick"] == $this->nick)
                return false;
        }

        return true;
        
        
    }

    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function validarContrasenia () :bool {
        if ($this->contrasenia == $this->repetir_contrasenia)
            return true;

        return false;
    }


    /**
     * Undocumented function
     *
     * @return bool
     */
    public function validarMail () : bool {
        $mail = $this->mail;
        return CValidaciones::validaEMail($mail);
    }


        /**
     * Undocumented function
     *
     * @param integer|null $cod_pro
     * @return mixed
     */
    public static function damePronombres(?int $cod_pro = null) : mixed {

        $pronombres = array(
            0 => "No especificar",
            1 => "She/Her",
            2 => "He/Him",
            3 => "They/Them",
            4 => "She/They",
            5 => "He/They",
            6 => "All/Any"
        );

        if ($cod_pro === null)
            return $pronombres;
        else {
            if (isset($pronombres[$cod_pro]))
                return $pronombres[$cod_pro];
            else
                return false;
        }
    }

    /**
     * Undocumented function
     *
     * @param integer|null $cod_rol
     * @return mixed
     */
    public static function dameRoles(?int $cod_rol = null) : mixed {

        $sentencia = "SELECT * from acl_roles";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);
    
        $filas=$consulta->filas();

        if (is_null($filas))
            return false;

        $roles = [];

        foreach ($filas as $fila) {
            $roles[intval($fila["cod_acl_role"])] = $fila;
        }

        if ($cod_rol === null)
            return $roles;
        else {
            if (isset($roles[$cod_rol]))
                return $roles[$cod_rol];
            else
                return false;
        }
    }

    
    protected function afterBuscar(): void {

        $fecha = $this->fecha_registrado;
        $fecha = CGeneral::fechahoraMysqlANormal($fecha);
        $this->fecha_registrado = $fecha;

    }


    
    /**
     * 
     */
    function fijarSentenciaInsert(): string {

        $nombre = CGeneral::addSlashes($this->nombre);
        $nick = CGeneral::addSlashes($this->nick);
        $contrasenia = CGeneral::addSlashes($this->contrasenia);
        $mail = CGeneral::addSlashes($this->mail);
        $telefono = CGeneral::addSlashes($this->telefono);
        $pronombres = Usuarios::damePronombres(intval($this->pronombres));

        $sentencia = "INSERT INTO usuarios ". 
            "(nombre, nick, descripcion, mail, telefono, pronombres, ".
            "foto, fecha_registrado, verificado, borrado)". 
            " VALUES ('$nombre', '$nick', '', '$mail', ".
            "'$telefono', '$pronombres', 'fotoUsuarioPorDefecto.png', ".
            "CURRENT_TIMESTAMP, 0, 0); ".

            "INSERT INTO acl_usuarios ". 
            "(nick, nombre, contrasenia, cod_acl_role, borrado)".
            " VALUES ('$nick', '$nombre', sha1('$contrasenia'), ".
            "2, 0);";

        return $sentencia;
    }

    function fijarSentenciaUpdate(): string {

        $cod_usuario = intval($this->cod_usuario);
        $nombre = CGeneral::addSlashes($this->nombre);
        $nick = CGeneral::addSlashes($this->nick);
        $contrasenia = CGeneral::addSlashes($this->contrasenia);
        $descripcion = CGeneral::addSlashes($this->descripcion);
        $mail = CGeneral::addSlashes($this->mail);
        $telefono = CGeneral::addSlashes($this->telefono);
        $pronombres = Usuarios::damePronombres(intval($this->pronombres));
        $foto = CGeneral::addSlashes($this->foto);
        $verificado = intval($this->verificado);
        $borrado = intval($this->borrado);
        $cod_acl_role = intval($this->cod_acl_role);


        $sentencia = "UPDATE usuarios ".
            "SET nombre = '$nombre', ".
            "nick = '$nick', ".
            "descripcion = '$descripcion', ".
            "mail = '$mail', ".
            "telefono = '$telefono', ".
            "pronombres = '$pronombres', ".
            "foto = '$foto', ".
            "verificado = $verificado, ".
            "borrado = $borrado ".
            "WHERE cod_usuario = $cod_usuario; ".

            "UPDATE acl_usuarios ".
            "SET nombre = '$nombre', ".
            "nick = '$nick', ".
            "contrasenia = sha1('$contrasenia'), ".
            "cod_acl_role = $cod_acl_role, ".
            "borrado = $borrado ".
            "WHERE cod_acl_usuario = $cod_usuario;";
     
        return $sentencia;
    }
}