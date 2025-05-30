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

    /**
     * Comprueba si el nick introducido es un mail
     * @return bool True si es un mail
     */
    public function compruebaMail () : bool {

        $nick = CGeneral::addSlashes($this->nick);

         if (CValidaciones::validaEMail($nick)) 
             return true;

        return false;
    }

    /**
     * Verifica si los los datos de usuario existen y se puede hacer login
     */
    public function verificarContrasenia () : void {

        $contrasenia = CGeneral::addSlashes($this->contrasenia);
        $nick = CGeneral::addSlashes($this->nick);
        $valido = true;
        $error = false;

        if ($this->compruebaMail()) {
            $sentencia = "SELECT * from usuarios ".
            "WHERE mail = '$nick'; ";

            $consulta=Sistema::App()->BD()->crearConsulta($sentencia);
    
            $filas=$consulta->filas();

            if (is_null($filas)|| count($filas)==0) $valido = false;

            if (count($filas)>1) $error = true;
            
            foreach ($filas as $fila) {
                $nick = $fila["nick"];
                $this->nick = $nick;
            }
        }
        
        $sentencia = "SELECT * from acl_usuarios ".
                    "WHERE contrasenia = sha1('$contrasenia') ".
                    "AND nick = '$nick';";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);
    
        $filas=$consulta->filas();

        if (is_null($filas) || count($filas)==0)
            $valido = false;

        if (!$valido) 
            $this->setError("nick", "Usuario o contraseña incorrectos");

        if ($error) 
            $this->setError("nick", "Usuario o contraseña incorrectos");    

    }



}