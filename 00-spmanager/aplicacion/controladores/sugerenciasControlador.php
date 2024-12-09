<?php

class sugerenciasControlador extends CControlador {

    public function accionIndex() {

        $this->tienePermisos("index");
        $this->menu();
 
        $this->barra_ubi = [
            [
                "texto" => "MANAGER",
                "enlace" => ["index"]
            ],
            [
                "texto" => "Sugerencias",
                "enlace" => ["sugerencias"]
            ]
        ]; 

        $sugerencias = new Sugerencias;

        $condiciones = [
            "select" => "*",
            "where" => " nombre_sitio != '--' ",
            "order" => " fecha desc "
        ];

        $tamPagina = 10;

        if (isset($_GET["reg_pag"]))
            $tamPagina = intval($_GET["reg_pag"]);

        $registros = intval($sugerencias->buscarTodosNRegistros($condiciones));
        $numPaginas = ceil($registros / $tamPagina);
        $pag = 1;

        if (isset($_GET["pag"])) {
            $pag = intval($_GET["pag"]);
        }

        if ($pag > $numPaginas)
            $pag = $numPaginas;

        $inicio = $tamPagina * ($pag - 1);
        $condiciones["limit"]="$inicio,$tamPagina";

        $filas = $this->filasTodas($sugerencias, $condiciones);

        if ($filas===false) {
            Sistema::app()->paginaError(402, "Error con el acceso a base de datos");
            return;
        }


        $cabecera = $this->crearCabecera();

        $opcPaginador = $this->paginador($registros, $pag, $tamPagina);

        $this->dibujaVista("index", 
            ["modelo" => $sugerencias ,"cab" => $cabecera, "fil" => $filas, "pag" => $opcPaginador],
            "Gestión de Sugerencias - SP Manager");
    }

    public function accionConsultar() {
       
        if (!isset($_GET["id"])) {
            Sistema::app()->paginaError(404, "Página no encontrada");
            exit;
        }
 
        $id = intval($_GET["id"]);
 
        $this->tienePermisos("consultar",  $id);
 
        $sugerencias = new Sugerencias();
 
        if (!$sugerencias->buscarPorId($id)) {
            Sistema::app()->paginaError(404, "Página no encontrada");
            exit;
        }
 
        $this->menu();
 
        $this->barra_ubi = [
            [
                "texto" => "Manager",
                "enlace" => ["index"]
            ],
            [
                "texto" => "Gestión de Sugerencias",
                "enlace" => ["sugerencias"]
            ],
            [
                "texto" => $sugerencias->nombre_sitio,
                "enlace" => ["sugerencias", "consultar/id=$id",]
            ]
        ];
 
        $this->dibujaVista("consultar", 
            ["sugerencia" => $sugerencias],
            "Consulta Sugerencia ".$sugerencias->nombre_sitio);
 
    }

    public function accionBorrar() {

        if (!isset($_GET["id"])) {
             Sistema::app()->paginaError(404, "Página no encontrada");
            exit;
        }
 
        $id = intval($_GET["id"]);
 
        $this->tienePermisos("borrar", $id);
 
        $sugerencias = new Sugerencias();
 
        if (!$sugerencias->buscarPorId($id)) {
             Sistema::app()->paginaError(404, "Página no encontrada");
            exit;
        }
 
        $this->menu();
 
        $this->barra_ubi = [
            [
                "texto" => "MANAGER",
                "enlace" => ["index"]
            ],
            [
                "texto" => "Gestión de sugerencias",
                "enlace" => ["sugerencias"]
            ],
            [
                "texto" => "Anular sugerencia de ".$sugerencias->nombre_sitio,
                "enlace" => ["sugerencias", "borrar/id=$id",]
            ]
        ];
 
        if ($_POST) {
            $nombre = $sugerencias->getNombre();
            $sugerencias->setValores($_POST[$nombre]);
    
             if ($sugerencias->validar()) {
 
                if (!$sugerencias->guardar()) {
                    $this->dibujaVista("borrar", ["sugerencia" => $sugerencias], "Anular sugerencia ".$sugerencias->nombre_sitio);
                }
 
                Sistema::app()->irAPagina(array("sugerencias")); 
                exit;
            }
 
        }
 
        $this->dibujaVista("borrar", ["sugerencia" => $sugerencias], "Anular sugerencia ".$sugerencias->nombre_sitio);
 
    }
 
    /**
    * Crea automáticamente las opciones del menú de navegación
    * @return void
    */
   public function menu () : void {

        $this->menu = [
            [
                "texto" => "Sugerencias",
                "enlace" => ["sugerencias"]
            ],
            [
                "texto" => "Sitios",
                "enlace" => ["sitios"]
            ],
            [
                "texto" => "Volver a Manager", 
                "enlace" => ["index"]
            ],
        ];
    }

    /**
    * Devuelve un array con todas las filas que cumplan tales condiciones
    * @param Sugerencias $sugerencias Modelo
    * @param array $condiciones Condiciones de búsqueda
    * @return  mixed array con todas las filas, false si la sentencia falla
    */
    public function filasTodas (Sugerencias $sugerencias, array $condiciones = []) : array | false {

        $filas = $sugerencias->buscarTodos($condiciones);

        if (!$filas) return false;

        foreach ($filas as $clave=>$fila) {

            if ($fila["anulado"]==0) $fila["anulado"] = "NO";
                else $fila["anulado"] = "SI";

            $fila["oper"] = CHTML::link(CHTML::imagen("/imagenes/24x24/ver.png"),
                                        Sistema::app()->generaURL(["sugerencias","consultar"],
                                        ["id" => $fila["cod_sugerencia"]]))." ".
                            CHTML::link(CHTML::imagen("/imagenes/24x24/borrar.png"),
                                        Sistema::app()->generaURL(["sugerencias","borrar"],
                                        ["id" => $fila["cod_sugerencia"]]));
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
            ["ETIQUETA" => "FECHA", "CAMPO" => "fecha", "ALINEA" => "cen"],
            ["ETIQUETA" => "NOMBRE SITIO", "CAMPO" => "nombre_sitio", "ALINEA" => "cen"],
            ["ETIQUETA" => "POBLACIÓN", "CAMPO" => "poblacion", "ALINEA" => "cen"],
            ["ETIQUETA" => "BORRADO", "CAMPO" => "anulado", "ALINEA" => "cen"],
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

        return array("URL" => Sistema::app()->generaURL(array("sugerencias","index")),
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
        if (!Sistema::app()->Acceso()->puedePermiso(1) && 
            !Sistema::app()->Acceso()->puedePermiso(4)) 
        {
            Sistema::app()->paginaError(503, "Acceso no permitido");
            return;
        }
    }

}