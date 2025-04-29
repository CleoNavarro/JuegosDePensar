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
			[], "JUGAR - Calculadora humana");
			
	}

	/**
	 * Acción para la página principal
	 */
	public function accionLogin() {

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

        $this->dibujaVista("login", array("modelo" => $login), "Login");
			
	}

	public function accionCerrarSesion () {

        Sistema::app()->Acceso()->quitarRegistroUsuario();

        Sistema::app()->irAPagina(["index", "login"]); 
		exit;

    }

	public function accionRegistrate() {

        $this->dibujaVista("registrate", [], "¡Régistrate!");
			
	}

	/**
	 * Acción para la página principal
	 */
	public function accionJugar() {

		if (!isset($_GET["cod_test"])) {
			Sistema::app()->paginaError(404, "¿Cómo has llegado hasta aquí?");
            return;
		}

		if (!Test::dameTest($_GET["cod_test"])) {
			Sistema::app()->paginaError(404, "No, este test no existe (o no es un test)");
            return;
		}

		$this->dibujaVista("jugar",
			["cod_test" => intval($_GET["cod_test"])], "JUGANDO - Calculadora humana");
			
	}
	
	/**
	 * Función que genera los links del menú para el header
	 */
	public function menu () : array {

		return [
			[
				"texto" => "Jugar Ahora", 
				"enlace" => ["index"]
			],
			[
				"texto" => "Calendario", 
				"enlace" => ["calendario"]
			],
			[
				"texto" => "Ranking", 
				"enlace" => ["ranking"]
			]
			
		];
	}




}



