<?php
class Palabras extends CActiveRecord {

    protected function fijarNombre(): string {
        return 'palabras';
    }

    protected function fijarTabla():string {
        return "vista_palabras";
    }
    
    protected function fijarId():string {
        return "cod_palabra";
    }

    protected function fijarAtributos(): array {
        return array(
            "cod_palabra", "cod_adivina", "orden", "enunciado", "siglas",
            "respuesta", "fecha"
        );
    }

    protected function fijarDescripciones(): array {
        return array(
            "cod_palabra" => "Código Palabra", 
            "cod_adivina" => "Código Adivina", 
            "orden" => "Orden", 
            "enunciado" => "Enunciado", 
            "siglas" => "Siglas",
            "respuesta" => "Respuesta", 
            "fecha" => "Fecha del juego"
        );
    }

    protected function fijarRestricciones(): array {
        return
            array(
                array(
                    "ATRI" => "orden,siglas,enunciado,respuesta",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "cod_adivina", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "orden", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "siglas", "TIPO" => "CADENA", "TAMANIO" => 3
                ),
                array(
                    "ATRI" => "enunciado", "TIPO" => "CADENA", "TAMANIO" => 255
                ), 
                array(
                    "ATRI" => "respuesta", "TIPO" => "CADENA", "TAMANIO" => 15
                )
            );
    }

   
    /**
     * Devuelve las palabras que contiene un juego de adivina
     *
     * @param integer $cod_adivina Código Adivina
     * @return mixed Array con palabras y su contenido. False si no hay preguntas
     */
    public static function damePalabras(int $cod_adivina) : mixed {

        $sentencia = "SELECT * from vista_palabras ".
                    "where cod_adivina = $cod_adivina ".
                    "order by orden asc;";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);
    
        $filas=$consulta->filas();

        if (is_null($filas) || count($filas)==0) return false;

        $palabras = [];

        foreach ($filas as $fila) {$palabras[intval($fila["orden"])] = $fila;}

        return $palabras;
    }

    protected function afterBuscar(): void { }

    function fijarSentenciaInsert(): string {

        $cod_adivina = intval($this->cod_adivina);
        $orden = intval($this->orden);
        $siglas = CGeneral::addSlashes($this->siglas);
        $enunciado = CGeneral::addSlashes($this->enunciado);
        $respuesta = CGeneral::addSlashes($this->respuesta);

        
        $sentencia = "INSERT INTO palabras ". 
            "(cod_adivina, orden, enunciado, siglas, respuesta)". 
            " VALUES ($cod_adivina, $orden, '$enunciado', '$siglas', '$respuesta'); ";

        return $sentencia;
    }

    function fijarSentenciaUpdate(): string {

        $cod_palabra = intval($this->cod_palabra);
        $cod_adivina = intval($this->cod_adivina);
        $orden = intval($this->orden);
        $siglas = CGeneral::addSlashes($this->siglas);
        $enunciado = CGeneral::addSlashes($this->enunciado);
        $respuesta = CGeneral::addSlashes($this->respuesta);

        $sentencia = "UPDATE palabras ".
            "SET cod_adivina = $cod_adivina, orden = $orden, ".
            "enunciado = '$enunciado', siglas = '$siglas', ".
            "respuesta = '$respuesta' ".
            "WHERE cod_palabra = $cod_palabra;";
     
        return $sentencia;
    }

}