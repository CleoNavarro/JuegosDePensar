<?php
class Comunidades extends CActiveRecord {

    protected function fijarNombre(): string {
        return 'comunidades';
    }
    
    protected function fijarId():string {
        return "cod_comunidad";
    }

    protected function fijarAtributos(): array {
        return array(
            "cod_comunidad", "nombre_comu",
            "descripcion_comu", "icono_comu"
        );
    }

    
    protected function fijarRestricciones(): array {
        return
            array(
                array(
                    "ATRI" => "cod_comunidad,nombre_comu,icono_comu",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "cod_comunidad", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "nombre_comu", "TIPO" => "CADENA", "TAMANIO" => 60
                ),
                array(
                    "ATRI" => "descripcion_comu", "TIPO" => "CADENA", "TAMANIO" => 400
                ),
                array(
                    "ATRI" => "icono_comu", "TIPO" => "CADENA", "TAMANIO" => 400
                )
            );

    }

    /**
     * Undocumented function
     *
     * @param integer|null $cod_cat
     * @return mixed
     */
    public static function dameComunidades(?int $cod_comu = null) : mixed {

        $sentencia = "SELECT * from comunidades";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);
        
        $filas=$consulta->filas();

        if (is_null($filas))
            return false;

        $comunidades = [];

        foreach ($filas as $fila) {
            $comunidades[intval($fila["cod_comunidad"])] = $fila;
        }

        if ($cod_comu === null)
            return $comunidades;
        else {
            if (isset($comunidades[$cod_comu]))
                return $comunidades[$cod_comu];
            else
                return false;
        }
    }

            /**
     * Undocumented function
     *
     * @param integer|null $cod_cat
     * @return mixed
     */
    public static function dameComunidadesDelSitio(int $cod_sitio) : mixed {

        $sentencia = "SELECT * from vista_sitios_comunidades WHERE cod_sitio = $cod_sitio";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);
        
        $filas=$consulta->filas();

        if (is_null($filas))
            return false;

        $comunidades = [];

        foreach ($filas as $fila) {
                $comunidades[intval($fila["cod_comunidad"])] = $fila;
        }

        return $comunidades;
        
    }

    protected function afterCreate(): void {

        $this->nombre_comu = "";
        $this->descripcion_comu = "";
        $this->icono_comu = "";

    }

    /**
     * 
     */
    function fijarSentenciaInsert(): string {

        $nombre_comu = CGeneral::addSlashes($this->nombre_comu);
        $descripcion_comu = CGeneral::addSlashes($this->descripcion_comu);
        $icono_comu = CGeneral::addSlashes($this->icono_comu);

        $sentencia = "INSERT INTO comunidades (".
        "nombre_comu, descripcion_comu, icono_comu)". 
            " VALUES ('$nombre_comu', '$descripcion_comu', '$icono_comu'); ";

        return $sentencia;
    }

    function fijarSentenciaUpdate(): string {

        $cod_comunidad = intval($this->cod_comunidad);
        $nombre_comu = CGeneral::addSlashes($this->nombre_comu);
        $descripcion_comu = CGeneral::addSlashes($this->descripcion_comu);
        $icono_comu = CGeneral::addSlashes($this->icono_comu);

        $sentencia = "UPDATE comunidades ".
            "SET nombre_comu = '$nombre_comu', ".
            "descripcion_comu = '$descripcion_comu', ".
            "icono_comu = '$icono_comu', ".
            "WHERE cod_comunidad = $cod_comunidad;";
     
        return $sentencia;
    }

}

