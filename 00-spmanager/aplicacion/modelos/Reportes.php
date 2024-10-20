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
            "cod_reporte", "cod_usuario", "cod_sitio", "fecha", 
            "titulo", "motivo", "leido", "borrado", 
            "nick", "pronombres", "foto_usuario",
            "coor_x", "coor_y", "nombre_sitio"
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
            "borrado" => "Reporte borrado",
            "nick" => "Escrito por:",
            "pronombres" => "Pronombres",
            "foto_usuario" => "Foto del usuario",
            "coor_x" => "Longitud (X)", 
            "coor_y" => "Latitud (Y)", 
            "nombre_sitio" => "Nombre del sitio"
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
                    "ATRI" => "borrado", "TIPO" => "ENTERO",
                    "RANGO" => [0, 1], "DEFECTO" => 0
                ),
            );
    }

    protected function afterCreate(): void {

        $this->cod_reporte = 0;
        $this->cod_usuario = 0;
        $this->cod_sitio = 0;
        $this->fecha = date("d/m/Y H:i:s");
        $this->titulo = "";
        $this->motivo = "";
        $this->leido = 0;
        $this->borrado = 0;
    }

    public function rellenaCamposUsuario () : bool {

        $cod_usu = intval($this->cod_usuario);

        $datosUsu = Usuarios::dameUsuarios($cod_usu);

        if (!$datosUsu) return false;

        $this->nombre = $datosUsu["nombre"];
        $this->nick = $datosUsu["nick"];
        $this->pronombres = $datosUsu["pronombres"];
        $this->foto_usuario = $datosUsu["foto_usuario"];
        $this->usuario_verificado = $datosUsu["usuario_verificado"];
       
        return true;

    }

    /**
     * 
     */
    public function rellenaCamposSitio () : bool {

        $cod_sitio = intval($this->cod_sitio);

        $datosSitio = Sitios::dameSitios($cod_sitio);

        if (!$datosSitio) return false;

        $this->coor_x = $datosSitio["coor_x"];
        $this->coor_y = $datosSitio["coor_y"];
        $this->nombre_sitio = $datosSitio["nombre_sitio"];
        $this->direccion = $datosSitio["direccion"];
        $this->poblacion = $datosSitio["poblacion"];
        $this->foto_sitio = $datosSitio["foto_sitio"];
       
        return true;

    }
    protected function afterBuscar(): void {

        $this->rellenaCamposUsuario();
        $this->rellenaCamposSitio();

        $fecha = $this->fecha;
        $fecha = CGeneral::fechahoraMysqlANormal($fecha);
        $this->fecha = $fecha;

    }
    
    /**
     * 
     */
    function fijarSentenciaInsert(): string {

        $cod_usuario = intval($this->cod_usuario);
        $cod_sitio = intval($this->cod_usuario);
        $titulo = CGeneral::addSlashes($this->titulo);
        $motivo = CGeneral::addSlashes($this->motivo);

        $sentencia = "INSERT INTO reportes ". 
            "(cod_usuario, cod_sitio, fecha, titulo, motivo, ".
            "leido, borrado)". 
            " VALUES ($cod_usuario, $cod_sitio, CURRENT_TIMESTAMP, '$titulo', ".
            "'$motivo', 0, 0); ";

        return $sentencia;
    }

    function fijarSentenciaUpdate(): string {

        $cod_reporte = intval($this->cod_reporte);
        $cod_usuario = intval($this->cod_usuario);
        $cod_sitio = intval($this->cod_usuario);
        $titulo = CGeneral::addSlashes($this->titulo);
        $motivo = CGeneral::addSlashes($this->motivo);
        $leido = intval($this->leido);
        $borrado = intval($this->borrado);


        $sentencia = "UPDATE reportes ".
            "SET cod_usuario = $cod_usuario, cod_sitio = $cod_sitio, ".
            "titulo = '$titulo', motivo = '$motivo', ".
            "leido = $leido, borrado = $borrado ".
            "WHERE cod_reporte = $cod_reporte;";
     
        return $sentencia;
    }
}