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
            "cod_test", "fecha", "cod_dificultad", "titulo", "puntuacion_base", "dificultad", "num_preguntas",
            "creado_fecha", "creado_por", "autor", "borrado_fecha", "borrado_por", "borrador"
        );
    }

    protected function fijarDescripciones(): array {
        return array(
            "cod_test" => "Código Test", 
            "fecha" => "Fecha", 
            "cod_dificultad" => "Dificultad", 
            "titulo" => "Título",
            "puntuacion_base" => "Puntuación_base",
            "dificultad" => "Dificultad", 
            "num_preguntas" => "Nº preguntas",
            "creado_fecha" => "Fecha de creación",
            "creado_por" => "Autor",
            "autor" => "Autor",
            "borrado_fecha" => "Fecha de borrado",
            "borrado_por" => "Borrado por",
            "borrador" => "Borrado por",
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
                    "ATRI" => "fecha", "TIPO" => "FECHA", "DEFECTO" => date("d/m/Y")
                ),
                array(
                    "ATRI" => "cod_dificultad", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "titulo", "TIPO" => "CADENA", "TAMANIO" => 255
                ), 
                array(
                    "ATRI" => "borrado", "TIPO" => "ENTERO", "RANGO" => [0, 1], "DEFECTO" => 0
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

        if (is_null($filas) || count($filas)==0) return false;

        $test = [];

        foreach ($filas as $fila) {$test[intval($fila["cod_test"])] = $fila;}

        return $test;
    }

     /**
     * Devuelve el test que hay según qué fecha
     *
     * @param string|null $fecha Fecha. Por defecto, la fecha de hoy
     * @return mixed Array con test y sus datos. False si no existe ese test
     */
    public static function dameTestPorFecha(?string $fecha = null) : mixed {

        if (is_null($fecha)) $fecha = date("d/M/Y");

        $sentencia = "SELECT * from vista_test where fecha = '".
        CGeneral::fechaNormalAMysql($fecha)."' AND borrado_fecha is NULL ".
        "ORDER BY creado_fecha ASC;";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);
    
        $filas=$consulta->filas();

        if (is_null($filas) || count($filas)==0) return false;

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

        if (is_null($filas) || count($filas)==0) return false;

        $preguntas = [];

        foreach ($filas as $fila) {$preguntas[intval($fila["orden"])] = $fila;}

        return $preguntas;
    }
   

    protected function afterBuscar(): void {

        $fechaAux = $this->fecha;
        $fechaAux = CGeneral::fechaMysqlANormal($fechaAux);
        $this->fecha = $fechaAux;

        if (!is_null($this->fecha_borrado)) {
            $fechaAux = $this->fecha_borrado;
            $fechaAux = CGeneral::fechahoraMysqlANormal($fechaAux);
            $this->fecha_borrado = $fechaAux;
        }
   
    }

    function fijarSentenciaInsert(): string {

        $fecha =  CGeneral::fechaNormalAMysql($this->fecha);
        $cod_dificultad = intval($this->cod_dificultad);
        $titulo = CGeneral::addSlashes($this->titulo);
        $puntuacion_base = intval($this->puntuacion_base);
        $creado_por = intval($this->creado_por);
        
        $sentencia = "INSERT INTO test ". 
            "(fecha, cod_dificultad, titulo, puntuacion_base, creado_fecha, creado_por)". 
            " VALUES ('$fecha', $cod_dificultad, '$titulo', $puntuacion_base, CURRENT_TIMESTAMP, $creado_por); ";

        return $sentencia;
    }

    function fijarSentenciaUpdate(): string {

        $cod_test = intval($this->cod_test);
        $fecha =  CGeneral::fechaNormalAMysql($this->fecha);
        $cod_dificultad = intval($this->cod_dificultad);
        $titulo = CGeneral::addSlashes($this->titulo);
        $puntuacion_base = intval($this->puntuacion_base);

        $sentencia = "UPDATE test ".
            "SET fecha = '$fecha', cod_dificultad = $cod_dificultad, ".
            "titulo = '$titulo', puntuacion_base = $puntuacion_base ".
            "WHERE cod_test = $cod_test;";
     
        return $sentencia;
    }


}