<?php
class Sitios extends CActiveRecord {

    protected function fijarNombre(): string {
        return 'sitios';
    }

    protected function fijarTabla():string {
        return "sitios";
    }
    
    protected function fijarId():string {
        return "cod_sitio";
    }

    protected function fijarAtributos(): array {
        return array(
            "cod_sitio", "coor_x", "coor_y",
            "nombre_sitio", "direccion", "poblacion", 
            "descripcion", "contacto", "foto", "borrado"
        );
    }

    protected function fijarDescripciones(): array {
        return array(
            "cod_sitio" => "Código Sitio", 
            "coor_x" => "Longitud (X)", 
            "coor_y" => "Latitud (Y)", 
            "nombre_sitio" => "Nombre del sitio",
            "direccion" => "Dirección", 
            "poblacion" => "Población", 
            "descripcion" => "Descripción del sitio", 
            "contacto" => "Teléfono y/o mail de contacto", 
            "foto" => "Foto", 
            "borrado" => "Sitio Borrado"
        );
    }

    protected function fijarRestricciones(): array {
        return
            array(
                array(
                    "ATRI" => "coor_x,coor_y,nombre_sitio,direccion",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "cod_sitio", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "coor_x", "TIPO" => "REAL"
                ),
                array(
                    "ATRI" => "coor_y", "TIPO" => "REAL"
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
                    "ATRI" => "descripcion", "TIPO" => "CADENA", "TAMANIO" => 480
                ),
                array(
                    "ATRI" => "contacto", "TIPO" => "CADENA", "TAMANIO" => 255
                ),
                array(
                    "ATRI" => "foto", "TIPO" => "CADENA", "TAMANIO" => 255
                ),
                array(
                    "ATRI" => "borrado", "TIPO" => "ENTERO",
                    "RANGO" => [0, 1], "DEFECTO" => 0
                ),
            );
    }

    protected function afterCreate(): void {

        $this->cod_usuario = 0;
        $this->coor_x = 1;
        $this->coor_y = 1;
        $this->nombre_sitio = "";
        $this->direccion = "";
        $this->poblacion = "";
        $this->descripcion = "";
        $this->contacto = "";
        $this->foto = "fotoSitioPorDefecto.png";
        $this->borrado = 0;
    }

    /**
     * Undocumented function
     *
     * @param integer|null $cod_sit
     * @return mixed
     */
    public static function dameSitios(?int $cod_sit = null) : mixed {

        $sentencia = "SELECT * from sitios;";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);
    
        $filas=$consulta->filas();

        if (is_null($filas))
            return false;

        $sitios = [];

        foreach ($filas as $fila) {
            $sitios[intval($fila["cod_sitio"])] = $fila;
        }

        if ($cod_sit === null)
            return $sitios;
        else {
            if (isset($sitios[$cod_sit]))
                return $sitios[$cod_sit];
            else
                return false;
        }
    }

    /**
     * 
     */
    function fijarSentenciaInsert(): string {

        $coor_x = floatval($this->coor_x);
        $coor_y = floatval($this->coor_x);
        $nombre_sitio = CGeneral::addSlashes($this->nombre_sitio);
        $direccion = CGeneral::addSlashes($this->direccion);
        $poblacion = CGeneral::addSlashes($this->poblacion);
        $descripcion = CGeneral::addSlashes($this->descripcion);
        $contacto = CGeneral::addSlashes($this->contacto);
        $foto = CGeneral::addSlashes($this->foto);

        $sentencia = "INSERT INTO sitios ". 
            "(coor_x, coor_y, nombre_sitio, direccion, poblacion, ".
            "descripcion, contacto, foto, borrado)". 
            " VALUES ('$coor_x', '$coor_y','$nombre_sitio', '$direccion', ".
            "'$poblacion', '$descripcion', '$contacto', '$foto', 0); ";

        return $sentencia;
    }

    function fijarSentenciaUpdate(): string {

        $cod_sitio = intval($this->cod_sitio);
        $coor_x = floatval($this->coor_x);
        $coor_y = floatval($this->coor_x);
        $nombre_sitio = CGeneral::addSlashes($this->nombre_sitio);
        $direccion = CGeneral::addSlashes($this->direccion);
        $poblacion = CGeneral::addSlashes($this->poblacion);
        $descripcion = CGeneral::addSlashes($this->descripcion);
        $contacto = CGeneral::addSlashes($this->contacto);
        $foto = CGeneral::addSlashes($this->foto);
        $borrado = intval($this->borrado);


        $sentencia = "UPDATE sitios ".
            "SET coor_x = '$coor_x', coor_y = '$coor_y', ".
            "nombre_sitio = '$nombre_sitio', ".
            "direccion = '$direccion', poblacion = '$poblacion', ".
            "descripcion = '$descripcion', contacto = '$contacto', ".
            "foto = '$foto', borrado = $borrado ".
            "WHERE cod_sitio = $cod_sitio;";
     
        return $sentencia;
    }
}