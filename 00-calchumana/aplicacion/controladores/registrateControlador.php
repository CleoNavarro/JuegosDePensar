<?php

class registrateControlador extends CControlador {

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
   
    public function accionIndex () {

		$this->menu = $this->menu();
       
        $usuarios = new Usuarios();

        if ($_POST) {
            $nombre = $usuarios->getNombre();

            if(isset($_FILES["usuarios"])) {
				$nombre_imagen = $_FILES['usuarios']['tmp_name']["foto"];
				//Guardamos tambien la ruta a donde ira
				$ruta = RUTA_IMAGEN.$_FILES["usuarios"]["name"]["foto"];
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
                   $this->dibujaVista("index", array("modelo"=>$usuarios), "Regístrate - JUEGOS DE PENSAR");
                   exit;
               }

			   $usuarioACL = new UsuariosACL();
			   $usuarioACL->setValores($_POST[$nombre]);
			   if ($usuarioACL->validar() ) {
					if (!$usuarioACL->guardar()) {
						$this->dibujaVista("index", array("modelo"=>$usuarios), "Regístrate - JUEGOS DE PENSAR");
						exit;
					}

			   }

			   $login = new Login();
			   $login->setValores($_POST[$nombre]);

			   if ($login->validar())  {
				   $acl = Sistema::app()->ACL();
				   $acceso = Sistema::app()->Acceso();
				   $cod_usuario = $acl->getCodUsuario($login->nick);
				   $permisos = $acl->getPermisos($cod_usuario);
				   $acceso->registrarUsuario($cod_usuario, $login->nick, $acl->getNombre($cod_usuario), $permisos);   
			   }

               Sistema::app()->irAPagina(array("index")); 
               exit;
           }
        }

        $this->dibujaVista("index", array("modelo" => $usuarios), "Regístrate - JUEGOS DE PENSAR");
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