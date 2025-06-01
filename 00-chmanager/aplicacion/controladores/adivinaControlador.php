<?php

class adivinaControlador extends CControlador {
   
   public function accionIndex() {

       $this->tienePermisos("index");
       $this->menu();

       $this->barra_ubi = [
           [
               "texto" => "MANAGER",
               "enlace" => ["index"]
           ],
           [
               "texto" => "Juego Adivina",
               "enlace" => ["adivina"]
           ]
       ]; 
 
       $adivina = new Adivina();
       $adivNombre = $adivina->getNombre();

       $condiciones = ["select" => "*"];

       $postmen = [
           "fecha" => "",
           "titulo" => "",
           "cod_dificultad" => ""
       ];

       $where = " titulo != '--' ";

       if ($_POST) {

            if (isset($_POST[$adivNombre]["fecha"]) && !($_POST[$adivNombre]["fecha"] == "")) {
                $postmen["fecha"] = CGeneral::fechaNormalAMysql(CGeneral::addSlashes($_POST[$adivNombre]["fecha"]));
                $where .= " and fecha = '".$postmen["fecha"]."' ";
            }

            if (isset($_POST[$adivNombre]["titulo"]) && !($_POST[$adivNombre]["titulo"] == "")) {
                $postmen["titulo"] = CGeneral::addSlashes($_POST[$adivNombre]["titulo"]);
                $where .= " and titulo like '%".$postmen["titulo"]."%' ";
            }

            if (isset($_POST[$adivNombre]["cod_dificultad"]) && !($_POST[$adivNombre]["cod_dificultad"] == "")) {
                $postmen["cod_dificultad"] = intval($_POST[$adivNombre]["cod_dificultad"]);
                $where .= " and cod_dificultad = ".$postmen["cod_dificultad"]." ";
            }

       }

       $condiciones["where"] = $where;

       $tamPagina = 10;

       if (isset($_GET["reg_pag"]))
           $tamPagina = intval($_GET["reg_pag"]);

       $registros = intval($adivina->buscarTodosNRegistros($condiciones));
       $numPaginas = ceil($registros / $tamPagina);
       $pag = 1;

       if (isset($_GET["pag"])) {
           $pag = intval($_GET["pag"]);
       }

       if ($pag > $numPaginas)
           $pag = $numPaginas;

       $inicio = $tamPagina * ($pag - 1);
       $condiciones["limit"]="$inicio,$tamPagina";

       $filas = $this->filasTodas($adivina, $condiciones);

       if ($filas===false) {
           Sistema::app()->paginaError(402, "No hay resultados en la búsqueda");
           return;
       }

       $cabecera = $this->crearCabecera();

       $opcPaginador = $this->paginador($registros, $pag, $tamPagina);

       $this->dibujaVista("index", 
           ["modelo" => $adivina ,"cab" => $cabecera, "fil" => $filas, 
           "pag" => $opcPaginador, "filtrado" => $postmen],
           "Gestión de Juego Adivina - CH Manager");

   }

   public function accionConsultar() {
       
        if (!isset($_GET["id"])) {
            Sistema::app()->paginaError(404, "Página no encontrada");
            exit;
        }

        $id = intval($_GET["id"]);

        $this->tienePermisos("consultar",  $id);

        $adivina = new Adivina();

        if (!$adivina->buscarPorId($id)) {
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
                "texto" => "Adivina",
                "enlace" => ["adivina"]
            ],
            [
                "texto" => "Juego Adivina del día ".$adivina->fecha,
                "enlace" => ["adivina", "consultar/id=$id",]
            ]
        ];

        $borr = "NO";
        if (!is_null($adivina->borrado_fecha)) $borr = $adivina->borrado_fecha." por ".$adivina->nick_borrador ;
    
        $palabras = Adivina::damePalabras($id);

        $this->dibujaVista("consultar", 
            ["adivina" => $adivina, "palabras" => $palabras, "borr" => $borr],
            "Consulta Juego Adivina del día ".$adivina->fecha);

   }

   public function accionNuevo () {

       $this->tienePermisos("nuevo");

       $this->menu();

       $this->barra_ubi = [
           [
               "texto" => "MANAGER",
               "enlace" => ["index"]
           ],
           [
               "texto" => "Adivina",
               "enlace" => ["adivina"]
           ],
           [
               "texto" => "Nuevo Juego de Adivina",
               "enlace" => ["adivina", "nuevo"]
           ]
       ];
       
      
       $adivina = new Adivina();

       if ($_POST) {

           $adivinaNombre = $adivina->getNombre();
           $fechaAux =  $_POST[$adivinaNombre]["fecha"] ;
           if ($fechaAux != "") $fechaAux = CGeneral::fechaMysqlANormal($fechaAux);
           $_POST[$adivinaNombre]["fecha"] = $fechaAux;
           $_POST[$adivinaNombre]["creado_por"] = Sistema::app()->Acceso()->getCodUsuario();
           $_POST[$adivinaNombre]["puntuacion_base"] = 0;
           $adivina->setValores($_POST[$adivinaNombre]);
           $arrPalabras = $_POST["palabras"];
   
            if ($adivina->validar()) {

                $palabras = new Palabras();
                $valido = true;
                $puntuacion = 0;

                for ($i = 1; $i <= count($arrPalabras); $i++){
                    $arrPalabras[$i]["respuesta"] = trim($arrPalabras[$i]["respuesta"]);
                    $puntuacion += 500 + (100 * strlen($arrPalabras[$i]["respuesta"]));
                    $arrPalabras[$i]["cod_adivina"] = 0;
                    $arrPalabras[$i]["orden"] = $i;
                    $palabras->setValores($arrPalabras[$i]);
                    if (!$palabras->validar()) 
                            $valido = false;
                }

                $arrDificultad = Adivina::dameDificultad(intval($_POST[$adivinaNombre]["cod_dificultad"]));
                $_POST[$adivinaNombre]["puntuacion_base"] = intval($puntuacion * $arrDificultad["bonificador"]);
                $adivina->setValores($_POST[$adivinaNombre]);
                if (!$adivina->validar()) $valido = false;

                if (!$valido || !$adivina->guardar()) {
                   $this->dibujaVista("nuevo", array("modelo"=>$adivina), "Nuevo Juego de Adivina");
                   exit;
                }

                $cod_adivina = $adivina->cod_adivina;
                for ($i = 1; $i <= count($arrPalabras); $i++){
                    $palabras = new Palabras();
                    $arrPalabras[$i]["cod_adivina"] = $cod_adivina;
                    $arrPalabras[$i]["orden"] = $i;
                    $palabras->setValores($arrPalabras[$i]);
                    if (!$palabras->guardar()) {
                            $i = count($arrPalabras) + 2;
                            $valido = false;
                    }    
                }
                
                if ($valido) {
                    Sistema::app()->irAPagina(array("adivina")); 
                    exit;
                }
           }

           if ($adivina->fecha != "")
           $adivina->fecha = CGeneral::fechaNormalAMysql($adivina->fecha);
       }

       $this->dibujaVista("nuevo", array("modelo" => $adivina, "palabras" => $arrPalabras), 
                "Nuevo Juego de Adivina");
   }

   public function accionModificar () {

       if (!isset($_GET["id"])) {
           Sistema::app()->paginaError(404, "Página no encontrada");
           exit;
       }

       $id = intval($_GET["id"]);

       $this->tienePermisos("modificar", $id);

       $adivina = new Adivina();

       if (!$adivina->buscarPorId($id)) {
           Sistema::app()->paginaError(404, "Página no encontrada");
           exit;
       }

       $arrPalabras = Adivina::damePalabras($id);

       $this->menu();

       $this->barra_ubi = [
           [
               "texto" => "MANAGER",
               "enlace" => ["index"]
           ],
           [
               "texto" => "Adivina",
               "enlace" => ["adivina"]
           ],
           [
                "texto" => "Modificar juego del día ".$adivina->fecha,
                "enlace" => ["adivina", "modificar/id=$id",]
            ]
        ];

        if ($_POST) {

            $adivinaNombre = $adivina->getNombre();
            $fechaAux =  $_POST[$adivinaNombre]["fecha"] ;
            if ($fechaAux != "") $fechaAux = CGeneral::fechaMysqlANormal($fechaAux);
            $_POST[$adivinaNombre]["fecha"] = $fechaAux;
            $_POST[$adivinaNombre]["creado_por"] = Sistema::app()->Acceso()->getCodUsuario();
            $_POST[$adivinaNombre]["puntuacion_base"] = 0;
            $adivina->setValores($_POST[$adivinaNombre]);
            $arrPalabras = $_POST["palabras"];

            if ($adivina->validar()) {

                $palabras = new Palabras();
                
                $valido = true;
                $puntuacion = 0;

                for ($i = 1; $i <= count($arrPalabras); $i++){
                    $arrPalabras[$i]["respuesta"] = trim($arrPalabras[$i]["respuesta"]);
                    $puntuacion += 500 + (100 * strlen($arrPalabras[$i]["respuesta"]));
                    $arrPalabras[$i]["cod_adivina"] = $id;
                    $arrPalabras[$i]["orden"] = $i;
                    $palabras->setValores($arrPalabras[$i]);
                    if (!$palabras->validar()) 
                            $valido = false;
                }

                $arrDificultad = Adivina::dameDificultad(intval($_POST[$adivinaNombre]["cod_dificultad"]));
                $_POST[$adivinaNombre]["puntuacion_base"] = intval($puntuacion * $arrDificultad["bonificador"]);
                $adivina->setValores($_POST[$adivinaNombre]);
                if (!$adivina->validar()) $valido = false;

                if (!$valido || !$adivina->guardar()) {

                    $this->dibujaVista("modificar", array("modelo"=>$adivina, "palabras"=> $arrPalabras), 
                            "Modificar juego del día ".$adivina->fecha);
                    exit;
                }

                $codAdivina = $adivina->cod_adivina;

                if (!Adivina::borrarPalabras($codAdivina)) {
                    Sistema::app()->paginaError(511, "Error al actualizar las palagras del juego");
                    exit;
                }

                for ($i = 1; $i <= count($arrPalabras); $i++){
                    $palabras = new Palabras();
                    $arrPalabras[$i]["cod_test"] = $codAdivina;
                    $arrPalabras[$i]["orden"] = $i;
                    $palabras->setValores($arrPalabras[$i]);
                    if (!$palabras->guardar()) {
                            $i = count($arrPalabras) + 2;
                            $valido = false;
                    }    
                }
                
                if ($valido) {
                    Sistema::app()->irAPagina(array("adivina")); 
                    exit;
                }
            }
        }

        if ($adivina->fecha != "")
           $adivina->fecha = CGeneral::fechaNormalAMysql($adivina->fecha);

        $this->dibujaVista("modificar", array("modelo" => $adivina, "palabras"=> $arrPalabras), 
                "Modificar juego del día ".$adivina->fecha);
   }

   public function accionBorrar() {

        if (!isset($_GET["id"])) {
            Sistema::app()->paginaError(404, "Página no encontrada");
            exit;
        }

        $id = intval($_GET["id"]);

        $this->tienePermisos("borrar", $id);

        $adivina = new Adivina();

        if (!$adivina->buscarPorId($id)) {
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
                "texto" => "Adivina",
                "enlace" => ["adivina"]
            ],
            [
                "texto" => "Borrar Juego Adivina del día ".$adivina->fecha,
                "enlace" => ["adivina", "borrar/id=$id",]
            ]
        ];

        if ($_POST) {

            if (isset($_POST["borrar"]) && $_POST["borrar"]=="si") {
                
                $borrado = Adivina::borrarAdivina($id, Sistema::app()->Acceso()->getCodUsuario());

                if (!$borrado) {
                    Sistema::app()->paginaError(506, "Error al borrar los datos");
                    exit;
                }

                Sistema::app()->irAPagina(array("adivina")); 
                exit;
            }

            if (isset($_POST["recuperar"]) && $_POST["recuperar"]=="si") {
                
                $recuperado = Adivina::recuperarAdivina($id);

                if (!$recuperado) {
                    Sistema::app()->paginaError(507, "Error al recuperar los datos");
                    exit;
                }

                Sistema::app()->irAPagina(array("adivina")); 
                exit;
            }
        }

        $borr = 0;
        if (!is_null($adivina->borrado_fecha)) $borr = 1;
    
        $palabras = Adivina::damePalabras($id);


        $this->dibujaVista("borrar", ["adivina" => $adivina, "palabras" => $palabras, "borr" => $borr], "Borrar juego del día ".$adivina->fecha);

   }


   /**
    * Crea automáticamente las opciones del menú de navegación
    * @return void
    */
   public function menu () : void {

       $this->menu = [
           [
               "texto" => "Adivina",
               "enlace" => ["adivina"]
           ],
           [
               "texto" => "Nuevo Juego",
               "enlace" => ["adivina", "nuevo"]
           ],
           [
               "texto" => "Volver a Manager", 
               "enlace" => ["index"]
           ],
       ];
   }


   /**
    * Devuelve un array con todas las filas que cumplan tales condiciones
    * @param Adivina $adivina Modelo
    * @param array $condiciones Condiciones de búsqueda
    * @return  mixed array con todas las filas, false si la sentencia falla
    */
   public function filasTodas (Adivina $adivina, array $condiciones = []) : array | false {

       $filas = $adivina->buscarTodos($condiciones);

       if (!$filas) return false;

       foreach ($filas as $clave=>$fila) {

            $iconoBorrar = "borrar";
            $fila["fecha"] = CGeneral::fechaMysqlANormal($fila["fecha"]);
            $fila["creado_fecha"] = CGeneral::fechahoraMysqlANormal($fila["creado_fecha"]);
            if (!is_null($fila["borrado_fecha"])) {
                $fila["borrado"] = "SI";
                $fila["borrado_fecha"] = CGeneral::fechahoraMysqlANormal($fila["borrado_fecha"]);
                $iconoBorrar = "recuperar";
            } 
            else $fila["borrado"] = "NO";

            $fila["oper"] = CHTML::link(CHTML::imagen("/imagenes/24x24/ver.png", "", ["class" => "icon-tabla"]),
                                       Sistema::app()->generaURL(["adivina","consultar"],
                                       ["id" => $fila["cod_adivina"]]))." ".
                            CHTML::link(CHTML::imagen("/imagenes/24x24/modificar.png", "", ["class" => "icon-tabla"]),
                                       Sistema::app()->generaURL(["adivina","modificar"],
                                       ["id" => $fila["cod_adivina"]]))." ".
                            CHTML::link(CHTML::imagen("/imagenes/24x24/$iconoBorrar.png", "", ["class" => "icon-tabla"]),
                                       Sistema::app()->generaURL(["adivina","borrar"],
                                       ["id" => $fila["cod_adivina"]]));
           $filas[$clave] = $fila;
       }

       return $filas;

   }

   /**
    * Devuelve un array con las columnas de la tabla
    *
    * @return array Array con las columnas de la tabla
    */
   public function crearCabecera () : array {

       return [
           ["ETIQUETA" => "FECHA JUEGO", "CAMPO" => "fecha", "ALINEA" => "cen"],
           ["ETIQUETA" => "TÍTULO", "CAMPO" => "titulo", "ALINEA" => "cen"],
           ["ETIQUETA" => "DIFICULTAD", "CAMPO" => "dificultad", "ALINEA" => "cen"],
           ["ETIQUETA" => "PALABRAS", "CAMPO" => "num_palabras", "ALINEA" => "cen"],
           ["ETIQUETA" => "BORRADO", "CAMPO" => "borrado", "ALINEA" => "cen"],
           ["ETIQUETA" => "OPERACIONES", "CAMPO" => "oper", "ALINEA" => "cen"],
       ];
   }


   /**
    * Función que genera el array con los dartos del paginador
    *
    * @param integer $registros Los registros
    * @param integer $pag La página dónde se encuentra
    * @param integer $tamPagina El tamaño de página actual
    * @return array Ärray con los datos del paginador
    */
   public function paginador (int $registros, int $pag, int $tamPagina) : array{

       return array("URL" => Sistema::app()->generaURL(array("adivina","index")),
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