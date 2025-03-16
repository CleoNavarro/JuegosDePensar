<?php
class Test extends CActiveRecord {

    protected function fijarNombre(): string {
        return 'test';
    }

    protected function fijarTabla():string {
        return "vista_test";
    }
    
    protected function fijarId():string {
        return "cod_test";
    }

    protected function fijarAtributos(): array {
        return array(
            "cod_test", "fecha", "cod_dificultad",
            "titulo", "dificultad", "num_preguntas"
        );
    }

    protected function fijarDescripciones(): array {
        return array(
            "cod_test" => "Código Test", 
            "fecha" => "Fecha", 
            "cod_dificultad" => "Dificultad", 
            "titulo" => "Título",
            "dificultad" => "Dificultad", 
            "num_preguntas" => "Nº preguntas"
        );
    }

    protected function fijarRestricciones(): array {
        return
            array(
                array(
                    "ATRI" => "cod_dificultad,titulo",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "cod_test", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array( 
                    "ATRI" => "fecha", "TIPO" => "FECHA", "DEFECTO" => date("d/m/Y")
                ),
                array(
                    "ATRI" => "cod_dificultad", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "titulo", "TIPO" => "CADENA", "TAMANIO" => 255
                )  
            );
    }

    /**
     * Devuelve los test que existen, o el que seleccionaste
     *
     * @param integer|null $cod_test Código test
     * @return mixed Array con test y sus datos. False si no existe ese test
     */
    public static function dameTest(?int $cod_test = null) : mixed {

        $sentencia = "SELECT * from vista_test ";

        if (!is_null($cod_test)) $sentencia .= "where cod_test = $cod_test ";

        $sentencia .= ";";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);
    
        $filas=$consulta->filas();

        if (is_null($filas)) return false;

        $test = [];

        foreach ($filas as $fila) {$test[intval($fila["cod_test"])] = $fila;}

        return $test;
    }

     /**
     * Devuelve el test que hay según qué fecha
     *
     * @param string|null $cod_test Fecha. Por defecto, la fecha de hoy
     * @return mixed Array con test y sus datos. False si no existe ese test
     */
    public static function dameTestPorFecha(?string $fecha = null) : mixed {

        if (is_null($fecha)) $fecha = date("d/M/Y");

        $sentencia = "SELECT * from vista_test where fecha = '".
        CGeneral::fechaNormalAMysql($fecha)."';";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);
    
        $filas=$consulta->filas();

        if (is_null($filas)) return false;

        $test = [];

        foreach ($filas as $fila) {$test = $fila;}

        return $test;
    }


    /**
     * Devuelve las preguntas que contiene un test
     *
     * @param integer $cod_test Código test
     * @return mixed Array con preguntas y su contenido. False si no hay preguntas
     */
    public static function damePreguntas(int $cod_test) : mixed {

        $sentencia = "SELECT * from vista_pregunta ".
                    "where cod_test = $cod_test ".
                    "order by orden asc;";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);
    
        $filas=$consulta->filas();

        if (is_null($filas)) return false;

        $preguntas = [];

        foreach ($filas as $fila) {$preguntas[intval($fila["orden"])] = $fila;}

        return $preguntas;
    }


    protected function afterBuscar(): void {

        $fechaAux = $this->fecha;
        $fechaAux = CGeneral::fechaMysqlANormal($fechaAux);
        $this->fecha = $fechaAux;
   
    }

    function fijarSentenciaInsert(): string {

        $fecha =  CGeneral::fechaNormalAMysql($this->fecha);
        $cod_dificultad = intval($this->cod_dificultad);
        $titulo = CGeneral::addSlashes($this->titulo);
        
        $sentencia = "INSERT INTO test ". 
            "(fecha, cod_dificultad, titulo)". 
            " VALUES ('$fecha', $cod_dificultad, '$titulo'); ";

        return $sentencia;
    }

    function fijarSentenciaUpdate(): string {

        $cod_test = intval($this->cod_test);
        $fecha =  CGeneral::fechaNormalAMysql($this->fecha);
        $cod_dificultad = intval($this->cod_dificultad);
        $titulo = CGeneral::addSlashes($this->titulo);

        $sentencia = "UPDATE test ".
            "SET fecha = '$fecha', cod_dificultad = $cod_dificultad, ".
            "titulo = '$titulo', ".
            "WHERE cod_test = $cod_test;";
     
        return $sentencia;
    }

}