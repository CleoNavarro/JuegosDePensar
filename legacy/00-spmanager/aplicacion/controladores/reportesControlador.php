<?php

class reportesControlador extends CControlador {

    public function accionIndex() {

        $this->tienePermisos("index");
        $this->menu();
 
        $this->barra_ubi = [
            [
                "texto" => "MANAGER",
                "enlace" => ["index"]
            ],
            [
                "texto" => "Reportes",
                "enlace" => ["reportes"]
            ]
        ]; 
  
        $reportes = new Reportes();
 
        $condiciones = ["select" => "*"];
 
        $postmen = [
            "nombre_sitio" => "",
            "nick_reportador" => "",
        ];
 
        $where = " cod_sitio != 0 ";
 
        if ($_POST) {
 
             if (isset($_POST["reportes"]["nombre_sitio"])) {
                 $postmen["nombre_sitio"] = CGeneral::addSlashes($_POST["reportes"]["nombre_sitio"]);
                 $where .= " and nombre_sitio like '%".$postmen["nombre_sitio"]."%' ";
             }
 
             if (isset($_POST["reportes"]["nick_reportador"])) {
                 $postmen["nick_reportador"] = CGeneral::addSlashes($_POST["reportes"]["nick_reportador"]);
                 $where .= " and nick_reportador like '%".$postmen["nick_reportador"]."%' ";
             }
        }
 
        $condiciones["where"] = $where;
        $condiciones["order"] = " fecha desc ";
 
        $tamPagina = 10;
 
        if (isset($_GET["reg_pag"]))
            $tamPagina = intval($_GET["reg_pag"]);
 
        $registros = intval($reportes->buscarTodosNRegistros($condiciones));
        $numPaginas = ceil($registros / $tamPagina);
        $pag = 1;
 
        if (isset($_GET["pag"])) {
            $pag = intval($_GET["pag"]);
        }
 
        if ($pag > $numPaginas)
            $pag = $numPaginas;
 
        $inicio = $tamPagina * ($pag - 1);
        $condiciones["limit"]="$inicio,$tamPagina";
 
        $filas = $this->filasTodas($reportes, $condiciones);
 
        if ($filas===false) {
            Sistema::app()->paginaError(402, "Error con el acceso a base de datos");
            return;
        }
 
        $cabecera = $this->crearCabecera();
 
        $opcPaginador = $this->paginador($registros, $pag, $tamPagina);
 
        $this->dibujaVista("index", 
            ["modelo" => $reportes , "cab" => $cabecera, "fil" => $filas, 
           "pag" => $opcPaginador, "filtrado" => $postmen],
            "Gestión de Reportes - SP Manager");
    }



    /**
    * Crea automáticamente las opciones del menú de navegación
    * @return void
    */
    public function menu () : void {

        $this->menu = [
            [
                "texto" => "Reportes",
                "enlace" => ["reportes"]
            ],
            [
                "texto" => "Sitios",
                "enlace" => ["sitios"]
            ],
            [
                "texto" => "Usuarios",
                "enlace" => ["usuarios"]
            ],
            [
                "texto" => "Volver a Manager", 
                "enlace" => ["index"]
            ],
        ];
    }

    /**
    * Devuelve un array con todas las filas que cumplan tales condiciones
    * @param Resenias $resenias Modelo
    * @param array $condiciones Condiciones de búsqueda
    * @return  mixed array con todas las filas, false si la sentencia falla
    */
    public function filasTodas (Reportes $reportes, array $condiciones = []) : array | false {

        $filas = $reportes->buscarTodos($condiciones);

        if (!$filas) return false;

        foreach ($filas as $clave=>$fila) {

            $fila["fecha"] = CGeneral::fechahoraMysqlANormal($fila["fecha"]);

            $fila["oper"] = CHTML::link(CHTML::imagen("/imagenes/24x24/ver.png"),
                                        Sistema::app()->generaURL(["resenias","consultar"],
                                        ["id" => $fila["cod_resenia"]]))." ".
                            CHTML::link(CHTML::imagen("/imagenes/24x24/exportcvs.png"),
                                        Sistema::app()->generaURL(["respuestas","nuevo"],
                                        ["cod_reporte" => $fila["cod_reporte"]]));
            $filas[$clave] = $fila;
        }

        return $filas;

    }

    /**
     * Devuelve un array con las columnas de la tabla
     * @return array Array con las columnas de la tabla
     */
    public function crearCabecera () : array {
        return [
            ["ETIQUETA" => "TÍTULO", "CAMPO" => "titulo", "ALINEA" => "cen"],
            ["ETIQUETA" => "FECHA REPORTE", "CAMPO" => "fecha", "ALINEA" => "cen"],
            ["ETIQUETA" => "REPORTADOR", "CAMPO" => "nick_reportador", "ALINEA" => "cen"],
            ["ETIQUETA" => "MOTIVO", "CAMPO" => "motivo", "ALINEA" => "cen"],
            ["ETIQUETA" => "OPERACIONES", "CAMPO" => "oper", "ALINEA" => "cen"],
        ];
    }


    /**
     * Función que genera el array con los dartos del paginador
     * @param integer $registros Los registros
     * @param integer $pag La página dónde se encuentra
     * @param integer $tamPagina El tamaño de página actual
     * @return array Ärray con los datos del paginador
     */
    public function paginador (int $registros, int $pag, int $tamPagina) : array{

        return array("URL" => Sistema::app()->generaURL(array("reportes","index")),
        "TOTAL_REGISTROS" => $registros,
        "PAGINA_ACTUAL" => $pag,
        "REGISTROS_PAGINA" => $tamPagina,
        "TAMANIOS_PAGINA"=>array(
            5=>"5",
            10=>"10",
            20=>"20",
            30=>"30",
            40=>"40",
            50=>"50"),
        "MOSTRAR_TAMANIOS"=>true,
        "PAGINAS_MOSTRADAS"=> 5,
        );
    }


    /**
    * Función que chequea si hay un usuario validado o tiene permisos para acceder
    * @param string $ubicacion Se le puede pasar una ubicación para que puedas volver
    * 		donde estabas antes
    * @param integer $id Se le puede pasar un id por si lo necesita para hacer un GET
    * @return void
    */
    public function tienePermisos (string $ubicacion = "", int $id = -1) : void {

        $atributos = array(
            "desde" => $ubicacion
        );
        
        if ($id>0)
            $atributos["id"] = $id;

        // Si no hay usuario validado, reenviamos al login
        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(array("index", "login"), $atributos); 
            exit;
        }
                
        // Si el usuario no tiene permiso de acceso, salta un error
        if (!Sistema::app()->Acceso()->puedePermiso(1)  && 
            !Sistema::app()->Acceso()->puedePermiso(6)) 
        {
            Sistema::app()->paginaError(503, "Acceso no permitido");
            return;
        }
    }


}