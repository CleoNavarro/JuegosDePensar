<?php
	 
class intraControlador extends CControlador {

	/**
	 * Variables de entorno
	 */
	public $menu;

	public function accionIndex() {

		$acceso = Sistema::app()->Acceso();

		if (!$acceso->hayUsuario()) {
			Sistema::app()->irAPagina(["intra", "login"]);
            exit;
		}

		if ($acceso->puedePermiso(2)) {
			Sistema::app()->irAPagina("index");
			exit;
		}

		$this->dibujaVista("index",["acceso" => $acceso],"Inicio - Gestión SafePlace");
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
                $acceso->registrarUsuario($login->nick, $acl->getNombre($cod_usuario), $acl->getPermisos($cod_usuario));
                
                   
            }
        }

        if (Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["intra", "index"]);
            exit;
        }  

        $this->dibujaVista("login", array("modelo" => $login), "Login");
			
	}

	
	/**
	 * Función que genera los links del menú para el header
	 */
	// public function menu () : array {

	// 	return [
	// 		[
	// 			"texto" => "Favoritos", 
	// 			"enlace" => ["favoritos"],
	// 			"textcolor" => "red",
	// 			"imagen" => "imagenes/web/iconos/like.png"
	// 		],
	// 		[
	// 			"texto" => "Recientes", 
	// 			"enlace" => ["recientes"],
	// 			"textcolor" => "blue",
	// 			"imagen" => "imagenes/web/iconos/like.png"
	// 		],
	// 		[
	// 			"texto" => "Ajustes", 
	// 			"enlace" => ["ajustes"],
	// 			"textcolor" => "blue",
	// 			"imagen" => "imagenes/web/iconos/like.png"
	// 		],
	// 		[
	// 			"texto" => "Intra", 
	// 			"enlace" => ["intra"],
	// 			"textcolor" => "black",
	// 			"imagen" => "imagenes/usuarios/fotoUsuarioPorDefecto.png"
	// 		],
			
	// 	];
	// }
	




}



