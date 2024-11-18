<?php
class Reportes extends CActiveRecord {

    protected function fijarNombre(): string {
        return 'respuestas';
    }

    protected function fijarTabla():string {
        return "vista_respuestas";
    }
    
    protected function fijarId():string {
        return "cod_respuesta";
    }

    protected function fijarAtributos(): array {
        return array(
            "cod_respuesta", "cod_reporte", "respondido_por",
            "fecha_respuesta", "mensaje", "nick_respuesta"
        );
    }

    protected function fijarDescripciones(): array {
        return array(
            "cod_respuesta" => "Cod Respuesta",
            "cod_reporte" => "Código Reporte", 
            "respondido_por" => "Cod Respondido Por",
            "fecha_respuesta" => "Fecha respuesta", 
            "mensaje" => "Mensaje",
            "nick_respuesta" => "Respondido por"
        );
    }

    protected function fijarRestricciones(): array {
        return
            array(
                array(
                    "ATRI" => "cod_reporte,respondido_por,fecha_respuesta,mensaje",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "cod_respuesta", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "cod_reporte", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "respondido_por", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array( 
                    "ATRI" => "fecha_respuesta", "TIPO" => "FECHA"
                ),
                array(
                    "ATRI" => "mensaje", "TIPO" => "CADENA", "TAMANIO" => 2000
                )
            );
    }


    protected function afterCreate(): void {

        $this->cod_respuesta = 0;
        $this->cod_reporte = 0;
        $this->respondido_por = 0;
        $this->fecha_respuesta = date("d/m/Y H:i:s");
        $this->mensaje = "";

    }

    protected function afterBuscar(): void {
        $this->fecha_respuesta = CGeneral::fechaMysqlANormal($this->fecha_respuesta);
    }


    /**
     * 
     */
    function fijarSentenciaInsert(): string {

        $cod_reporte = intval($this->cod_reporte);
        $respondido_por = intval($this->respondido_por);
        $mensaje = CGeneral::addSlashes($this->mensaje);

        $sentencia = "INSERT INTO respuestas ". 
            "(cod_reporte, respondido_por, fecha_respuesta, mensaje)". 
            " VALUES ($cod_reporte, $respondido_por, CURRENT_TIMESTAMP, '$mensaje'); ";

        return $sentencia;
    }

    function fijarSentenciaUpdate(): string {

        $cod_respuesta = intval($this->cod_reporte);
        $cod_reporte = intval($this->cod_reporte);
        $respondido_por = intval($this->respondido_por);
        $mensaje = CGeneral::addSlashes($this->mensaje);

        $sentencia = "UPDATE respuestas ".
            "SET cod_reporte = $cod_reporte, ".
            "respondido_por = $respondido_por, ".
            "mensaje = '$mensaje' ".
            "WHERE cod_respuesta = $cod_respuesta;";
     
        return $sentencia;
    }
}