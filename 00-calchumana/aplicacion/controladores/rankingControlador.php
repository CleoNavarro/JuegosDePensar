<?php
	 
class rankingControlador extends CControlador {

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
			[], "RANKING - JUEGOS DE PENSAR");
			
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
			],
			[
				"texto" => "Acerca de", 
				"enlace" => ["index", "acercade"]
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