<?php
class Adivina extends CActiveRecord {

    protected function fijarNombre(): string {
        return 'adivina';
    }

    protected function fijarTabla():string {
        return "vista_adivina";
    }
    
    protected function fijarId():string {
        return "cod_adivina";
    }

    protected function fijarAtributos(): array {
        return array(
            "cod_adivina", "fecha", "cod_dificultad", "titulo", "puntuacion_base", "dificultad", "num_palabras",
            "creado_fecha", "creado_por", "autor", "borrado_fecha", "borrado_por", "borrador"
        );
    }

    protected function fijarDescripciones(): array {
        return array(
            "cod_adivina" => "Código Adivina", 
            "fecha" => "Fecha", 
            "cod_dificultad" => "Dificultad", 
            "titulo" => "Título",
            "puntuacion_base" => "Puntuación base",
            "dificultad" => "Dificultad", 
            "num_palabras" => "Nº palabras",
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
     * Devuelve los Adivina que existen, o el que seleccionaste
     *
     * @param integer|null $cod_adiv Código Adivina
     * @return mixed Array con Adivina y sus datos. False si no existe ese Adivina
     */
    public static function dameAdivina(?int $cod_adiv = null) : mixed {

        $sentencia = "SELECT * from vista_adivina ";

        if (!is_null($cod_adiv)) $sentencia .= "where cod_adivina = $cod_adiv ";

        $sentencia .= ";";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);
    
        $filas=$consulta->filas();

        if (is_null($filas) || count($filas)==0) return false;

        $adiv = [];

        foreach ($filas as $fila) {$adiv[intval($fila["cod_adivina"])] = $fila;}

        return $adiv;
    }

     /**
     * Devuelve el Adivina que hay según qué fecha
     *
     * @param string|null $fecha Fecha. Por defecto, la fecha de hoy
     * @return mixed Array con Adivina y sus datos. False si no existe ese test
     */
    public static function dameAdivinaPorFecha(?string $fecha = null) : mixed {

        if (is_null($fecha)) $fecha = date("d/M/Y");

        $sentencia = "SELECT * from vista_adivina where fecha = '".
        CGeneral::fechaNormalAMysql($fecha)."' AND borrado_fecha is NULL ".
        "ORDER BY creado_fecha ASC;";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);
    
        $filas=$consulta->filas();

        if (is_null($filas) || count($filas)==0) return false;

        $adiv = [];

        foreach ($filas as $fila) {$adiv = $fila;}

        return $adiv;
    }


    /**
     * Devuelve las palabras que contiene un Adivina
     *
     * @param integer $cod_adiv Código Adivina
     * @return mixed Array con palabras y su contenido. False si no hay palabras
     */
    public static function damePalabras(int $cod_adiv) : mixed {

        $sentencia = "SELECT * from vista_palabras ".
                    "where cod_adivina = $cod_adiv ".
                    "order by orden asc;";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);
    
        $filas=$consulta->filas();

        if (is_null($filas) || count($filas)==0) return false;

        $palabras = [];

        foreach ($filas as $fila) {$palabras[intval($fila["orden"])] = $fila;}

        return $palabras;
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
     * Función para borrar un Adivina. Le asigna fecha de borrado y el código de quien lo ha hecho
     */
    public static function borrarAdivina(int $cod_adiv, int $cod_borrador) : bool {

        $sentencia = "UPDATE adivina ".
            "SET borrado_fecha = CURRENT_TIMESTAMP, ".
            "borrado_por = $cod_borrador ".
            "WHERE cod_adivina = $cod_adiv;";

            $consulta=Sistema::App()->BD()->crearConsulta($sentencia);

            if ($consulta->error())
                return false;

            return true;
    }

    /**
     * Función para recuperar un Adivina. Borra los datos de quien lo borró
     */
    public static function recuperarAdivina(int $cod_adiv) : bool {

        $sentencia = "UPDATE adivina ".
            "SET borrado_fecha = NULL, ".
            "borrado_por = 0 ".
            "WHERE cod_adivina = $cod_adiv;";

            $consulta=Sistema::App()->BD()->crearConsulta($sentencia);

            if ($consulta->error())
                return false;

            return true;
    }

     /**
     * Función para borrar todas las preguntas de un juego adivina.
     * Esta función pertenece al proceso de actualizar los datos del juego
     */
    public static function borrarPalabras (int $cod_adiv) : bool {

        $sentencia = "DELETE from palabras ".
            "WHERE cod_adivina = $cod_adiv;";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);

        if ($consulta->error())
            return false;

        return true;

    }
   

    protected function afterBuscar(): void {

        $fechaAux = $this->fecha;
        $fechaAux = CGeneral::fechaMysqlANormal($fechaAux);
        $this->fecha = $fechaAux;

        $fechaAux = $this->creado_fecha;
        $fechaAux = CGeneral::fechahoraMysqlANormal($fechaAux);
        $this->creado_fecha = $fechaAux;

        if (!is_null($this->borrado_fecha)) {
            $fechaAux = $this->borrado_fecha;
            $fechaAux = CGeneral::fechahoraMysqlANormal($fechaAux);
            $this->borrado_fecha = $fechaAux;
        }
   
    }

    function fijarSentenciaInsert(): string {

        $fecha =  CGeneral::fechaNormalAMysql($this->fecha);
        $cod_dificultad = intval($this->cod_dificultad);
        $titulo = CGeneral::addSlashes($this->titulo);
        $puntuacion_base = intval($this->puntuacion_base);
        $creado_por = intval($this->creado_por);
        
        $sentencia = "INSERT INTO adivina ". 
            "(fecha, cod_dificultad, titulo, puntuacion_base, creado_fecha, creado_por)". 
            " VALUES ('$fecha', $cod_dificultad, '$titulo', $puntuacion_base, CURRENT_TIMESTAMP, $creado_por); ";

        return $sentencia;
    }

    function fijarSentenciaUpdate(): string {

        $cod_adivina = intval($this->cod_adivina);
        $fecha =  CGeneral::fechaNormalAMysql($this->fecha);
        $cod_dificultad = intval($this->cod_dificultad);
        $titulo = CGeneral::addSlashes($this->titulo);
        $puntuacion_base = intval($this->puntuacion_base);

        $sentencia = "UPDATE adivina ".
            "SET fecha = '$fecha', cod_dificultad = $cod_dificultad, ".
            "titulo = '$titulo', puntuacion_base = $puntuacion_base ".
            "WHERE cod_adivina = $cod_adivina;";
     
        return $sentencia;
    }


}