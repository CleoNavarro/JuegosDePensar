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

     /**
     * Devuelve las dificultades disponibles, o la dificultad seleccionada
     *
     * @param integer|null $cod_dificultad
     * @return mixed Array con las dificultades disponibles, o con la seleccionada. False su falla
     */
    public static function dameDificultad(?int $cod_dificultad = null) : mixed {

        $sentencia = "SELECT * from dificultad";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);
    
        $filas=$consulta->filas();

        if (is_null($filas))
            return false;

        $dificultades = [];

        foreach ($filas as $fila) {
            $dificultades[intval($fila["cod_dificultad"])] = $fila;
        }

        if ($cod_dificultad === null)
            return $dificultades;
        else {
            if (isset($dificultades[$cod_dificultad]))
                return $dificultades[$cod_dificultad];
            else
                return false;
        }
    }


     /**
     * Devuelve las dificultades disponibles para un drop down
     * @return mixed Array con las dificultades disponibles. False su falla
     */
    public static function dameDificultadDrop() : mixed {

        $arrayDificultad = Test::dameDificultad();

        $arraDrop = [];

        foreach ($arrayDificultad as $fila) {
            $arraDrop[intval($fila["cod_dificultad"])] = $fila["dificultad"];
        }

        return $arraDrop;
    }

    /**
     * Devuelve los tipos de preguntas disponibles, o el tipo seleccionado
     *
     * @param integer|null $cod_tipo
     * @return mixed Array con los tipos disponibles, o con el seleccionado. False si falla
     */
    public static function dameTipo(?int $cod_tipo = null) : mixed {

        $sentencia = "SELECT * from tipos";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);
    
        $filas=$consulta->filas();

        if (is_null($filas))
            return false;

        $tipos = [];

        foreach ($filas as $fila) {
            $tipos[intval($fila["cod_tipo"])] = $fila["tipo"];
        }

        if ($cod_tipo === null)
            return $tipos;
        else {
            if (isset($tipos[$cod_tipo]))
                return $tipos[$cod_tipo];
            else
                return false;
        }
    }


     /**
     * Función para borrar un test. Le asigna fecha de borrado y el código de quien lo ha hecho
     */
    public static function borrarTest(int $cod_test, int $cod_borrador) : bool {

        $sentencia = "UPDATE test ".
            "SET borrado_fecha = CURRENT_TIMESTAMP, ".
            "borrado_por = $cod_borrador ".
            "WHERE cod_test = $cod_test;";

            $consulta=Sistema::App()->BD()->crearConsulta($sentencia);

            if ($consulta->error())
                return false;

            return true;
    }

    /**
     * Función para recuperar un test. Borra los datos de quien lo borró
     */
    public static function recuperarTest(int $cod_test) : bool {

        $sentencia = "UPDATE test ".
            "SET borrado_fecha = NULL, ".
            "borrado_por = 0 ".
            "WHERE cod_test = $cod_test;";

            $consulta=Sistema::App()->BD()->crearConsulta($sentencia);

            if ($consulta->error())
                return false;

            return true;
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