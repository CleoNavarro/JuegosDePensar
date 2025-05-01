<?php

class usuariosControlador extends CControlador {
   
    public function accionIndex() {

		$this->tienePermisos("index");
        $this->menu();

		$this->barra_ubi = [
			[
				"texto" => "MANAGER",
				"enlace" => ["index"]
			],
			[
				"texto" => "Usuarios",
				"enlace" => ["usuarios"]
			]
		]; 

  
		$usuarios = new Usuarios();

		$condiciones = ["select" => "t.*"];

		$postuser = [
			"nombre" => "",
			"nick" => "",
			"mail" => "",
			"fecha_desde" => "",
			"fecha_hasta" => "",
			"borrado" => -1
		];

		$where = "";

		if ($_POST) {

			$postuser["nombre"] = CGeneral::addSlashes($_POST["usuarios"]["nombre"]);
			$postuser["nick"] = CGeneral::addSlashes($_POST["usuarios"]["nick"]);
			$postuser["mail"] = CGeneral::addSlashes($_POST["usuarios"]["mail"]);
			$postuser["fecha_desde"] = CGeneral::addSlashes($_POST["fecha_desde"]);
			$postuser["fecha_hasta"] = CGeneral::addSlashes($_POST["fecha_hasta"]);
			$postuser["borrado"] = intval($_POST["usuarios"]["borrado"]);

			
			$where .= "t.nombre like '%".$postuser["nombre"]."%' ".
				"and t.nick like '%".$postuser["nick"]."%' ".
				"and t.mail like '%".$postuser["mail"]."%' ";

			if ($postuser["borrado"]!=-1)
				$where .= "and t.borrado = ".$postuser["borrado"]." ";
			

			if (CValidaciones::validaFecha($postuser["fecha_desde"], "")) {
				$postuser["fecha_desde"] = CGeneral::fechaNormalAMysql($postuser["fecha_desde"]);
				$where .= "and t.fecha_registrado >= ".$postuser["fecha_desde"]." ";
			}

			if (CValidaciones::validaFecha($postuser["fecha_hasta"], "")) {
				$postuser["fecha_hasta"] = CGeneral::fechaNormalAMysql($postuser["fecha_hasta"]);
				$where .= "and t.fecha_registrado <= ".$postuser["fecha_hasta"]." ";
			}
			
		}

		$condiciones["where"] = $where;

		$tamPagina = 10;

		if (isset($_GET["reg_pag"]))
			$tamPagina = intval($_GET["reg_pag"]);

		$registros = intval($usuarios->buscarTodosNRegistros($condiciones));
		$numPaginas = ceil($registros / $tamPagina);
		$pag = 1;

		if (isset($_GET["pag"])) {
			$pag = intval($_GET["pag"]);
		}

		if ($pag > $numPaginas)
			$pag = $numPaginas;

		$inicio = $tamPagina * ($pag - 1);
		$condiciones["limit"]="$inicio,$tamPagina";


		$filas = $this->filasTodas($usuarios, $condiciones);

		if ($filas===false) {
			Sistema::app()->paginaError(400, "Error con el acceso a base de datos");
			return;
		}

        $cabecera = $this->crearCabecera();

		$opcPaginador = $this->paginador($registros, $pag, $tamPagina);

        $this->dibujaVista("index", 
			["modelo" => $usuarios ,"cab" => $cabecera, "fil" => $filas, "pag" => $opcPaginador, "filtrado" => $postuser],
			"Gestión de Usuarios");

    }

    public function accionConsultar() {
		
        if (!isset($_GET["id"])) {
            Sistema::app()->paginaError("No has indicado la plaza");
			exit;
        }

        $id = intval($_GET["id"]);

		$this->tienePermisos("consultar",  $id);

        $plazas = new Plazas();

        if (!$plazas->buscarPorId($id)) {
			Sistema::app()->paginaError("No se encuentra la plaza");
			exit;
		}


        $this->menuIzquierda();

		$this->barra_ubi = [
			[
				"texto" => "INICIAL",
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Gestión de Plazas",
				"enlace" => ["plazas"]
            ],
            [
				"texto" => "Plaza ".$plazas->nombre_plaza,
				"enlace" => ["plazas", "consultar/id=$id",]
			]
		];

		$corr = "SI";
		if ($plazas->corriente_electrica==0) $corr = "NO";
		
		$disp = "SI";
		if ($plazas->disponible==0) $corr = "NO";


        $this->dibujaVista("consultar", 
			["plaza" => $plazas, "corr" => $corr, "disp" => $disp],
			"Consulta Plaza ".$plazas->nombre_plaza);

    }

    public function accionNuevo () {

		$this->tienePermisos("nuevo");

        $this->menuIzquierda();

        $this->barra_ubi = [
			[
				"texto" => "INICIAL",
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Gestion de Plazas",
				"enlace" => ["plazas"]
            ],
            [
				"texto" => "Nueva Plaza",
				"enlace" => ["plazas", "nuevo",]
			]
		];
        
        $plazas = new Plazas();

        if ($_POST) {
            $nombre = $plazas->getNombre();

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

            $plazas->setValores($_POST[$nombre]);
    
		 	if ($plazas->validar()) {

				if (!$plazas->guardar()) {
					$this->dibujaVista("nuevo", array("modelo"=>$plazas), "Crear plaza");
					exit;
				}

				Sistema::app()->irAPagina(array("plazas")); 
				exit;
			}
        }

        $this->dibujaVista("nuevo", array("modelo" => $plazas), "Crear plaza");
    }

	public function accionModificar () {

		if (!isset($_GET["id"])) {
            Sistema::app()->paginaError(404, "No has indicado la reserva");
			exit;
        }

        $id = intval($_GET["id"]);

		$this->tienePermisos("modificar", $id);

		$plazas = new Plazas();

        if (!$plazas->buscarPorId($id)) {
			Sistema::app()->paginaError(404, "No se encuentra la reserva");
			exit;
		}

        $this->menuIzquierda();

		$this->barra_ubi = [
			[
				"texto" => "INICIAL",
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Gestión de Plazas",
				"enlace" => ["plazas"]
            ],
            [
				"texto" => "Modificar plaza ".$plazas->nombre_plaza,
				"enlace" => ["plazas", "modificar/id=$id",]
			]
		];

        if ($_POST) {
			
            $nombre = $plazas->getNombre();

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
						$_POST[$nombre]["icono"] = $plazas->icono;
				}

            
            $plazas->setValores($_POST[$nombre]);
    
		 	if ($plazas->validar()) {

				if (!$plazas->guardar()) {
					$this->dibujaVista("modificar", array("modelo"=>$plazas), "Modificar plaza ".$plazas->nombre_plaza);
					exit;
				}

				$id = $plazas->cod_plaza;

				Sistema::app()->irAPagina(array("plazas", "consultar/id=$id")); 
				exit;
			}
        }

        $this->dibujaVista("modificar", array("modelo" => $plazas), "Modificar plaza ".$plazas->nombre_plaza);
    }

	public function accionBorrar() {

        if (!isset($_GET["id"])) {
            Sistema::app()->paginaError("No has indicado la plaza");
			exit;
        }

        $id = intval($_GET["id"]);

		$this->tienePermisos("borrar", $id);

        $plazas = new Plazas();

        if (!$plazas->buscarPorId($id)) {
			Sistema::app()->paginaError("No se encuentra la plaza");
			exit;
		}

        $this->menuIzquierda();

		$this->barra_ubi = [
			[
				"texto" => "INICIAL",
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Gestión de plazas",
				"enlace" => ["plazas"]
            ],
            [
				"texto" => "Anular plaza ".$plazas->nombre_plaza,
				"enlace" => ["plazas", "borrar/id=$id",]
			]
		];

		if ($_POST) {
            $nombre = $plazas->getNombre();
            $plazas->setValores($_POST[$nombre]);
    
		 	if ($plazas->validar()) {

				if (!$plazas->guardar()) {
					$this->dibujaVista("borrar", ["plazas" => $plazas], "Anular plaza ".$plazas->nombre_plaza);
				}

				Sistema::app()->irAPagina(array("plazas")); 
				exit;
			}

		}

		$corr = "SI";
		if ($plazas->corriente_electrica==0) $corr = "NO";

		$this->dibujaVista("borrar", ["plaza" => $plazas, "corr" => $corr], "Anular plaza ".$plazas->nombre_plaza);

    }


   /**
    * Crea automáticamente las opciones del menú de navegación
    * @return void
    */
	public function menu () : void {

		$this->menu = [
			[
				"texto" => "Usuarios",
				"enlace" => ["usuarios"]
			],
			[
				"texto" => "Nuevo Usuario",
				"enlace" => ["usuarios", "nuevo"]
			],
			[
				"texto" => "Volver a Manager", 
				"enlace" => ["index"]
			],
		];
	}


    public function filasTodas (Usuarios $plazas, array $condiciones = []) : array | false {

        $filas = $plazas->buscarTodos($condiciones);

		if (!$filas) return false;

        foreach ($filas as $clave=>$fila) {
            if ($fila["borrado"]==0) $fila["borrado"] = "NO";
            else $fila["borrado"] = "SI";

			if (is_null($fila["verificado"])) $fila["verificado"] = "NO";
            else $fila["verificado"] = "SI";

            $fila["icono"] = CHTML::imagen("/imagenes/usuarios/".$fila["foto"],
                                            "Foto ".$fila["nombre"],
                                        ["style" => "width: 50px; height: 50px;"]);

			$fila["oper"] = CHTML::link(CHTML::imagen("/imagenes/24x24/ver.png"),
				                        Sistema::app()->generaURL(["usuarios","consultar"],
										["id" => $fila["cod_usuario"]]))." ".
                            CHTML::link(CHTML::imagen("/imagenes/24x24/modificar.png"),
				                        Sistema::app()->generaURL(["usuarios","modificar"],
										["id" => $fila["cod_usuario"]]))." ".
                            CHTML::link(CHTML::imagen("/imagenes/24x24/borrar.png"),
				                        Sistema::app()->generaURL(["usuarios","borrar"],
										["id" => $fila["cod_usuario"]]));
			$filas[$clave] = $fila;
		}

        return $filas;

    }

    public function crearCabecera () : array {

        return [
			["ETIQUETA" => "NOMBRE", "CAMPO" => "nombre", "ALINEA" => "cen"],
			["ETIQUETA" => "NICK", "CAMPO" => "nombre", "NICK" => "cen"],
			["ETIQUETA" => "FOTO", "CAMPO" => "foto", "ALINEA" => "cen"],
			["ETIQUETA" => "MAIL", "CAMPO" => "mail", "ALINEA" => "cen"],
            ["ETIQUETA" => "ROL", "CAMPO" => "nombre_rol", "ALINEA" => "cen"],
			["ETIQUETA" => "VERIFICADO", "CAMPO" => "verificado", "ALINEA" => "cen"],
            ["ETIQUETA" => "BORRADO", "CAMPO" => "borrado", "ALINEA" => "cen"],
			["ETIQUETA" => "OPERACIONES", "CAMPO" => "oper", "ALINEA" => "cen"],
		];
    }


    public function paginador (int $registros, int $pag, int $tamPagina) : array{

        return array("URL" => Sistema::app()->generaURL(array("usuarios","index")),
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
        
	public function tienePermisos (string $ubicacion, int $id = -1) : void {

		$atributos = array(
			"desde" => $ubicacion
		);
		
		if ($id>0)
			$atributos["id"] = $id;

		// Si no hay usuario validado, reenviamos al login
		if (!Sistema::app()->Acceso()->hayUsuario()) {
			Sistema::app()->irAPagina(array("registro", "login"), $atributos); 
			exit;
		}
				
		// Si el usuario no tiene permiso de acceso, salta un error
		if (!Sistema::app()->Acceso()->puedePermiso(6)) {
			Sistema::app()->paginaError(400, "Acceso no permitido");
			return;
		}
	}

}