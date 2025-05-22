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

		$where = " t.nombre != '--' ";

		if ($_POST) {

			$postuser["nombre"] = CGeneral::addSlashes($_POST["usuarios"]["nombre"]);
			$postuser["nick"] = CGeneral::addSlashes($_POST["usuarios"]["nick"]);
			$postuser["mail"] = CGeneral::addSlashes($_POST["usuarios"]["mail"]);
			$postuser["fecha_desde"] = CGeneral::addSlashes($_POST["fecha_desde"]);
			$postuser["fecha_hasta"] = CGeneral::addSlashes($_POST["fecha_hasta"]);
			$postuser["borrado"] = intval($_POST["usuarios"]["borrado"]);

			
			$where .= " and t.nombre like '%".$postuser["nombre"]."%' ".
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
            Sistema::app()->paginaError("¿A dónde pretendes ir?");
			exit;
        }

        $id = intval($_GET["id"]);

		$this->tienePermisos("consultar",  $id);

        $usuario = new Usuarios();

        if (!$usuario->buscarPorId($id)) {
			Sistema::app()->paginaError("No se encuentra el usuario");
			exit;
		}


        $this->menu();

		$this->barra_ubi = [
			[
				"texto" => "Manager",
				"enlace" => ["index"]
			],
			[
				"texto" => "Usuarios",
				"enlace" => ["usuarios"]
            ],
            [
				"texto" => "Usuario: ".$usuario->nick,
				"enlace" => ["usuarios", "consultar/id=$id",]
			]
		];

		$borr = "NO";
		if ($usuario->borrado==1) $borr = $usuario->borrado_fecha." por ".$usuario->nick_borrador ;
		
		$verificado = "NO";
		if (!is_null($usuario->verificado)) $verificado = $usuario->verificado;


        $this->dibujaVista("consultar", 
			["usuario" => $usuario, "borr" => $borr, "verificado" => $verificado],
			"Consulta Usuario: ".$usuario->nick);

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
				"texto" => "Usuarios",
				"enlace" => ["usuarios"]
            ],
            [
				"texto" => "Nuevo Usuario",
				"enlace" => ["usuarios", "nuevo"]
			]
		];
        
        $usuarios = new Usuarios();

		if ($_POST) {
            $nombre = $usuarios->getNombre();
        
				if(isset($_FILES["usuarios"])) {
					$nombre_imagen = $_FILES['usuarios']['tmp_name']["foto"];
					//Guardamos tambien la ruta a donde ira
					$ruta = RUTA_BASE."/imagenes/usuarios/".$_FILES["usuarios"]["name"]["foto"];
					move_uploaded_file($nombre_imagen, $ruta);

					//Si existe el nombre nuevo, es decir, se ha elegido una nueva fot la cambiamos
					if($_FILES["usuarios"]["name"]["foto"]!== "")
						//Como la imagen no es por post, sino por file, lo añadimos de esta manera
						$_POST[$nombre]["foto"] = $_FILES["usuarios"]["name"]["foto"];
					else 
						//Sino seleccionamos la opción por defecto
						$_POST[$nombre]["foto"] = "fotoUsuarioPorDefecto.png";
				} else {
					$_POST[$nombre]["foto"] = "fotoUsuarioPorDefecto.png";
				}

				$usuarios->setValores($_POST[$nombre]);

				if ($usuarios->validar()) {

					if (!$usuarios->guardar()) {
						$this->dibujaVista("nuevo", array("modelo" => $usuarios), "Crear Usuario");
						exit;
					}

					$usuarioACL = new UsuariosACL();
					$usuarioACL->setValores($_POST[$nombre]);
					if ($usuarioACL->validar() ) {
							if (!$usuarioACL->guardar()) {
								$this->dibujaVista("nuevo", array("modelo" => $usuarios), "Crear Usuario");
								exit;
							}

					}

					Sistema::app()->irAPagina(array("usuarios")); 
					exit;
				}
			}	

        $this->dibujaVista("nuevo", array("modelo" => $usuarios), "Crear Usuario");
    }

	public function accionModificar () {

		if (!isset($_GET["id"])) {
            Sistema::app()->paginaError(404, "No has indicado ningún usuario");
			exit;
        }

        $id = intval($_GET["id"]);

		$this->tienePermisos("modificar", $id);

		$usuarios = new Usuarios();
		$usuarioACL = new UsuariosACL();

        if (!$usuarios->buscarPorId($id) || !$usuarioACL->buscarPorId($id)) {
			Sistema::app()->paginaError(404, "No se encuentra el usuario");
			exit;
		}

        $this->menu();

		$this->barra_ubi = [
			[
				"texto" => "MANAGER",
				"enlace" => ["index"]
			],
			[
				"texto" => "Usuarios",
				"enlace" => ["usuarios"]
            ],
            [
				"texto" => "Modificar usuario ".$usuarios->nick,
				"enlace" => ["usuarios", "modificar/id=$id",]
			]
		];

        if ($_POST) {
			
            $nombre = $usuarios->getNombre();

			if(isset($_FILES["usuarios"])) {
				$nombre_imagen = $_FILES['usuarios']['tmp_name']["foto"];
				//Guardamos tambien la ruta a donde ira
				$ruta = RUTA_BASE."/imagenes/usuarios/".$_FILES["usuarios"]["name"]["foto"];
				move_uploaded_file($nombre_imagen, $ruta);

				//Si existe el nombre nuevo, es decir, se ha elegido una nueva fot la cambiamos
				if($_FILES["usuarios"]["name"]["foto"]!== "")
					//Como la imagen no es por post, sino por file, lo añadimos de esta manera
					$_POST[$nombre]["foto"] = $_FILES["usuarios"]["name"]["foto"];
				else 
					//Sino seleccionamos la opción por defecto
					$_POST[$nombre]["foto"] = $usuarios->foto;
			}

			// TODO: Cómo hacer que no pida nunca contraseña
			if ($_POST[$nombre]["contrasenia"]=="") {
				unset($_POST[$nombre]["contrasenia"]);
				unset($_POST[$nombre]["repite_contrasenia"]);
			}
          
            $usuarios->setValores($_POST[$nombre]);
			$usuarioACL->setValores($_POST[$nombre]);

			if ($usuarios->validar() && $usuarioACL->validar()) {

				if (!$usuarios->guardar() || !$usuarioACL->guardar()) {
					$this->dibujaVista("modificar", array("modelo" => $usuarios), 
								"Modificar usuario ".$usuarios->nick);
					exit;
				}

				Sistema::app()->irAPagina(array("usuarios")); 
				exit;
			}
        }

        $this->dibujaVista("modificar", array("modelo" => $usuarios), "Modificar usuario ".$usuarios->nick);
    }

	public function accionBorrar() {

		if (!isset($_GET["id"])) {
            Sistema::app()->paginaError("No has indicado el usuario");
			exit;
        }

        $id = intval($_GET["id"]);

		$this->tienePermisos("borrar", $id);

        $usuarios = new Usuarios();

        if (!$usuarios->buscarPorId($id)) {
			Sistema::app()->paginaError("No se encuentra el usuario");
			exit;
		}

		if ($id == Sistema::app()->Acceso()->getCodUsuario()) {
			Sistema::app()->paginaError("No puedes borrarte a tí mismo");
			exit;
		}

        $this->menu();

		$this->barra_ubi = [
			[
				"texto" => "MANAGER",
				"enlace" => ["index"]
			],
			[
				"texto" => "USUARIOS",
				"enlace" => ["usuarios"]
            ],
            [
				"texto" => "Borrar datos de ".$usuarios->nick,
				"enlace" => ["usuarios", "borrar/id=$id"]
			]
		];

		if ($_POST) {

			if (isset($_POST["borrar"]) && $_POST["borrar"]=="si") {
				
				$borrado = Usuarios::borrarUsuario($id, Sistema::app()->Acceso()->getCodUsuario());

				if (!$borrado) {
					Sistema::app()->paginaError("Error al borrar los datos");
					exit;
				}

				Sistema::app()->irAPagina(array("usuarios")); 
				exit;
			}

			if (isset($_POST["recuperar"]) && $_POST["recuperar"]=="si") {
				
				$recuperado = Usuarios::recuperarUsuario($id);

				if (!$recuperado) {
					Sistema::app()->paginaError("Error al recuperar los datos");
					exit;
				}

				Sistema::app()->irAPagina(array("usuarios")); 
				exit;
			}
		}

		$verificado = "NO";
		if (!is_null($usuarios->verificado)) $verificado = $usuarios->verificado;

		$this->dibujaVista("borrar", ["usuario" => $usuarios, "verificado" => $verificado], 
			"Borrar datos de ".$usuarios->nick);

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

            $fila["foto"] = CHTML::imagen("/imagenes/usuarios/".$fila["foto"],
                                            "Foto ".$fila["nombre"],
                                        ["style" => "width: 50px; height: 50px;"]);

			$fila["oper"] = CHTML::link(CHTML::imagen("/imagenes/24x24/ver.png", "", ["class" => "icon-menu"]),
				                        Sistema::app()->generaURL(["usuarios","consultar"],
										["id" => $fila["cod_usuario"], "class" => "icon-menu"]))." ".
                            CHTML::link(CHTML::imagen("/imagenes/24x24/modificar.png", "", ["class" => "icon-menu"]),
				                        Sistema::app()->generaURL(["usuarios","modificar"],
										["id" => $fila["cod_usuario"], "class" => "icon-menu"]))." ".
                            CHTML::link(CHTML::imagen("/imagenes/24x24/borrar.png", "", ["class" => "icon-menu"]),
				                        Sistema::app()->generaURL(["usuarios","borrar"],
										["id" => $fila["cod_usuario"]]));
			$filas[$clave] = $fila;
		}

        return $filas;

    }

    public function crearCabecera () : array {

        return [
			["ETIQUETA" => "NOMBRE", "CAMPO" => "nombre", "ALINEA" => "cen"],
			["ETIQUETA" => "NICK", "CAMPO" => "nick", "NICK" => "cen"],
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
		if (!Sistema::app()->Acceso()->puedePermiso(1) 
			&& !Sistema::app()->Acceso()->puedePermiso(4)) {
			Sistema::app()->paginaError(400, "Acceso no permitido");
			return;
		}
	}

}