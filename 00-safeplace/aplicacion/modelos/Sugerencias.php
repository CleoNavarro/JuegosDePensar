<?php
class Reportes extends CActiveRecord {

    protected function fijarNombre(): string {
        return 'sugerencias';
    }

    protected function fijarTabla():string {
        return "vista_sugerencias";
    }
    
    protected function fijarId():string {
        return "cod_sugerencia";
    }

    protected function fijarAtributos(): array {
        return array(
            "cod_sugerencia", "fecha", "nombre_sitio", "direccion", "poblacion", 
            "comentario", "foto", "mail_contacto", "leido", "leido_fecha", "leido_por",
            "anulado", "anulado_fecha", "anulado_por", "nick_lector", "nick_anulador"
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
            "leido_fecha" => "Fecha de lectura", 
            "leido_por" => "Cod Leido Por",
            "anulado" => "Sugerencia anulada",
            "anulado_fecha" => "Fecha de anulación", 
            "anulado_por" => "Cod Anulado por",
            "nick_lector" => "Leido Por", 
            "nick_anulador" => "Anulado por"
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
                    "ATRI" => "leido_fecha", "TIPO" => "FECHA"
                ),
                array(
                    "ATRI" => "leido_por", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "anulado", "TIPO" => "ENTERO",
                    "RANGO" => [0, 1], "DEFECTO" => 0
                ),
                array( 
                    "ATRI" => "anulado_fecha", "TIPO" => "FECHA"
                ),
                array(
                    "ATRI" => "anulado_por", "TIPO" => "ENTERO", "MIN" => 0
                )
            );
    }

     /**
     * Función para validar mail
     *
     * @return bool True si es un mail válido. False si no
     */
    public function validarMail () : bool {
        $mail = $this->mail;
        return CValidaciones::validaEMail($mail);
    }


    /**
     * Funcion que se activa cuando se lee una sugerencia. Graba la fecha de lectura y quién lo leyó
     * @return bool True si se pudo realizar la actualización. False si no
     */
    public static function leerSugerencia (int $cod_sugerencia, int $cod_lector) : bool {

        $sentencia = "UPDATE sugerencias ".
        "SET leido = 1, ".
        "leido_fecha = CURRENT_TIMESTAMP, ".
        "leido_por = $cod_lector ".
        "WHERE cod_sugerencia = $cod_sugerencia;";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);

        if ($consulta->error())
            return false;

        return true;
    }

    /**
     * Funcion que anula una sugerencia. Graba la fecha de anulación y quién lo anuló
     * @return bool True si se pudo realizar la actualización. False si no
     */
    public static function anularSugerencia (int $cod_sugerencia, int $cod_anulador) : bool {

        $sentencia = "UPDATE sugerencias ".
        "SET anulado = 1, ".
        "anulado_fecha = CURRENT_TIMESTAMP, ".
        "anulado_por = $cod_anulador ".
        "WHERE cod_sugerencia = $cod_sugerencia;";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);

        if ($consulta->error())
            return false;

        return true;
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
        $this->leido_fecha = date("d/m/Y H:i:s");
        $this->leido_por = 0;
        $this->anulado = 0;
        $this->anulado_fecha = date("d/m/Y H:i:s");
        $this->anulado_por = 0;
    }

    protected function afterBuscar(): void {

        $fecha = $this->fecha;
        $fecha = CGeneral::fechahoraMysqlANormal($fecha);
        $this->fecha = $fecha;

        if ($this->leido == 1) {
            $fecha = $this->leido_fecha;
            $fecha = CGeneral::fechahoraMysqlANormal($fecha);
            $this->leido_fecha = $fecha;
        }

        if ($this->anulado == 1) {
            $fecha = $this->anulado_fecha;
            $fecha = CGeneral::fechahoraMysqlANormal($fecha);
            $this->anulado_fecha = $fecha;
        }

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
            "foto, mail_contacto, leido, leido_fecha, leido_por, ".
            "anulado, anulado_fecha, anulado_por)". 
            " VALUES (CURRENT_TIMESTAMP, '$nombre_sitio', '$direccion', ".
            "'$poblacion', '$comentario', '$foto', '$mail_contacto', 0, NULL, 0".
            "0, NULL, 0); ";

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

        $sentencia = "UPDATE sugerencias ".
            "SET nombre_sitio = '$nombre_sitio', direccion = '$direccion', ".
            "poblacion = '$poblacion', comentario = '$comentario', foto = '$foto', ".
            "mail_contacto = '$mail_contacto' ".
            "WHERE cod_sugerencia = $cod_sugerencia;";
     
        return $sentencia;
    }
}