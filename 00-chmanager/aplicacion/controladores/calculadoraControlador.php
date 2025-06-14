<?php

class calculadoraControlador extends CControlador {
   
   public function accionIndex() {

       $this->tienePermisos("index");
       $this->menu();

       $this->barra_ubi = [
           [
               "texto" => "MANAGER",
               "enlace" => ["index"]
           ],
           [
               "texto" => "Juego Calculadora",
               "enlace" => ["calculadora"]
           ]
       ]; 
 
       $test = new Test();
       $testNombre = $test->getNombre();

       $condiciones = ["select" => "*"];

       $postmen = [
           "fecha" => "",
           "titulo" => "",
           "cod_dificultad" => ""
       ];

       $where = " titulo != '--' ";

       if ($_POST) {

            if (isset($_POST[$testNombre]["fecha"]) && !($_POST[$testNombre]["fecha"] == "")) {
                $postmen["fecha"] = CGeneral::fechaNormalAMysql(CGeneral::addSlashes($_POST[$testNombre]["fecha"]));
                $where .= " and fecha = '".$postmen["fecha"]."' ";
            }

            if (isset($_POST[$testNombre]["titulo"]) && !($_POST[$testNombre]["titulo"] == "")) {
                $postmen["titulo"] = CGeneral::addSlashes($_POST[$testNombre]["titulo"]);
                $where .= " and titulo like '%".$postmen["titulo"]."%' ";
            }

            if (isset($_POST[$testNombre]["cod_dificultad"]) && !($_POST[$testNombre]["cod_dificultad"] == "")) {
                $postmen["cod_dificultad"] = intval($_POST[$testNombre]["cod_dificultad"]);
                $where .= " and cod_dificultad = ".$postmen["cod_dificultad"]." ";
            }

       }

       $condiciones["where"] = $where;

       $tamPagina = 10;

       if (isset($_GET["reg_pag"]))
           $tamPagina = intval($_GET["reg_pag"]);

       $registros = intval($test->buscarTodosNRegistros($condiciones));
       $numPaginas = ceil($registros / $tamPagina);
       $pag = 1;

       if (isset($_GET["pag"])) {
           $pag = intval($_GET["pag"]);
       }

       if ($pag > $numPaginas)
           $pag = $numPaginas;

       $inicio = $tamPagina * ($pag - 1);
       $condiciones["limit"]="$inicio,$tamPagina";

       $filas = $this->filasTodas($test, $condiciones);

       if ($filas===false) {
           Sistema::app()->paginaError(402, "No hay resultados en la búsqueda");
           return;
       }

       $cabecera = $this->crearCabecera();

       $opcPaginador = $this->paginador($registros, $pag, $tamPagina);

       $this->dibujaVista("index", 
           ["modelo" => $test ,"cab" => $cabecera, "fil" => $filas, 
           "pag" => $opcPaginador, "filtrado" => $postmen],
           "Gestión de Juego Calculadora - CH Manager");

   }

   public function accionConsultar() {
       
        if (!isset($_GET["id"])) {
            Sistema::app()->paginaError(404, "Página no encontrada");
            exit;
        }

        $id = intval($_GET["id"]);

        $this->tienePermisos("consultar",  $id);

        $test = new Test();

        if (!$test->buscarPorId($id)) {
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
                "texto" => "Calculadora",
                "enlace" => ["calculadora"]
            ],
            [
                "texto" => "Test del día ".$test->fecha,
                "enlace" => ["calculadora", "consultar/id=$id",]
            ]
        ];

        $borr = "NO";
        if (!is_null($test->borrado_fecha)) $borr = $test->borrado_fecha." por ".$test->nick_borrador ;
    
        $preguntas = Test::damePreguntas($id);

        $this->dibujaVista("consultar", 
            ["test" => $test, "preguntas" => $preguntas, "borr" => $borr],
            "Consulta Test del día ".$test->fecha);

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
                "texto" => "Calculadora",
                "enlace" => ["calculadora"]
            ],
            [
                "texto" => "Nuevo Test",
                "enlace" => ["calculadora", "nuevo"]
            ]
        ];
        
        
        $test = new Test();

        $arrPreguntas = false;

        if ($_POST) {

            $testNombre = $test->getNombre();
            $fechaAux =  $_POST[$testNombre]["fecha"] ;
            if ($fechaAux != "") $fechaAux = CGeneral::fechaMysqlANormal($fechaAux);
            $_POST[$testNombre]["fecha"] = $fechaAux;
            $_POST[$testNombre]["creado_por"] = Sistema::app()->Acceso()->getCodUsuario();
            $_POST[$testNombre]["puntuacion_base"] = 0;
            $test->setValores($_POST[$testNombre]);
            $arrPreguntas = $_POST["preguntas"];
    
            if ($test->validar()) {

                $pregunta = new Pregunta();
                $valido = true;
                $puntuacion = 0;

                for ($i = 1; $i <= count($arrPreguntas); $i++){
                    $arrTipo = Pregunta::dameTipo(intval($arrPreguntas[$i]["cod_tipo"]));
                    $puntuacion += intval($arrTipo["puntuacion_base"]);
                    $arrPreguntas[$i]["cod_test"] = 0;
                    $arrPreguntas[$i]["orden"] = $i;
                    $pregunta->setValores($arrPreguntas[$i]);
                    if (!$pregunta->validar()) 
                            $valido = false;
                }

                $arrDificultad = Test::dameDificultad(intval($_POST[$testNombre]["cod_dificultad"]));
                $_POST[$testNombre]["puntuacion_base"] = intval($puntuacion * $arrDificultad["bonificador"]);
                $test->setValores($_POST[$testNombre]);
                if (!$test->validar()) $valido = false;

                if (!$valido || !$test->guardar()) {

                   $this->dibujaVista("nuevo", array("modelo"=>$test), "Nuevo Test de Calculadora");
                   exit;
                }

                $codTest = $test->cod_test;
                for ($i = 1; $i <= count($arrPreguntas); $i++){
                    $pregunta = new Pregunta();
                    $arrPreguntas[$i]["cod_test"] = $codTest;
                    $arrPreguntas[$i]["orden"] = $i;
                    $pregunta->setValores($arrPreguntas[$i]);
                    if (!$pregunta->guardar()) {
                            $i = count($arrPreguntas) + 2;
                            $valido = false;
                    }    
                }
                
                if ($valido) {
                    Sistema::app()->irAPagina(array("calculadora")); 
                    exit;
                }
            }

            if ($test->fecha != "")
                $test->fecha = CGeneral::fechaNormalAMysql($test->fecha);
        }

        $this->dibujaVista("nuevo", array("modelo" => $test,  "preguntas" => $arrPreguntas), 
                "Nuevo Test de Calculadora");
   }

   public function accionModificar () {

       if (!isset($_GET["id"])) {
           Sistema::app()->paginaError(404, "Página no encontrada");
           exit;
       }

       $id = intval($_GET["id"]);

       $this->tienePermisos("modificar", $id);

       $test = new Test();

       if (!$test->buscarPorId($id)) {
           Sistema::app()->paginaError(404, "Página no encontrada");
           exit;
       }

       $arrPreguntas = Test::damePreguntas($id);

       $this->menu();

       $this->barra_ubi = [
           [
               "texto" => "MANAGER",
               "enlace" => ["index"]
           ],
           [
               "texto" => "Calculadora",
               "enlace" => ["calculadora"]
           ],
           [
                "texto" => "Modificar test del día ".$test->fecha,
                "enlace" => ["calculadora", "modificar/id=$id",]
            ]
        ];

        if ($_POST) {

            $testNombre = $test->getNombre();
            $fechaAux =  $_POST[$testNombre]["fecha"] ;
            if ($fechaAux != "") $fechaAux = CGeneral::fechaMysqlANormal($fechaAux);
            $_POST[$testNombre]["fecha"] = $fechaAux;
            $_POST[$testNombre]["creado_por"] = Sistema::app()->Acceso()->getCodUsuario();
            $_POST[$testNombre]["puntuacion_base"] = 0;
            $test->setValores($_POST[$testNombre]);

            if ($test->validar()) {

                $pregunta = new Pregunta();
                $arrPreguntas = $_POST["preguntas"];
                $valido = true;
                $puntuacion = 0;

                for ($i = 1; $i <= count($arrPreguntas); $i++){
                    $arrTipo = Pregunta::dameTipo(intval($arrPreguntas[$i]["cod_tipo"]));
                    $puntuacion += intval($arrTipo["puntuacion_base"]);
                    $arrPreguntas[$i]["cod_test"] = $id;
                    $arrPreguntas[$i]["orden"] = $i;
                    $pregunta->setValores($arrPreguntas[$i]);
                    if (!$pregunta->validar()) 
                            $valido = false;
                }

                $arrDificultad = Test::dameDificultad(intval($_POST[$testNombre]["cod_dificultad"]));
                $_POST[$testNombre]["puntuacion_base"] = intval($puntuacion * $arrDificultad["bonificador"]);
                $test->setValores($_POST[$testNombre]);
                if (!$test->validar()) $valido = false;

                if (!$valido || !$test->guardar()) {

                    $this->dibujaVista("modificar", array("modelo"=>$test, "preguntas"=> $arrPreguntas), 
                            "Modificar test del día ".$test->fecha);
                    exit;
                }

                $codTest = $test->cod_test;

                if (!Test::borrarPreguntas($codTest)) {
                    Sistema::app()->paginaError(510, "Error al actualizar las preguntas del test");
                    exit;
                }

                for ($i = 1; $i <= count($arrPreguntas); $i++){
                    $pregunta = new Pregunta();
                    $arrPreguntas[$i]["cod_test"] = $codTest;
                    $arrPreguntas[$i]["orden"] = $i;
                    $pregunta->setValores($arrPreguntas[$i]);
                    if (!$pregunta->guardar()) {
                            $i = count($arrPreguntas) + 2;
                            $valido = false;
                    }    
                }
                
                if ($valido) {
                    Sistema::app()->irAPagina(array("calculadora")); 
                    exit;
                }
            }
        }

        if ($test->fecha != "")
                $test->fecha = CGeneral::fechaNormalAMysql($test->fecha);

        $this->dibujaVista("modificar", array("modelo" => $test, "preguntas"=> $arrPreguntas), 
                "Modificar test del día ".$test->fecha);
   }

   public function accionBorrar() {

        if (!isset($_GET["id"])) {
            Sistema::app()->paginaError(404, "Página no encontrada");
            exit;
        }

        $id = intval($_GET["id"]);

        $this->tienePermisos("borrar", $id);

        $test = new Test();

        if (!$test->buscarPorId($id)) {
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
                "texto" => "Calculadora",
                "enlace" => ["calculadora"]
            ],
            [
                "texto" => "Borrar Test del día ".$test->fecha,
                "enlace" => ["calculadora", "borrar/id=$id",]
            ]
        ];

        if ($_POST) {

            if (isset($_POST["borrar"]) && $_POST["borrar"]=="si") {
                
                $borrado = Test::borrarTest($id, Sistema::app()->Acceso()->getCodUsuario());

                if (!$borrado) {
                    Sistema::app()->paginaError(506, "Error al borrar los datos");
                    exit;
                }

                Sistema::app()->irAPagina(array("calculadora")); 
                exit;
            }

            if (isset($_POST["recuperar"]) && $_POST["recuperar"]=="si") {
                
                $recuperado = Test::recuperarTest($id);

                if (!$recuperado) {
                    Sistema::app()->paginaError(507, "Error al recuperar los datos");
                    exit;
                }

                Sistema::app()->irAPagina(array("calculadora")); 
                exit;
            }
        }

        $borr = 0;
        if (!is_null($test->borrado_fecha)) $borr = 1;
    
        $preguntas = Test::damePreguntas($id);


        $this->dibujaVista("borrar", ["test" => $test, "preguntas" => $preguntas, "borr" => $borr], "Borrar test ".$test->fecha);

   }


   /**
    * Crea automáticamente las opciones del menú de navegación
    * @return void
    */
   public function menu () : void {

       $this->menu = [
           [
               "texto" => "Calculadora",
               "enlace" => ["calculadora"]
           ],
           [
               "texto" => "Nuevo Test",
               "enlace" => ["calculadora", "nuevo"]
           ],
           [
               "texto" => "Volver a Manager", 
               "enlace" => ["index"]
           ],
       ];
   }


   /**
    * Devuelve un array con todas las filas que cumplan tales condiciones
    * @param Test $test Modelo
    * @param array $condiciones Condiciones de búsqueda
    * @return  mixed array con todas las filas, false si la sentencia falla
    */
   public function filasTodas (Test $test, array $condiciones = []) : array | false {

       $filas = $test->buscarTodos($condiciones);

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
                                       Sistema::app()->generaURL(["calculadora","consultar"],
                                       ["id" => $fila["cod_test"]]))." ".
                            CHTML::link(CHTML::imagen("/imagenes/24x24/modificar.png", "", ["class" => "icon-tabla"]),
                                       Sistema::app()->generaURL(["calculadora","modificar"],
                                       ["id" => $fila["cod_test"]]))." ".
                            CHTML::link(CHTML::imagen("/imagenes/24x24/$iconoBorrar.png", "", ["class" => "icon-tabla"]),
                                       Sistema::app()->generaURL(["calculadora","borrar"],
                                       ["id" => $fila["cod_test"]]));
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
           ["ETIQUETA" => "FECHA TEST", "CAMPO" => "fecha", "ALINEA" => "cen"],
           ["ETIQUETA" => "TÍTULO", "CAMPO" => "titulo", "ALINEA" => "cen"],
           ["ETIQUETA" => "DIFICULTAD", "CAMPO" => "dificultad", "ALINEA" => "cen"],
           ["ETIQUETA" => "PREGUNTAS", "CAMPO" => "num_preguntas", "ALINEA" => "cen"],
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

       return array("URL" => Sistema::app()->generaURL(array("calculadora","index")),
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
            !Sistema::app()->Acceso()->puedePermiso(5)) 
        {
           Sistema::app()->paginaError(503, "Acceso no permitido");
           return;
        }
   }

}