<?php

class sitiosControlador extends CControlador {
   
   public function accionIndex() {

       $this->tienePermisos("index");
       $this->menu();

       $this->barra_ubi = [
           [
               "texto" => "INICIAL",
               "enlace" => ["inicial"]
           ],
           [
               "texto" => "Mensajes",
               "enlace" => ["mensajes"]
           ]
       ]; 
 
       $sitios = new Sitios();

       $condiciones = ["select" => "*"];

       $postmen = [
           "nombre" => "",
           "poblacion" => "",
       ];

       if ($_POST) {

            $where = "";

            if (isset($_POST["sitios"]["nombre"])) {
                $postmen["nombre"] = CGeneral::addSlashes($_POST["sitios"]["nombre"]);
                $where .= " nombre_sitio like '%".$postmen["nombre"]."%' ";
            }

            if (isset($_POST["sitios"]["poblacion"])) {
                $postmen["poblacion"] = CGeneral::addSlashes($_POST["sitios"]["poblacion"]);
                if (isset($_POST["sitios"]["nombre"])) 
                    $where .= " and ";
                $where .= " poblacion like '%".$postmen["poblacion"]."%' ";
            }
           
           $condiciones["where"] = $where;
           
       }

       $tamPagina = 10;

       if (isset($_GET["reg_pag"]))
           $tamPagina = intval($_GET["reg_pag"]);

       $registros = intval($sitios->buscarTodosNRegistros($condiciones));
       $numPaginas = ceil($registros / $tamPagina);
       $pag = 1;

       if (isset($_GET["pag"])) {
           $pag = intval($_GET["pag"]);
       }

       if ($pag > $numPaginas)
           $pag = $numPaginas;

       $inicio = $tamPagina * ($pag - 1);
       $condiciones["limit"]="$inicio,$tamPagina";


       $filas = $this->filasTodas($sitios, $condiciones);

       if ($filas===false) {
           Sistema::app()->paginaError(402, "Error con el acceso a base de datos");
           return;
       }

       $cabecera = $this->crearCabecera();

       $opcPaginador = $this->paginador($registros, $pag, $tamPagina);

       $this->dibujaVista("index", 
           ["modelo" => $sitios ,"cab" => $cabecera, "fil" => $filas, 
           "pag" => $opcPaginador, "filtrado" => $postmen],
           "Gestión de Sitios - SP Manager");

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
               "texto" => "INICIAL",
               "enlace" => ["inicial"]
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
           ["sitios" => $sitios, "cat" => $categorias, "caract" => $caracteristicas, "comu"=> $comunidades],
           "Consulta Sitio ".$sitios->nombre_sitio);

   }

   public function accionNuevo () {

       $this->tienePermisos("nuevo");

       $this->menu();

       $this->barra_ubi = [
           [
               "texto" => "INICIAL",
               "enlace" => ["inicial"]
           ],
           [
               "texto" => "Gestion de Sitios",
               "enlace" => ["sitios"]
           ],
           [
               "texto" => "Nuevo Sitio",
               "enlace" => ["sitios", "nuevo"]
           ]
       ];
       
       $sitios = new Sitios();

       if ($_POST) {
           $nombre = $sitios->getNombre();

           if(isset($_FILES["plazas"])) {
               $nombre_imagen = $_FILES['plazas']['tmp_name']["icono"];
               //Guardamos tambien la ruta a donde ira
               $ruta = RUTA_BASE."/imagenes/terrenos/".$_FILES["plazas"]["name"]["icono"];
               move_uploaded_file($nombre_imagen, $ruta);

               //Si existe el nombre nuevo, es decir, se ha elegido una nueva fot la cambiamos
               if($_FILES["plazas"]["name"]["icono"]!== "")
                   //Como la imagen no es por post, sino por file, lo añadimos de esta manera
                   $_POST[$nombre]["icono"] = $_FILES["plazas"]["name"]["icono"];
               else 
                   //Sino seleccionamos la opción por defecto
                   $_POST[$nombre]["icono"] = "fotoPorDefecto.jpg";
           } else {
               $_POST[$nombre]["icono"] = "fotoPorDefecto.jpg";
           }

           $sitios->setValores($_POST[$nombre]);
   
            if ($sitios->validar()) {

               if (!$sitios->guardar()) {
                   $this->dibujaVista("nuevo", array("modelo"=>$sitios), "Crear plaza");
                   exit;
               }

               Sistema::app()->irAPagina(array("plazas")); 
               exit;
           }
       }

       $this->dibujaVista("nuevo", array("modelo" => $sitios), "Crear plaza");
   }

   public function accionModificar () {

       if (!isset($_GET["id"])) {
           Sistema::app()->paginaError(404, "No has indicado la reserva");
           exit;
       }

       $id = intval($_GET["id"]);

       $this->tienePermisos("modificar", $id);

       $sitios = new Sitios();

       if (!$sitios->buscarPorId($id)) {
           Sistema::app()->paginaError(404, "No se encuentra la reserva");
           exit;
       }

       $this->menu();

       $this->barra_ubi = [
           [
               "texto" => "INICIAL",
               "enlace" => ["inicial"]
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

           if(isset($_FILES["plazas"]))
               {
                   $nombre_imagen = $_FILES['plazas']['tmp_name']["icono"];
                   //Guardamos tambien la ruta a donde ira
                   $ruta = RUTA_BASE."/imagenes/terrenos/".$_FILES["plazas"]["name"]["icono"];
                   move_uploaded_file($nombre_imagen, $ruta);

                   //Si existe el nombre nuevo, es decir, se ha elegido una nueva fot la cambiamos
                   if($_FILES["plazas"]["name"]["icono"]!== "")
                       //Como la imagen no es por post, sino por file, lo añadimos de esta manera
                       $_POST[$nombre]["icono"] = $_FILES["plazas"]["name"]["icono"];
                   else 
                       //Sino seleccionamos la opción que estaba guardada
                       $_POST[$nombre]["icono"] = $sitios->icono;
               }

           
           $sitios->setValores($_POST[$nombre]);
   
            if ($sitios->validar()) {

               if (!$sitios->guardar()) {
                   $this->dibujaVista("modificar", array("modelo"=>$sitios), "Modificar plaza ".$sitios->nombre_plaza);
                   exit;
               }

               $id = $sitios->cod_plaza;

               Sistema::app()->irAPagina(array("plazas", "consultar/id=$id")); 
               exit;
           }
       }

       $this->dibujaVista("modificar", array("modelo" => $sitios), "Modificar plaza ".$sitios->nombre_plaza);
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
               "texto" => "INICIAL",
               "enlace" => ["inicial"]
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
                   $this->dibujaVista("borrar", ["plazas" => $sitios], "Anular plaza ".$sitios->nombre_plaza);
               }

               Sistema::app()->irAPagina(array("plazas")); 
               exit;
           }

       }

       $corr = "SI";
       if ($sitios->corriente_electrica==0) $corr = "NO";

       $this->dibujaVista("borrar", ["plaza" => $sitios, "corr" => $corr], "Anular plaza ".$sitios->nombre_plaza);

   }


   /**
    * Crea automáticamente las opciones del menú de navegación
    *
    * @return void
    */
   public function menu () : void {

       $this->menu = [
           [
               "texto" => "Sitios",
               "enlace" => ["sitios"]
           ],
           [
               "texto" => "Sugerencias",
               "enlace" => ["sugerencias"]
           ],
           [
                "texto" => "Nuevo",
                "enlace" => ["sitios", "nuevo"]
            ],
           [
               "texto" => "Volver a Manajer", 
               "enlace" => ["index"]
           ],
       ];
   }


   /**
    * Devuelve un array con todas las filas que cumplan tales condiciones
    *
    * @param Mensajes $mensajes Modelo
    * @param array $condiciones Condiciones de búsqueda
    * @return  mixed array con todas las filas, false si la sentencia falla
    */
   public function filasTodas (Sitios $sitios, array $condiciones = []) : array | false {

       $filas = $sitios->buscarTodos($condiciones);

       if (!$filas) return false;

       foreach ($filas as $clave=>$fila) {
           if ($fila["leido"]==0) $fila["leido"] = "NO";
           else $fila["leido"] = "SI";

           $fila["oper"] = CHTML::link(CHTML::imagen("/imagenes/24x24/ver.png"),
                                       Sistema::app()->generaURL(["sitios","consultar"],
                                       ["id" => $fila["cod_sitio"]]))." ".
                           CHTML::link(CHTML::imagen("/imagenes/24x24/borrar.png"),
                                       Sistema::app()->generaURL(["sitios","borrar"],
                                       ["id" => $fila["cod_sitio"]]));
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
           ["ETIQUETA" => "NOMBRE", "CAMPO" => "nombre", "ALINEA" => "cen"],
           ["ETIQUETA" => "RECIBIDO EL", "CAMPO" => "fechahora_recibido", "ALINEA" => "cen"],
           ["ETIQUETA" => "CONTACTO", "CAMPO" => "contacto", "ALINEA" => "cen"],
           ["ETIQUETA" => "ASUNTO", "CAMPO" => "asunto", "ALINEA" => "cen"],
           ["ETIQUETA" => "LEIDO", "CAMPO" => "leido", "ALINEA" => "cen"],
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

       return array("URL" => Sistema::app()->generaURL(array("mensajes","index")),
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
    *
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
       if (!Sistema::app()->Acceso()->puedePermiso(1)  || 
            !Sistema::app()->Acceso()->puedePermiso(3) || 
            !Sistema::app()->Acceso()->puedePermiso(5)) 
        {
           Sistema::app()->paginaError(503, "Acceso no permitido");
           return;
        }
   }

}