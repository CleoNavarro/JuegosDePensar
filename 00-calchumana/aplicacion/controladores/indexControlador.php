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
		$this->menu = $this->menu();
	}

	/**
	 * Acción para la página principal
	 */
	public function accionIndex() {

		$this->dibujaVista("index",
			[], "JUGAR - Calculadora humana");
			
	}

	
	/**
	 * Función que genera los links del menú para el header
	 */
	public function menu () : array {

		return [
			[
				"texto" => "Jugar Ahora", 
				"enlace" => ["index"] //,
				//"textcolor" => "red",
				//"imagen" => "imagenes/web/iconos/like.png"
			],
			[
				"texto" => "Calendario", 
				"enlace" => ["calendario"]//,
				//"textcolor" => "blue",
				//"imagen" => "imagenes/web/iconos/like.png"
			],
			[
				"texto" => "Ranking", 
				"enlace" => ["ranking"]
				//"textcolor" => "blue",
				// "imagen" => "imagenes/web/iconos/like.png"
			]
			
		];
	}
	




}



