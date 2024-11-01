<?php
class Reportes extends CActiveRecord {

    protected function fijarNombre(): string {
        return 'reportes';
    }

    protected function fijarTabla():string {
        return "vista_reportes";
    }
    
    protected function fijarId():string {
        return "cod_reporte";
    }

    protected function fijarAtributos(): array {
        return array(
            "cod_reporte", "cod_usuario", "cod_sitio", "cod_resenia",
            "fecha", "titulo", "motivo", "leido", "leido_fecha", "leido_por",
            "nick_reportador", "pronombres", "foto", "nombre_sitio", 
            "cod_usuario_reseniador", "fecha_resenia", "titulo_resenia",
            "descripcion_resenia", "nick_reseniador", "nick_lector"
        );
    }

    protected function fijarDescripciones(): array {
        return array(
            "cod_reporte" => "Código Reporte", 
            "cod_usuario" => "Código Usuario", 
            "cod_sitio" => "Código Sitio", 
            "fecha" => "Fecha del reporte", 
            "titulo" => "Título", 
            "motivo" => "Motivo del reporte", 
            "leido" => "Leido", 
            "leido_fecha" => "Fecha Lectura", 
            "leido_por" => "Cod lector",
            "nick_reportador" => "Reporte escrito por:",
            "pronombres" => "Pronombres",
            "foto" => "Foto",
            "nombre_sitio" => "Nombre del sitio",
            "cod_usuario_reseniador" => "Cod Reseña (si procede)", 
            "fecha_resenia" => "Fecha reseña", 
            "titulo_resenia" => "Título de la reseña",
            "descripcion_resenia" => "Descripción de la reseña", 
            "nick_reseniador" => "Usuario Reseñador", 
            "nick_lector" => "Leido por"
        );
    }

    protected function fijarRestricciones(): array {
        return
            array(
                array(
                    "ATRI" => "cod_usuario,cod_sitio,titulo,motivo",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "cod_reporte", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "cod_usuario", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "cod_usuario", "TIPO" => "FUNCION", 
                    "FUNCION" => "rellenaCamposUsuario",
                    "MENSAJE" => "El usuario no existe"
                ),
                array(
                    "ATRI" => "cod_sitio", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "cod_sitio", "TIPO" => "FUNCION", 
                    "FUNCION" => "rellenaCamposSitio",
                    "MENSAJE" => "El sitio no existe"
                ),
                array( 
                    "ATRI" => "fecha", "TIPO" => "FECHA"
                ),
                array(
                    "ATRI" => "titulo", "TIPO" => "CADENA", "TAMANIO" => 120
                ),
                array(
                    "ATRI" => "motivo", "TIPO" => "CADENA", "TAMANIO" => 2000
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
                )
            );
    }

    protected function afterCreate(): void {

        $this->cod_reporte = 0;
        $this->cod_usuario = 0;
        $this->cod_sitio = 0;
        $this->cod_resenia = 0;
        $this->fecha = date("d/m/Y H:i:s");
        $this->titulo = "";
        $this->motivo = "";
        $this->leido = 0;

    }

    protected function afterBuscar(): void {
        $this->fecha = CGeneral::fechaMysqlANormal($this->fecha);
        $this->leido_fecha = CGeneral::fechaMysqlANormal($this->leido_fecha);
    }



    // public function rellenaCamposUsuario () : bool {

    //     $cod_usu = intval($this->cod_usuario);

    //     $datosUsu = Usuarios::dameUsuarios($cod_usu);

    //     if (!$datosUsu) return false;

    //     $this->nombre = $datosUsu["nombre"];
    //     $this->nick = $datosUsu["nick"];
    //     $this->pronombres = $datosUsu["pronombres"];
    //     $this->foto = $datosUsu["foto_usuario"];

    //     return true;

    // }

    // /**
    //  * 
    //  */
    // public function rellenaCamposSitio () : bool {

    //     $cod_sitio = intval($this->cod_sitio);

    //     $datosSitio = Sitios::dameSitios($cod_sitio);

    //     if (!$datosSitio) return false;

    //     $this->nombre_sitio = $datosSitio["nombre_sitio"];
    //     $this->direccion = $datosSitio["direccion"];
    //     $this->poblacion = $datosSitio["poblacion"];
    //     $this->foto_sitio = $datosSitio["foto_sitio"];
       
    //     return true;

    // }
    // protected function afterBuscar(): void {

    //     $this->rellenaCamposUsuario();
    //     $this->rellenaCamposSitio();

    //     $fecha = $this->fecha;
    //     $fecha = CGeneral::fechahoraMysqlANormal($fecha);
    //     $this->fecha = $fecha;

    // }
    
    /**
     * 
     */
    function fijarSentenciaInsert(): string {

        $cod_usuario = intval($this->cod_usuario);
        $cod_sitio = intval($this->cod_sitio);
        $cod_resenia = intval($this->cod_resenia);
        $titulo = CGeneral::addSlashes($this->titulo);
        $motivo = CGeneral::addSlashes($this->motivo);

        $sentencia = "INSERT INTO reportes ". 
            "(cod_usuario, cod_sitio, cod_resenia, fecha, titulo, motivo, ".
            "leido, leido_fecha, leido_por)". 
            " VALUES ($cod_usuario, $cod_sitio, $cod_resenia, CURRENT_TIMESTAMP, '$titulo', ".
            "'$motivo', 0, NULL, 0); ";

        return $sentencia;
    }

    function fijarSentenciaUpdate(): string {

        $cod_reporte = intval($this->cod_reporte);
        $cod_usuario = intval($this->cod_usuario);
        $cod_sitio = intval($this->cod_usuario);
        $titulo = CGeneral::addSlashes($this->titulo);
        $motivo = CGeneral::addSlashes($this->motivo);
        $leido = intval($this->leido);
        $leido_fecha = CGeneral::addSlashes(CGeneral::fechaNormalAMysql($this->leido_fecha));
        $leido_por = intval($this->leido_por);

        $sentencia = "UPDATE reportes ".
            "SET cod_usuario = $cod_usuario, cod_sitio = $cod_sitio, ".
            "titulo = '$titulo', motivo = '$motivo', ".
            "leido = $leido, leido_fecha = '$leido_fecha', leido_por = $leido_por".
            "WHERE cod_reporte = $cod_reporte;";
     
        return $sentencia;
    }
}