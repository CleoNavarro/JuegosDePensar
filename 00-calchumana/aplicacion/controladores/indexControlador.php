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
	public function accionJugar() {

		$this->dibujaVista("jugar",
			[], "JUGANDO - Calculadora humana");
			
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



