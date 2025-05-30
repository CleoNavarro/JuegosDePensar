<?php
	 
class adivinaControlador extends CControlador {

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
			[], "JUGAR - Adivina La Palabra");
			
	}


	/**
	 * Acción para la página principal
	 */
	public function accionJugar() {

		$this->menu = $this->menu();

		if (!isset($_GET["cod_adivina"])) {
			Sistema::app()->paginaError(404, "¿Cómo has llegado hasta aquí?");
            return;
		}

		if (!Adivina::dameAdivina($_GET["cod_adivina"])) {
			Sistema::app()->paginaError(404, "No, este juego no existe (o no es un juego)");
            return;
		}

		$this->dibujaVista("jugar",
			["cod_adivina" => intval($_GET["cod_adivina"])], "JUGANDO - Adivina La Palabra");
			
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
					"texto" => CHTML::imagen(RUTA_IMAGEN.
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



