<?php
class Caracteristicas extends CActiveRecord {

    protected function fijarNombre(): string {
        return 'catacteristicas';
    }
    
    protected function fijarId():string {
        return "cod_catacteristica";
    }

    protected function fijarAtributos(): array {
        return array(
            "cod_catacteristica", "nombre_caract",
            "descripcion_caract", "icono_caract"
        );
    }

    
    protected function fijarRestricciones(): array {
        return
            array(
                array(
                    "ATRI" => "cod_catacteristica,nombre_caract,icono_caract",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "cod_catacteristica", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "nombre_caract", "TIPO" => "CADENA", "TAMANIO" => 60
                ),
                array(
                    "ATRI" => "descripcion_caract", "TIPO" => "CADENA", "TAMANIO" => 400
                ),
                array(
                    "ATRI" => "icono_caract", "TIPO" => "CADENA", "TAMANIO" => 400
                )
            );

    }

    /**
     * Undocumented function
     *
     * @param integer|null $cod_cat
     * @return mixed
     */
    public static function dameCaracteristicas(?int $cod_caract = null) : mixed {

        $sentencia = "SELECT * from caracteristicas";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);
        
        $filas=$consulta->filas();

        if (is_null($filas))
            return false;

        $caracteristicas = [];

        foreach ($filas as $fila) {
            $caracteristicas[intval($fila["cod_catacteristica"])] = $fila;
        }

        if ($cod_caract === null)
            return $caracteristicas;
        else {
            if (isset($caracteristicas[$cod_caract]))
                return $caracteristicas[$cod_caract];
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
    public static function dameCaracteristicasDelSitio(int $cod_sitio) : mixed {

        $sentencia = "SELECT * from vista_sitios_caracteristicas WHERE cod_sitio = $cod_sitio";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);
        
        $filas=$consulta->filas();

        if (is_null($filas))
            return false;

        $caracteristicas = [];

        foreach ($filas as $fila) {
                $caracteristicas[intval($fila["cod_caracteristica"])] = $fila;
        }

        return $caracteristicas;
        
    }

    protected function afterCreate(): void {

        $this->nombre_caract = "";
        $this->descripcion_caract = "";
        $this->icono_caract = "";

    }

    /**
     * 
     */
    function fijarSentenciaInsert(): string {

        $nombre_caract = CGeneral::addSlashes($this->nombre_caract);
        $descripcion_caract = CGeneral::addSlashes($this->descripcion_caract);
        $icono_caract = CGeneral::addSlashes($this->icono_caract);

        $sentencia = "INSERT INTO caracteristicas (".
        "nombre_caract, descripcion_caract, icono_caract)". 
            " VALUES ('$nombre_caract', '$descripcion_caract', '$icono_caract'); ";

        return $sentencia;
    }

    function fijarSentenciaUpdate(): string {

        $cod_caracteristica = intval($this->cod_caracteristica);
        $nombre_caract = CGeneral::addSlashes($this->nombre_caract);
        $descripcion_caract = CGeneral::addSlashes($this->descripcion_caract);
        $icono_caract = CGeneral::addSlashes($this->icono_caract);

        $sentencia = "UPDATE caracteristicas ".
            "SET nombre_caract = '$nombre_caract', ".
            "descripcion_caract = '$descripcion_caract', ".
            "icono_caract = '$icono_caract', ".
            "WHERE cod_caracteristica = $cod_caracteristica;";
     
        return $sentencia;
    }

}

