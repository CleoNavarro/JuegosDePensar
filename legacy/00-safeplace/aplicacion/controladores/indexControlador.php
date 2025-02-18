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
		$this->plantilla = "mapa";
		$this->menu = $this->menu();
	}

	/**
	 * Acción para la página principal
	 */
	public function accionIndex() {

		$this->dibujaVista("index",
			[], "SafePlace");
			
	}

	
	/**
	 * Función que genera los links del menú para el header
	 */
	public function menu () : array {

		return [
			[
				"texto" => "Favoritos", 
				"enlace" => ["favoritos"],
				"textcolor" => "red",
				"imagen" => "imagenes/web/iconos/like.png"
			],
			[
				"texto" => "Recientes", 
				"enlace" => ["recientes"],
				"textcolor" => "blue",
				"imagen" => "imagenes/web/iconos/like.png"
			],
			[
				"texto" => "Ajustes", 
				"enlace" => ["ajustes"],
				"textcolor" => "blue",
				"imagen" => "imagenes/web/iconos/like.png"
			],
			[
				"texto" => "Intra", 
				"enlace" => ["intra", "index"],
				"textcolor" => "black",
				"imagen" => "imagenes/usuarios/fotoUsuarioPorDefecto.png"
			],
			
		];
	}
	




}



