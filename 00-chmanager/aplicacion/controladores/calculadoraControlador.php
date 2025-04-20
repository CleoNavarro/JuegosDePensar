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

       $condiciones = ["select" => "*"];

       $postmen = [
           "fecha" => "",
           "titulo" => "",
           "cod_dificultad" => ""
       ];

       $where = " titulo != '--' ";

       if ($_POST) {

            if (isset($_POST["calculadora"]["fecha"])) {
                $postmen["fecha"] = CGeneral::fechaNormalAMysql(CGeneral::addSlashes($_POST["calculadora"]["fecha"]));
                $where .= " and fecha = '".$postmen["fecha"]."' ";
            }

            if (isset($_POST["calculadora"]["titulo"])) {
                $postmen["titulo"] = CGeneral::addSlashes($_POST["calculadora"]["titulo"]);
                $where .= " and titulo like '%".$postmen["titulo"]."%' ";
            }

            if (isset($_POST["calculadora"]["cod_dificultad"])) {
                $postmen["cod_dificultad"] = intval($_POST["calculadora"]["cod_dificultad"]);
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
           Sistema::app()->paginaError(402, "Error con el acceso a base de datos");
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

       $sitios = new Sitios();

       if (!$sitios->buscarPorId($id)) {
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
               "texto" => "Gestión de Sitios",
               "enlace" => ["sitios"]
           ],
           [
               "texto" => $sitios->nombre_sitio,
               "enlace" => ["sitios", "consultar/id=$id",]
           ]
       ];

       $categorias = Categorias::dameCategoriasDelSitio($id);
       $caracteristicas= Caracteristicas::dameCaracteristicasDelSitio($id);
       $comunidades = Comunidades::dameComunidadesDelSitio($id);

       $this->dibujaVista("consultar", 
           ["sitio" => $sitios, "cat" => $categorias, "caract" => $caracteristicas, "comu"=> $comunidades],
           "Consulta Sitio ".$sitios->nombre_sitio);

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

       if ($_POST) {

           $testNombre = $test->getNombre();
           $fechaAux =  $_POST[$testNombre]["fecha"] ;
           $fechaAux = CGeneral::fechaMysqlANormal($fechaAux);
           $_POST[$testNombre]["fecha"] = $fechaAux;
           $_POST[$testNombre]["creado_por"] = Sistema::app()->Acceso()->getCodUsuario();
           $test->setValores($_POST[$testNombre]);
   
            if ($test->validar()) {

                $pregunta = new Pregunta();
                $preguntaNombre = $pregunta->getNombre();
                $arrPreguntas = $_POST["preguntas"];
                $valido = true;

                for ($i = 1; $i <= count($arrPreguntas); $i++){
                    $arrPreguntas[$preguntaNombre.$i]["cod_test"] = 0;
                    $arrPreguntas[$preguntaNombre.$i]["orden"] = $i;
                    $pregunta->setValores($arrPreguntas[$preguntaNombre.$i]);
                    if (!$pregunta->validar()) {
                            $valido = false;
                    }
                }

                if (!$valido || !$test->guardar()) {
                   $this->dibujaVista("nuevo", array("modelo"=>$test), "Nuevo Test de Calculadora");
                   exit;
                }

                $codTest = $test->cod_test;
                for ($i = 1; $i <= count($arrPreguntas); $i++){
                    $pregunta = new Pregunta();
                    $arrPreguntas[$preguntaNombre.$i]["cod_test"] = $codTest;
                    $arrPreguntas[$preguntaNombre.$i]["orden"] = $i;
                    $pregunta->setValores($arrPreguntas[$preguntaNombre.$i]);
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

       $this->dibujaVista("nuevo", array("modelo" => $test), 
                "Nuevo Test de Calculadora");
   }

   public function accionModificar () {

       if (!isset($_GET["id"])) {
           Sistema::app()->paginaError(404, "Página no encontrada");
           exit;
       }

       $id = intval($_GET["id"]);

       $this->tienePermisos("modificar", $id);

       $sitios = new Sitios();

       if (!$sitios->buscarPorId($id)) {
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
               "texto" => "Gestión de Sitios",
               "enlace" => ["sitios"]
           ],
           [
               "texto" => "Modificar sitio ".$sitios->nombre_sitio,
               "enlace" => ["sitios", "modificar/id=$id",]
           ]
       ];

       if ($_POST) {
           
           $nombre = $sitios->getNombre();

           if(isset($_FILES["sitios"]))
               {
                   $nombre_imagen = $_FILES['plazas']['sitios']["foto"];
                   //Guardamos tambien la ruta a donde ira
                   $ruta = RUTA_BASE."/imagenes/sitios/".$_FILES["sitios"]["name"]["foto"];
                   move_uploaded_file($nombre_imagen, $ruta);

                   //Si existe el nombre nuevo, es decir, se ha elegido una nueva fot la cambiamos
                   if($_FILES["sitios"]["name"]["foto"]!== "")
                       //Como la imagen no es por post, sino por file, lo añadimos de esta manera
                       $_POST[$nombre]["foto"] = $_FILES["sitios"]["name"]["foto"];
                   else 
                       //Sino seleccionamos la opción que estaba guardada
                       $_POST[$nombre]["foto"] = $sitios->icono;
               }

           $sitios->setValores($_POST[$nombre]);
   
            if ($sitios->validar()) {

               if (!$sitios->guardar()) {
                   $this->dibujaVista("modificar", array("modelo"=>$sitios), "Modificar sitio ".$sitios->nombre_sitio);
                   exit;
               }

               $id = $sitios->cod_plaza;

               Sistema::app()->irAPagina(array("sitios", "consultar/id=$id")); 
               exit;
           }
       }

       $this->dibujaVista("modificar", array("modelo" => $sitios), "Modificar sitio ".$sitios->nombre_sitio);
   }

   public function accionBorrar() {

       if (!isset($_GET["id"])) {
            Sistema::app()->paginaError(404, "Página no encontrada");
           exit;
       }

       $id = intval($_GET["id"]);

       $this->tienePermisos("borrar", $id);

       $sitios = new Sitios();

       if (!$sitios->buscarPorId($id)) {
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
               "texto" => "Gestión de sitios",
               "enlace" => ["sitios"]
           ],
           [
               "texto" => "Anular sitio ".$sitios->nombre_sitio,
               "enlace" => ["sitios", "borrar/id=$id",]
           ]
       ];

       if ($_POST) {
           $nombre = $sitios->getNombre();
           $sitios->setValores($_POST[$nombre]);
   
            if ($sitios->validar()) {

               if (!$sitios->guardar()) {
                   $this->dibujaVista("borrar", ["sitio" => $sitios], "Anular sitio ".$sitios->nombre_sitio);
               }

               Sistema::app()->irAPagina(array("sitios")); 
               exit;
           }

       }

       $categorias = Categorias::dameCategoriasDelSitio($id);
       $caracteristicas= Caracteristicas::dameCaracteristicasDelSitio($id);
       $comunidades = Comunidades::dameComunidadesDelSitio($id);

       $this->dibujaVista("borrar", ["sitio" => $sitios, "cat" => $categorias, "caract" => $caracteristicas, "comu"=> $comunidades], "Anular sitio ".$sitios->nombre_sitio);

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

            $fila["fecha"] = CGeneral::fechaMysqlANormal($fila["fecha"]);
            $fila["creado_fecha"] = CGeneral::fechahoraMysqlANormal($fila["creado_fecha"]);
            if (!is_null($fila["borrado_fecha"])) {
                $fila["borrado"] = "SI";
                $fila["borrado_fecha"] = CGeneral::fechahoraMysqlANormal($fila["borrado_fecha"]);
            } 
            else $fila["borrado"] = "NO";

            $fila["oper"] = CHTML::link(CHTML::imagen("/imagenes/24x24/ver.png"),
                                       Sistema::app()->generaURL(["calculadora","consultar"],
                                       ["id" => $fila["cod_test"]]))." ".
                            CHTML::link(CHTML::imagen("/imagenes/24x24/modificar.png"),
                                       Sistema::app()->generaURL(["calculadora","modificar"],
                                       ["id" => $fila["cod_test"]]))." ".
                            CHTML::link(CHTML::imagen("/imagenes/24x24/borrar.png"),
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