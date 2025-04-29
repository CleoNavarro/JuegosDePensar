<?php
class Pregunta extends CActiveRecord {

    protected function fijarNombre(): string {
        return 'pregunta';
    }

    protected function fijarTabla():string {
        return "vista_pregunta";
    }
    
    protected function fijarId():string {
        return "cod_pregunta";
    }

    protected function fijarAtributos(): array {
        return array(
            "cod_pregunta", "cod_test", "orden", "cod_tipo", "enunciado", "operacion",
            "cantidad", "fecha", "des_operacion", "tipo"
        );
    }

    protected function fijarDescripciones(): array {
        return array(
            "cod_pregunta" => "Código Pregunta", 
            "cod_test" => "Código Test", 
            "orden" => "Orden", 
            "cod_tipo" => "Código Tipo de Pregunta", 
            "enunciado" => "Enunciado", 
            "operacion" => "Operación",
            "cantidad" => "Resultado", 
            "fecha" => "Fecha del test", 
            "des_operacion" => "Operación", 
            "tipo" => "Tipo de Pregunta"
        );
    }

    protected function fijarRestricciones(): array {
        return
            array(
                array(
                    "ATRI" => "orden,cod_tipo,enunciado,cantidad",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "cod_test", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "orden", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "cod_tipo", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "enunciado", "TIPO" => "CADENA", "TAMANIO" => 255
                ), 
                array(
                    "ATRI" => "cantidad", "TIPO" => "ENTERO", "MIN" => 0
                )
            );
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
            $tipos[intval($fila["cod_tipo"])] = $fila;
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
     * Devuelve los tipos disponibles para un drop down
     * @return mixed Array con las dificultades disponibles. False su falla
     */
    public static function dameTipoDrop() : mixed {

        $arrayTipo = Pregunta::dameTipo();

        $arraDrop = [];

        foreach ($arrayTipo as $fila) {
            $arraDrop[intval($fila["cod_tipo"])] = $fila["tipo"];
        }

        return $arraDrop;
    }


    protected function afterBuscar(): void { }

    function fijarSentenciaInsert(): string {

        $cod_test = intval($this->cod_test);
        $orden = intval($this->orden);
        $cod_tipo = intval($this->cod_tipo);
        $enunciado = CGeneral::addSlashes($this->enunciado);
        $cantidad = intval($this->cantidad);

        
        $sentencia = "INSERT INTO pregunta ". 
            "(cod_test, orden, cod_tipo, enunciado, operacion, cantidad)". 
            " VALUES ($cod_test, $orden, $cod_tipo, '$enunciado', 1, $cantidad); ";

        return $sentencia;
    }

    function fijarSentenciaUpdate(): string {

        $cod_pregunta = intval($this->cod_pregunta);
        $cod_test = intval($this->cod_test);
        $orden = intval($this->orden);
        $cod_tipo = intval($this->cod_tipo);
        $enunciado = CGeneral::addSlashes($this->enunciado);
        $operacion = intval($this->operacion);
        $cantidad = intval($this->cantidad);

        $sentencia = "UPDATE pregunta ".
            "SET cod_test = $cod_test, orden = $orden, ".
            "cod_tipo = $cod_tipo, enunciado = '$enunciado', ".
            "operacion = $operacion, cantidad = $cantidad, ".
            "WHERE cod_pregunta = $cod_pregunta;";
     
        return $sentencia;
    }

}