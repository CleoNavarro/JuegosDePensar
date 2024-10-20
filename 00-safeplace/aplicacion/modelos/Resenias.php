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
            "puntuacion", "titulo", "descripcion", "resenia_verificada", 
            "borrado", "nick", "pronombres", "foto_usuario",
            "coor_x", "coor_y", "nombre_sitio",
            
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
            "resenia_verificada" => "Reseña verificada",
            "borrado" => "Reseña borrada",
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
                    "ATRI" => "resenia_verificada", "TIPO" => "ENTERO",
                    "RANGO" => [0, 1], "DEFECTO" => 0
                ),
                array(
                    "ATRI" => "borrado", "TIPO" => "ENTERO",
                    "RANGO" => [0, 1], "DEFECTO" => 0
                ),
            );
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
        $puntuacion = intval($this->puntuacion);
        $titulo = CGeneral::addSlashes($this->titulo);
        $descripcion = CGeneral::addSlashes($this->descripcion);

        $sentencia = "INSERT INTO resenias ". 
            "(cod_usuario, cod_sitio, fecha, puntuacion, titulo, descripcion, ".
            "resenia_verificada, borrado)". 
            " VALUES ($cod_usuario, $cod_sitio, CURRENT_TIMESTAMP, $puntuacion, '$titulo', ".
            "'$descripcion', 0, 0); ";

        return $sentencia;
    }

    function fijarSentenciaUpdate(): string {

        $cod_resenia = intval($this->cod_resenia);
        $cod_usuario = intval($this->cod_usuario);
        $cod_sitio = intval($this->cod_usuario);
        $puntuacion = intval($this->puntuacion);
        $titulo = CGeneral::addSlashes($this->titulo);
        $descripcion = CGeneral::addSlashes($this->descripcion);
        $resenia_verificada = intval($this->resenia_verificada);
        $borrado = intval($this->borrado);


        $sentencia = "UPDATE resenias ".
            "SET cod_usuario = $cod_usuario, cod_sitio = $cod_sitio, ".
            "puntuacion = $puntuacion, titulo = '$titulo', ".
            "descripcion = '$descripcion', resenia_verificada = $resenia_verificada, ".
            "borrado = $borrado ".
            "WHERE cod_resenia = $cod_resenia;";
     
        return $sentencia;
    }
}