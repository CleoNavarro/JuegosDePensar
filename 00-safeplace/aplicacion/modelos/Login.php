<?php
class Login extends CActiveRecord {

    protected function fijarNombre(): string {
        return 'login';
    }

    protected function fijarAtributos(): array {
        return array(
            "nick", "contrasenia"
        );
    }

    protected function fijarDescripciones(): array {
        return array(
            "nick" => "Usuario o email",
            "contrasenia" => "Contraseña"
        );
    }

    protected function fijarRestricciones(): array {
        return
            array(
                array(
                    "ATRI" => "nick,contrasenia",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "nick", 
                    "TIPO" => "CADENA",
                    "TAMANIO" => 100
                ),
                array(
                    "ATRI" => "contrasenia", 
                    "TIPO" => "CADENA",
                    "TAMANIO" => 40
                ),
                array(
                    "ATRI" => "contrasenia", 
                    "TIPO" => "FUNCION",
                    "FUNCION" => "verificarContrasenia",
                    "MENSAJE" => "Usuario o contraseña incorrectos"
                )
            );
    }

    protected function afterCreate(): void {
        $this->nick = "";
        $this->contrasenia = "";
    }

    public function compruebaMail () : bool {

        $nick = CGeneral::addSlashes($this->nick);

         if (CValidaciones::validaEMail($nick)) 
             return true;

        return false;
    }

    public function verificarContrasenia () : bool {

        $contrasenia = CGeneral::addSlashes($this->contrasenia);
        $nick = CGeneral::addSlashes($this->nick);

        if ($this->compruebaMail()) {
            $sentencia = "SELECT * from usuarios ".
            "WHERE mail = '$nick'; ";

            $consulta=Sistema::App()->BD()->crearConsulta($sentencia);
    
            $fila=$consulta->fila();

            if (is_null($fila))
                return false;
            
            $nick = $fila["nick"];
           
        }
        
        $sentencia = "SELECT * from acl_usuarios ".
                    "WHERE contrasenia = sha1('$contrasenia') ".
                    "AND nick = '$nick';";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);
    
        $filas=$consulta->filas();

        if (is_null($filas))
            return false;

        return true;


    }



}