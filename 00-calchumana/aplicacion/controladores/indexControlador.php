<?php
	 
class indexControlador extends CControlador {

	/**
	 * Variables de entorno
	 */
	public $menu;

	/**
	 * Constructor
	 */	
	public function __construct() {
		$this->plantilla = "test";
		
	}

	/**
	 * Acción para la página principal
	 */
	public function accionIndex() {
		$this->menu = $this->menu();

		$this->dibujaVista("index",
			[], "JUEGOS DE PENSAR");
			
	}

	/**
	 * Acción para la página principal
	 */
	public function accionLogin() {

		$this->menu = $this->menu();

		//Creamos el modelo
        $login = new Login();

        //Obtenemos el nombre del modelo (fijarNombre) sobre el que actuará el post
        $nombre = $login->getNombre();

        //Comprobamos que existe POST del nombre
        if(isset($_POST[$nombre])) {
            //Asigno los valores de registro segun lo introducido en el formulario
            $login->setValores($_POST[$nombre]);

            //Validamos 
            if ($login->validar())  {
                $acl = Sistema::app()->ACL();
                $acceso = Sistema::app()->Acceso();
                $cod_usuario = $acl->getCodUsuario($login->nick);
				$permisos = $acl->getPermisos($cod_usuario);
                $acceso->registrarUsuario($cod_usuario, $login->nick, $acl->getNombre($cod_usuario), $permisos);   
            }
        }

        if (Sistema::app()->Acceso()->hayUsuario()) {

            Sistema::app()->irAPagina([]);
            exit;
        }  

        $this->dibujaVista("login", array("modelo" => $login), "Login - JUEGOS DE PENSAR");
			
	}

	public function accionCerrarSesion () {

		$this->menu = $this->menu();

        Sistema::app()->Acceso()->quitarRegistroUsuario();

        Sistema::app()->irAPagina(["index", "login"]); 
		exit;

    }

	public function accionRegistrate() {

		$this->menu = $this->menu();

        $this->dibujaVista("registrate", [], "¡Régistrate! - JUEGOS DE PENSAR");
			
	}

	public function accionDatos() {

		$this->menu = $this->menu();

		if (!isset($_GET["id"])) {
			Sistema::app()->paginaError(404, "¿Cómo has llegado hasta aquí?");
            return;
		}

		if (!Usuarios::dameUsuarios($_GET["id"])) {
			Sistema::app()->paginaError(404, "No, este usuario no existe (o no es un usuario)");
            return;
		}

        $this->dibujaVista("datos", ["cod_usuario" => intval($_GET["id"])], "Estadísticas - JUEGOS DE PENSAR");
			
	}

	
	/**
	 * Función que genera los links del menú para el header
	 */
	public function menu () : array {

		$arrayMenu = [
			[
				"texto" => "Jugar Ahora", 
				"enlace" => []
			],
			[
				"texto" => "Ranking", 
				"enlace" => ["ranking"]
			]
			
		];

		if (Sistema::app()->Acceso()->hayUsuario()) {
			array_unshift($arrayMenu,
				[
					"texto" => CHTML::imagen("imagenes/web/usuarios/".
						Usuarios::dameFoto(Sistema::app()->Acceso()->getCodUsuario()), "", 
						["class" => "fotouser"])." <br/> ".
						Sistema::app()->Acceso()->getNick(), 
					"enlace" => ["index", "datos?id=".Sistema::app()->Acceso()->getCodUsuario()]
				]
			);
			array_push($arrayMenu,
				[
					"texto" => "Cerrar Sesión", 
					"enlace" => ["index", "cerrarSesion"]
				]
			);
		} else {
			array_unshift($arrayMenu,
				[
					"texto" => "Regístrate", 
					"enlace" => ["registrate"]
				],
				[
					"texto" => "Iniciar sesión", 
					"enlace" => ["index", "login"]
				]
			);
		}


		return $arrayMenu;
	}




}



