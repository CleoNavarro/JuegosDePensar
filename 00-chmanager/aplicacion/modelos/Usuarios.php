<?php
class Usuarios extends CActiveRecord {

    protected function fijarNombre(): string {
        return 'usuarios';
    }

    protected function fijarTabla():string {
        return "vista_usuarios";
    }
    
    protected function fijarId():string {
        return "cod_usuario";
    }

    protected function fijarAtributos(): array {
        return array(
            "cod_usuario", "nombre", "nick", "contrasenia", 
            "repite_contrasenia" , "mail", "telefono", "foto", 
            "fecha_registrado", "verificado", "borrado", "borrado_fecha", 
            "borrado_por", "cod_usuario_borrador", "nick_borrador", "cod_acl_role",
            "nombre_rol"
        );
    }

    protected function fijarDescripciones(): array {
        return array(
            "cod_usuario" => "Código Usuario", 
            "nombre" => "Nombre",
            "nick" => "Nick", 
            "contrasenia" => "Contraseña",
            "repite_contrasenia" => "Repite Contraseña",
            "mail" => "Mail", 
            "telefono" => "Teléfono", 
            "foto" => "Foto",
            "fecha_registrado" => "Fecha de registro",
            "verificado" => "Usuario Verificado",
            "borrado" => "Usuario Borrado",
            "borrado_fecha" => "Fecha del Borrado",
            "borrado_por" => "Borrado por",
            "cod_usuario_borrador" => "Código Usuario Borrador", 
            "nick_borrador" => "Nick borrador", 
            "cod_acl_role" => "Asignar rol",
            "nombre_rol" => "Rol"
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
                    "ATRI" => "foto", "TIPO" => "CADENA", "TAMANIO" => 255
                )
                
            );
    }

    protected function afterCreate(): void {
        
        $this->cod_usuario = 0;
        $this->nombre = "";
        $this->nick = "";
        $this->contrasenia = "";
        $this->repetir_contrasenia = "";
        $this->mail = "";
        $this->telefono = "";
        $this->foto = "fotoUsuarioPorDefecto.png";
        $this->verificado = 0;
        $this->borrado = 0;
        $this->borrado_por = 0;
        $this->cod_acl_role = 2;
    }

    /**
     * Devuelve la lista de usuarios, o los datos del usuario seleccionado
     *
     * @param integer|null $cod_usu Código Usuario
     * @return mixed Datos del usuario o los usuarios. False en caso de que no haya o no exista
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
     * Función que devuelve los roles disponibles, o el rol que buscamos
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

     /**
     * Devuelve los roles disponibles para un drop down
     * @return mixed Array con los roles disponibles. False su falla
     */
    public static function dameRolesDrop() : mixed {

        $arrayRoles = Usuarios::dameRoles();

        $arraDrop = [];

        foreach ($arrayRoles as $fila) {
            $arraDrop[intval($fila["cod_acl_role"])] = $fila["nombre"];
        }

        return $arraDrop;
    }

    /**
     * Función para borrar un usuario. Le asigna fecha de borrado y el código de quien lo ha hecho
     */
    public static function borrarUsuario(int $cod_usuario, int $cod_borrador) : bool {

        $sentencia = "UPDATE acl_usuarios ".
            "SET borrado = 1, ".
            "borrado_fecha = CURRENT_TIMESTAMP, ".
            "borrado_por = $cod_borrador ".
            "WHERE cod_acl_usuario = $cod_usuario;";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);

        if ($consulta->error())
            return false;

        $sentencia = "UPDATE usuarios ".
            "SET borrado = 1, ".
            "borrado_fecha = CURRENT_TIMESTAMP, ".
            "borrado_por = $cod_borrador ".
            "WHERE cod_usuario = $cod_usuario;";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);

        if ($consulta->error())
            return false;

        return true;

    }

    /**
     * Función para recuperar un usuario. Borra los datos de quien lo borró
     */
    public static function recuperarUsuario(int $cod_usuario) : bool {

        $sentencia = "UPDATE acl_usuarios ".
            "SET borrado = 0, ".
            "borrado_fecha = NULL, ".
            "borrado_por = 0 ".
            "WHERE cod_acl_usuario = $cod_usuario;";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);

        if ($consulta->error())
            return false;

        $sentencia = "UPDATE usuarios ".
            "SET borrado = 0, ".
            "borrado_fecha = NULL, ".
            "borrado_por = 0 ".
            "WHERE cod_usuario = $cod_usuario;";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);

        if ($consulta->error())
            return false;

        return true;
    }

    
    protected function afterBuscar(): void {

        $fecha = $this->fecha_registrado;
        $fecha = CGeneral::fechahoraMysqlANormal($fecha);
        $this->fecha_registrado = $fecha;

        if (!is_null($this->verificado)) {
            $fecha = $this->verificado;
            $fecha = CGeneral::fechahoraMysqlANormal($fecha);
            $this->verificado = $fecha;
        }

        if ($this->borrado == 1) {
            $fecha = $this->borrado_fecha;
            $fecha = CGeneral::fechahoraMysqlANormal($fecha);
            $this->borrado_fecha = $fecha;
        }

    }
    
    function fijarSentenciaInsert(): string {

        $nombre = CGeneral::addSlashes($this->nombre);
        $nick = CGeneral::addSlashes($this->nick);
        $mail = CGeneral::addSlashes($this->mail);
        $telefono = CGeneral::addSlashes($this->telefono);
        $foto = CGeneral::addSlashes($this->foto);

        $sentencia = "INSERT INTO usuarios ". 
            "(nombre, nick, mail, telefono, foto, ".
            "fecha_registrado, verificado, borrado, borrado_fecha, borrado_por)". 
            " VALUES ('$nombre', '$nick', '$mail', '$telefono', '$foto', ".
            "CURRENT_TIMESTAMP, NULL, 0, NULL, 0); ";

        return $sentencia;
    }

    function fijarSentenciaUpdate(): string {

        $cod_usuario = intval($this->cod_usuario);
        $nombre = CGeneral::addSlashes($this->nombre);
        $nick = CGeneral::addSlashes($this->nick);
        $mail = CGeneral::addSlashes($this->mail);
        $telefono = CGeneral::addSlashes($this->telefono);
        $foto = CGeneral::addSlashes($this->foto);

        $sentencia = "UPDATE usuarios ".
            "SET nombre = '$nombre', ".
            "nick = '$nick', ".
            "mail = '$mail', ".
            "telefono = '$telefono', ".
            "foto = '$foto', ".
            "WHERE cod_usuario = $cod_usuario; ";
     
        return $sentencia;
    }

}