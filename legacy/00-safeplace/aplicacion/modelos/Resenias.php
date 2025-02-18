<?php
class Resenias extends CActiveRecord {

    protected function fijarNombre(): string {
        return 'resenias';
    }

    protected function fijarTabla():string {
        return "vista_resenias";
    }
    
    protected function fijarId():string {
        return "cod_resenia";
    }

    protected function fijarAtributos(): array {
        return array(
            "cod_resenia", "cod_usuario", "cod_sitio", "fecha", 
            "puntuacion", "titulo", "descripcion", "nuevo", 
            "borrado", "borrado_fecha", "borrado_por", "nick_reseniador", 
            "pronombres", "foto", "nombre_sitio", "nick_borrador"
            
        );
    }

    protected function fijarDescripciones(): array {
        return array(
            "cod_resenia" => "Código Reseña", 
            "cod_usuario" => "Código Usuario", 
            "cod_sitio" => "Código Sitio", 
            "fecha" => "Fecha de la reseña", 
            "puntuacion" => "Puntuación",
            "titulo" => "Título de la reseña", 
            "descripcion" => "Descripción", 
            "nuevo" => "Nueva reseña",
            "borrado" => "Reseña borrada",
            "borrado_fecha" => "Fecha de borrado",
            "borrado_por" => "Cod Borrado por",
            "nick_reseniador" => "Escrito por:",
            "pronombres" => "Pronombres",
            "foto" => "Foto del usuario",
            "nombre_sitio" => "Nombre del sitio",
            "nick_borrador" => "Borrado por"
        );
    }

    protected function fijarRestricciones(): array {
        return
            array(
                array(
                    "ATRI" => "cod_usuario,cod_sitio,puntuacion",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "cod_resenia", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "cod_usuario", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "cod_sitio", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array( 
                    "ATRI" => "fecha", "TIPO" => "FECHA"
                ),
                array(
                    "ATRI" => "puntuacion", "TIPO" => "ENTERO",
                    "RANGO" => [1, 2, 3, 4, 5], "DEFECTO" => 3,
                    "MENSAJE" => "Por favor, califique este sitio"
                ),
                array(
                    "ATRI" => "titulo", "TIPO" => "CADENA", "TAMANIO" => 120
                ),
                array(
                    "ATRI" => "descripcion", "TIPO" => "CADENA", "TAMANIO" => 120
                ),
                array(
                    "ATRI" => "borrado", "TIPO" => "ENTERO",
                    "RANGO" => [0, 1], "DEFECTO" => 0
                ),
                array( 
                    "ATRI" => "borrado_fecha", "TIPO" => "FECHA"
                ),
                array(
                    "ATRI" => "borrado_por", "TIPO" => "ENTERO", "MIN" => 0
                )
            );
    }


      /**
     * Funcion que se activa cuando se lee una reseña.
     * @return bool True si se pudo realizar la actualización. False si no
     */
    public static function leerResenia (int $cod_resenia) : bool {

        $sentencia = "UPDATE resenias ".
        "SET nuevo = 1 ".
        "WHERE cod_resenia = $cod_resenia;";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);

        if ($consulta->error())
            return false;

        return true;
    }

    /**
     * Funcion que borra una reseña. Graba la fecha de borrado y quién lo borró
     * @return bool True si se pudo realizar la actualización. False si no
     */
    public static function borrarResenia (int $cod_resenia, int $cod_borrador) : bool {

        $sentencia = "UPDATE resenias ".
        "SET borrado = 1, ".
        "borrado_fecha = CURRENT_TIMESTAMP, ".
        "borrado_por = $cod_borrador ".
        "WHERE cod_resenia = $cod_resenia;";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);

        if ($consulta->error())
            return false;

        return true;
    }

    /**
     * Función para recuperar un reseña. Borra los datos de quien lo borró
     */
    public static function recuperarResenia(int $cod_resenia) : bool {

        $sentencia = "UPDATE resenias ".
            "SET borrado = 0, ".
            "fecha_borrado = NULL, ".
            "borrado_por = 0 ".
            "WHERE cod_resenia = $cod_resenia;";

            $consulta=Sistema::App()->BD()->crearConsulta($sentencia);

            if ($consulta->error())
                return false;

            return true;
    }



    protected function afterCreate(): void {

        $this->cod_resenia = 0;
        $this->cod_usuario = 0;
        $this->cod_sitio = 0;
        $this->fecha = date("d/m/Y H:i:s");;
        $this->puntuacion = 3;
        $this->titulo = "";
        $this->descripcion = "";
        $this->resenia_verificada = 0;
        $this->borrado = 0;
    }


    protected function afterBuscar(): void {

        $fecha = $this->fecha;
        $fecha = CGeneral::fechahoraMysqlANormal($fecha);
        $this->fecha = $fecha;

        if ($this->borrado == 1) {
            $fecha = $this->borrado_fecha;
            $fecha = CGeneral::fechahoraMysqlANormal($fecha);
            $this->borrado_fecha = $fecha;
        }

    }
    
    function fijarSentenciaInsert(): string {

        $cod_usuario = intval($this->cod_usuario);
        $cod_sitio = intval($this->cod_usuario);
        $puntuacion = intval($this->puntuacion);
        $titulo = CGeneral::addSlashes($this->titulo);
        $descripcion = CGeneral::addSlashes($this->descripcion);

        $sentencia = "INSERT INTO resenias ". 
            "(cod_usuario, cod_sitio, fecha, puntuacion, titulo, descripcion, ".
            "nuevo, borrado, borrado_fecha, borrado_por)". 
            " VALUES ($cod_usuario, $cod_sitio, CURRENT_TIMESTAMP, $puntuacion, '$titulo', ".
            "'$descripcion', 0, 0, NULL, 0); ";

        return $sentencia;
    }

    function fijarSentenciaUpdate(): string {

        $cod_resenia = intval($this->cod_resenia);
        $cod_usuario = intval($this->cod_usuario);
        $cod_sitio = intval($this->cod_usuario);
        $puntuacion = intval($this->puntuacion);
        $titulo = CGeneral::addSlashes($this->titulo);
        $descripcion = CGeneral::addSlashes($this->descripcion);

        $sentencia = "UPDATE resenias ".
            "SET cod_usuario = $cod_usuario, cod_sitio = $cod_sitio, ".
            "puntuacion = $puntuacion, titulo = '$titulo', ".
            "descripcion = '$descripcion'".
            "WHERE cod_resenia = $cod_resenia;";
     
        return $sentencia;
    }
}