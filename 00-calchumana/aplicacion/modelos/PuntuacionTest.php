<?php
class PuntuacionTest extends CActiveRecord {

    protected function fijarNombre(): string {
        return 'puntuacion_test';
    }

    protected function fijarTabla():string {
        return "vista_puntuacion_test";
    }
    
    protected function fijarId():string {
        return "cod_punt_test";
    }

    protected function fijarAtributos(): array {
        return array(
            "cod_punt_test", "cod_usuario", "cod_test", "puntos", 
            "fecha_realizado", "nombre",  "nick", "foto", "fecha", "titulo"
        );
    }

    protected function fijarDescripciones(): array {
        return array(
            "cod_punt_test" => "Código Puntuación Test", 
            "cod_usuario" => "Código Usuario", 
            "cod_test" => "Código Test", 
            "puntos" => "Puntuación", 
            "fecha_realizado" => "Fecha en la que se realizó el test", 
            "nombre" => "Realizado por",  
            "nick" => "Realizado por", 
            "foto" => "Foto", 
            "fecha" => "Fecha del test", 
            "titulo" => "Título del test"
        );
    }

    protected function fijarRestricciones(): array {
        return
            array(
                array(
                    "ATRI" => "cod_usuario,cod_test,puntos",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "cod_punt_test", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "cod_usuario", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "cod_test", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "puntos", "TIPO" => "ENTERO", "MIN" => 10
                )
            );
    }

    /**
     * Función que devuelve la puntuación de un test hecho por un usuario
     * @param integer $cod_test Código test
     * @param integer $cod_usuario Código usuario
     * @return mixed Devuelve la puntuación del test. False si no existe
     */
    public static function damePuntuacion (int $cod_test, int $cod_usuario) : mixed {

        $sentencia = "SELECT * from vista_puntuacion_test ".
        "where cod_test = $cod_test and cod_usuario = $cod_usuario";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);

        $filas=$consulta->filas();

        if (is_null($filas)) return false;

        $puntuacion = 10;

        foreach ($filas as $fila) {$puntuacion = intval($fila["puntos"]);}

        return $puntuacion;
    }

    protected function afterBuscar(): void {

        $fechaAux = $this->fecha_realizado;
        $fechaAux = CGeneral::fechahoraMysqlANormal($fechaAux);
        $this->fecha_realizado = $fechaAux;

        $fechaAux = $this->fecha;
        $fechaAux = CGeneral::fechaMysqlANormal($fechaAux);
        $this->fecha = $fechaAux;
   
    }

    function fijarSentenciaInsert(): string {

        $cod_usuario = intval($this->cod_usuario);
        $cod_test = intval($this->cod_test);
        $puntos = intval($this->puntos);
        
        $sentencia = "INSERT INTO puntuacion_test ". 
            "(cod_usuario, cod_test, puntos, fecha_realizado)". 
            " VALUES ($cod_usuario, $cod_test, $puntos, CURRENT_TIMESTAMP); ";

        return $sentencia;
    }

    function fijarSentenciaUpdate(): string {

        $cod_punt_test = intval($this->cod_punt_test);
        $cod_usuario = intval($this->cod_usuario);
        $cod_test = intval($this->cod_test);
        $puntos = intval($this->puntos);

        $sentencia = "UPDATE puntuacion_test ".
            "SET cod_usuario = $cod_usuario, cod_test = $cod_test, ".
            "puntos = $puntos, fecha_realizado = CURRENT_TIMESTAMP ".
            "WHERE cod_punt_test = $cod_punt_test;";
     
        return $sentencia;
    }

}