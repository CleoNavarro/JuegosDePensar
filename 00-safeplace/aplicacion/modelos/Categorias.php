<?php
class Categorias extends CActiveRecord {

    protected function fijarNombre(): string {
        return 'categorias';
    }
    
    protected function fijarId():string {
        return "cod_categoria";
    }

    protected function fijarAtributos(): array {
        return array(
            "cod_categoria", "nombre_cat"
        );
    }

    
    protected function fijarRestricciones(): array {
        return
            array(
                array(
                    "ATRI" => "cod_categoria,nombre_cat",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "cod_categoria", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "nombre_cat", "TIPO" => "CADENA", "TAMANIO" => 50
                )
            );

    }

    /**
     * Undocumented function
     *
     * @param integer|null $cod_cat
     * @return mixed
     */
    public static function dameCategorias(?int $cod_cat = null) : mixed {

        $sentencia = "SELECT * from categorias";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);
        
        $filas=$consulta->filas();

        if (is_null($filas))
            return false;

        $categorias = [];

        foreach ($filas as $fila) {
            $categorias[intval($fila["cod_categoria"])] = $fila["nombre_cat"];
        }

        if ($cod_cat === null)
            return $categorias;
        else {
            if (isset($categorias[$cod_cat]))
                return $categorias[$cod_cat];
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
    public static function dameCategoriasDelSitio(int $cod_sitio) : mixed {

        $sentencia = "SELECT * from vista_sitios_categorias WHERE cod_sitio = $cod_sitio";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);
        
        $filas=$consulta->filas();

        if (is_null($filas))
            return false;

        $categorias = [];

        foreach ($filas as $fila) {
                $categorias[intval($fila["cod_categoria"])] = $fila;
        }

        return $categorias;
        
    }

    protected function afterCreate(): void {

        $this->nombre_cat = "";

    }

    /**
     * 
     */
    function fijarSentenciaInsert(): string {

        $nombre_cat = CGeneral::addSlashes($this->nombre_cat);

        $sentencia = "INSERT INTO categorias (nombre_cat)". 
            " VALUES ('$nombre_cat'); ";

        return $sentencia;
    }

    function fijarSentenciaUpdate(): string {

        $cod_categoria = intval($this->cod_categoria);
        $nombre_cat = CGeneral::addSlashes($this->nombre_cat);

        $sentencia = "UPDATE categorias ".
            "SET nombre_cat = '$nombre_cat'".
            "WHERE cod_categoria = $cod_categoria;";
     
        return $sentencia;
    }

}

