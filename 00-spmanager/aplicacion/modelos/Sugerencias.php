<?php
class Reportes extends CActiveRecord {

    protected function fijarNombre(): string {
        return 'sugerencias';
    }

    protected function fijarTabla():string {
        return "sugerencias";
    }
    
    protected function fijarId():string {
        return "cod_sugerencia";
    }

    protected function fijarAtributos(): array {
        return array(
            "cod_sugerencia", "fecha", "nombre_sitio", "direccion", 
            "poblacion", "comentario", "foto", "mail_contacto", "leido", "anulado"
        );
    }

    protected function fijarDescripciones(): array {
        return array(
            "cod_sugerencia" => "Código Sugerencia", 
            "fecha" => "Fecha",
            "nombre_sitio" => "Sitio que quieres sugerir", 
            "direccion" => "Dirección", 
            "poblacion" => "Población", 
            "comentario" => "Coméntanos por qué deberíamos añadir este sitio a SafePlace", 
            "foto" => "Foto (opcional)", 
            "mail_contacto" => "Mail de contacto",
            "leido" => "Leido",
            "anulado" => "Sugerencia anulada"
        );
    }

    protected function fijarRestricciones(): array {
        return
            array(
                array(
                    "ATRI" => "nombre_sitio,direccion,población,comentario",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "cod_sugerencia", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array( 
                    "ATRI" => "fecha", "TIPO" => "FECHA"
                ),
                array(
                    "ATRI" => "nombre_sitio", "TIPO" => "CADENA", "TAMANIO" => 120
                ),
                array(
                    "ATRI" => "direccion", "TIPO" => "CADENA", "TAMANIO" => 255
                ),
                array(
                    "ATRI" => "poblacion", "TIPO" => "CADENA", "TAMANIO" => 60
                ),
                array(
                    "ATRI" => "comentario", "TIPO" => "CADENA", "TAMANIO" => 400
                ),
                array(
                    "ATRI" => "foto", "TIPO" => "CADENA", "TAMANIO" => 255
                ),
                array(
                    "ATRI" => "mail_contacto", "TIPO" => "CADENA", "TAMANIO" => 255
                ),
                array(
                    "ATRI" => "mail_contacto", "TIPO" => "FUNCION",
                    "FUNCION" => "validarMail",
                    "MENSAJE" => "No es un mail válido"
                ),
                array(
                    "ATRI" => "leido", "TIPO" => "ENTERO",
                    "RANGO" => [0, 1], "DEFECTO" => 0
                ),
                array(
                    "ATRI" => "anulado", "TIPO" => "ENTERO",
                    "RANGO" => [0, 1], "DEFECTO" => 0
                ),
            );
    }

     /**
     * Undocumented function
     *
     * @return bool
     */
    public function validarMail () : bool {
        $mail = $this->mail;
        return CValidaciones::validaEMail($mail);
    }

    protected function afterCreate(): void {

        $this->cod_sugerencia = 0;
        $this->fecha = date("d/m/Y H:i:s");
        $this->nombre_sitio = "";
        $this->direccion = "";
        $this->poblacion = "";
        $this->comentario = "";
        $this->foto = "fotoSitioPorDefecto.png";
        $this->mail_contacto = "";
        $this->leido = 0;
        $this->anulado = 0;
    }

    protected function afterBuscar(): void {

        $fecha = $this->fecha;
        $fecha = CGeneral::fechahoraMysqlANormal($fecha);
        $this->fecha = $fecha;

    }
    
    /**
     * 
     */
    function fijarSentenciaInsert(): string {

        $nombre_sitio = CGeneral::addSlashes($this->nombre_sitio);
        $direccion = CGeneral::addSlashes($this->direccion);
        $poblacion = CGeneral::addSlashes($this->poblacion);
        $comentario = CGeneral::addSlashes($this->comentario);
        $foto = CGeneral::addSlashes($this->foto);
        $mail_contacto = CGeneral::addSlashes($this->mail_contacto);

        $sentencia = "INSERT INTO sugerencias ". 
            "(fecha, nombre_sitio, direccion, poblacion, comentario, ".
            "foto, mail_contacto, leido, anulado,)". 
            " VALUES (CURRENT_TIMESTAMP, '$nombre_sitio', '$direccion', ".
            "'$poblacion', '$comentario', '$foto', '$mail_contacto', 0, 0); ";

        return $sentencia;
    }

    function fijarSentenciaUpdate(): string {

        $cod_sugerencia = intval($this->cod_sugerencia);
        $nombre_sitio = CGeneral::addSlashes($this->nombre_sitio);
        $direccion = CGeneral::addSlashes($this->direccion);
        $poblacion = CGeneral::addSlashes($this->poblacion);
        $comentario = CGeneral::addSlashes($this->comentario);
        $foto = CGeneral::addSlashes($this->foto);
        $mail_contacto = CGeneral::addSlashes($this->mail_contacto);
        $leido = intval($this->leido);
        $anulado = intval($this->anulado);

        $sentencia = "UPDATE sugerencias ".
            "SET nombre_sitio = '$nombre_sitio', direccion = '$direccion', ".
            "poblacion = '$poblacion', comentario = '$comentario', foto = '$foto', ".
            "mail_contacto = '$mail_contacto', ".
            "leido = $leido, anulado = $anulado ".
            "WHERE cod_sugerencia = $cod_sugerencia;";
     
        return $sentencia;
    }
}