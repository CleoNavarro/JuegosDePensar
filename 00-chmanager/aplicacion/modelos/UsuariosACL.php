<?php
class UsuariosACL extends CActiveRecord {

    protected function fijarNombre(): string {
        return 'acl_usuarios';
    }

    protected function fijarTabla():string {
        return "acl_usuarios";
    }
    
    protected function fijarId():string {
        return "cod_acl_usuario";
    }

    protected function fijarAtributos(): array {
        return array(
            "cod_acl_usuario", "nick", "nombre", "contrasenia", "cod_acl_role",
            "borrado", "borrado_fecha", "borrado_por"
        );
    }

    protected function fijarDescripciones(): array {
        return array(
            "cod_acl_usuario" => "Código Usuario", 
            "nick" => "Nick", 
            "nombre" => "Nombre",
            "contrasenia" => "Contraseña",
            "cod_acl_role" => "Asignar rol",
            "borrado" => "Usuario Borrado",
            "borrado_fecha" => "Fecha del Borrado",
            "borrado_por" => "Borrado por"
        );
    }

    protected function fijarRestricciones(): array {
        return
            array(
                array(
                    "ATRI" => "nick,nombre,contrasenia",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "cod_acl_usuario", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "nombre", "TIPO" => "CADENA", "TAMANIO" => 255
                ),
                array(
                    "ATRI" => "nick", "TIPO" => "CADENA", "TAMANIO" => 100
                ),
                array(
                    "ATRI" => "contrasenia", "TIPO" => "CADENA", "TAMANIO" => 50
                )
                
            );
    }

     /**
     * Devuelve el rol del usuario, junto con sus permiso
     */
    public static function damePermisosUsuario (int $cod_usu) : mixed {

        $usuario = Usuarios::dameUsuarios($cod_usu);
        $rol = false;

        if ($usuario) {
            $rol = Usuarios::dameRoles($usuario["cod_acl_role"]);
        } 

        return $rol;
    }

    private function quiereCambiarContrasenia () :bool {

        $sentencia = "SELECT * from acl_usuarios where contrasenia = '".$this->contrasenia."'";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);
    
        $filas=$consulta->filas();

        if (is_null($filas) || count($filas)==0)
            return true;

        return false;

    }

    protected function afterCreate(): void {
        
        $this->cod_acl_usuario = 0;
        $this->nombre = "";
        $this->nick = "";
        $this->contrasenia = "";
        $this->borrado = 0;
        $this->borrado_fecha = null;
        $this->borrado_por = 0;
        $this->cod_acl_role = 2;
    }

    
    protected function afterBuscar(): void {

        if ($this->borrado == 1) {
            $fecha = $this->borrado_fecha;
            $fecha = CGeneral::fechahoraMysqlANormal($fecha);
            $this->borrado_fecha = $fecha;
        }

    }


    function fijarSentenciaInsert(): string {

        $nick = CGeneral::addSlashes($this->nick);
        $nombre = CGeneral::addSlashes($this->nombre);
        $contrasenia = CGeneral::addSlashes($this->contrasenia);
        $cod_acl_role = intval($this->cod_acl_role);

        $sentencia = "INSERT INTO acl_usuarios ". 
            "(nick, nombre, contrasenia, cod_acl_role, borrado, borrado_fecha, borrado_por)".
            " VALUES ('$nick', '$nombre', sha1('$contrasenia'), ".
            " $cod_acl_role, 0, NULL, 0);";

        return $sentencia;
    }

    function fijarSentenciaUpdate(): string {

        $cod_acl_usuario = intval($this->cod_acl_usuario);
        $nombre = CGeneral::addSlashes($this->nombre);
        $nick = CGeneral::addSlashes($this->nick);
        $cambiarContra = $this->quiereCambiarContrasenia();
        $contrasenia = CGeneral::addSlashes($this->contrasenia);
        $cod_acl_role = intval($this->cod_acl_role);


        $sentencia = "UPDATE acl_usuarios ".
            "SET nombre = '$nombre', ".
            "nick = '$nick', ";

        if ($cambiarContra)
        $sentencia .= "contrasenia = sha1('$contrasenia'), ";

        $sentencia .="cod_acl_role = $cod_acl_role ".
            "WHERE cod_acl_usuario = $cod_acl_usuario;";
     
        return $sentencia;
    }
}