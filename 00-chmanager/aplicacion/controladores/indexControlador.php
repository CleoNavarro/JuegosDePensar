<?php
	 
class indexControlador extends CControlador {

	/**
	 * Variables de entorno
	 */

	public function accionIndex() {

		$acceso = Sistema::app()->Acceso();

		if (!$acceso->hayUsuario()) {
			Sistema::app()->irAPagina(["index", "login"]);
            exit;
		}
		

		if ($acceso->puedePermiso(2)) {
			Sistema::app()->paginaError(502, "No tienes permiso para aceder aquí");
			exit;
		}

		$this->menu = $this->crearMenu($acceso);

		$tabCalculadora = false;
		$tabAdivina = false;
		$tabUsuarios = false;

		if ($acceso->puedePermiso(5)) 
			$tabCalculadora = $this->tablaCalculadora();
		

		if ($acceso->puedePermiso(6)) 
			$tabAdivina = $this->tablaAdivina();
		

		if ($acceso->puedePermiso(4)) 
		 	$tabUsuarios = $this->tablaUsuarios();
		

		$this->dibujaVista("index",
			["acceso" => $acceso, "calculadora" => $tabCalculadora, "adivina" => $tabAdivina, 
			"usuarios" => $tabUsuarios], "Inicio - CH Manager");

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
                $acceso->registrarUsuario($cod_usuario, $login->nick, $acl->getNombre($cod_usuario), $acl->getPermisos($cod_usuario));   
            }
        }

        if (Sistema::app()->Acceso()->hayUsuario()) {

			if ($acceso->puedePermiso(2)) {
				Sistema::app()->paginaError(502, "No tienes permiso para acceder aquí");
			}

            Sistema::app()->irAPagina(["index", "index"]);
            exit;
        }  

        $this->dibujaVista("login", array("modelo" => $login), "Login");
			
	}

	public function accionCerrarSesion () {

        Sistema::app()->Acceso()->quitarRegistroUsuario();

        Sistema::app()->irAPagina(["index", "login"]); 
		exit;

    }

	
	/**
	 * Función que genera los links del menú para el header
	 */
	public function crearMenu (CAcceso $acceso) : array {

		$arrayMenu = [];
		$perm4 = false; $perm5 = false; $perm6 = false; 

		if ($acceso->puedePermiso(1)) {
			$perm4 = true; $perm5 = true; $perm6 = true; 
		} else {
			$perm4 = $acceso->puedePermiso(4);
			$perm5 = $acceso->puedePermiso(5);
			$perm6 = $acceso->puedePermiso(6);
		}

		if ($perm4) array_push($arrayMenu, ["texto" => "Usuarios", "enlace" => ["usuarios"]]);
		if ($perm5) array_push($arrayMenu, ["texto" => "Calculadora", "enlace" => ["calculadora"]]);
		if ($perm6) array_push($arrayMenu, ["texto" => "Adivina", "enlace" => ["adivina"]]);

		return $arrayMenu;
	}


	/**
	 * Crea la tabla Calculadora en el menú principal
	 */
	public function tablaCalculadora () : mixed  {

		$test = new Test();

		$condiciones = ["select" => "t.*", "where" => " t.borrado_fecha IS NULL ", 
			"order" => " t.creado_fecha desc", "limit" => "5"];
		
		$filas = $test->buscarTodos($condiciones);

       if (!$filas) return false;

       foreach ($filas as $clave=>$fila) {

			$iconoBorrar = "borrar";
            $fila["fecha"] = CGeneral::fechaMysqlANormal($fila["fecha"]);
            $fila["creado_fecha"] = CGeneral::fechahoraMysqlANormal($fila["creado_fecha"]);
            if (!is_null($fila["borrado_fecha"])) {
                $fila["borrado"] = "SI";
                $fila["borrado_fecha"] = CGeneral::fechahoraMysqlANormal($fila["borrado_fecha"]);
				$iconoBorrar = "recuperar";
            } 
            else $fila["borrado"] = "NO";

            $fila["oper"] = CHTML::link(CHTML::imagen("/imagenes/24x24/ver.png", "", ["class" => "icon-tabla"]),
                                       Sistema::app()->generaURL(["calculadora","consultar"],
                                       ["id" => $fila["cod_test"]]))." ".
                            CHTML::link(CHTML::imagen("/imagenes/24x24/modificar.png", "", ["class" => "icon-tabla"]),
                                       Sistema::app()->generaURL(["calculadora","modificar"],
                                       ["id" => $fila["cod_test"]]))." ".
                            CHTML::link(CHTML::imagen("/imagenes/24x24/$iconoBorrar.png", "", ["class" => "icon-tabla"]),
                                       Sistema::app()->generaURL(["calculadora","borrar"],
                                       ["id" => $fila["cod_test"]]));
           $filas[$clave] = $fila;
       }

        $cabecera = [
			["ETIQUETA" => "FECHA TEST", "CAMPO" => "fecha", "ALINEA" => "cen"],
			["ETIQUETA" => "TÍTULO", "CAMPO" => "titulo", "ALINEA" => "cen"],
			["ETIQUETA" => "DIFICULTAD", "CAMPO" => "dificultad", "ALINEA" => "cen"],
			["ETIQUETA" => "PREGUNTAS", "CAMPO" => "num_preguntas", "ALINEA" => "cen"],
			["ETIQUETA" => "BORRADO", "CAMPO" => "borrado", "ALINEA" => "cen"],
			["ETIQUETA" => "OPERACIONES", "CAMPO" => "oper", "ALINEA" => "cen"],
		];

		return [
			"cab" => $cabecera,
			"fil" => $filas
		];
    }


	/**
	 * Crea la tabla Adivina en el menú principal
	 */
	public function tablaAdivina () : mixed  {

		$adivina = new Adivina();

		$condiciones = ["select" => "t.*", "where" => " t.borrado_fecha IS NULL ", 
			"order" => " t.creado_fecha desc", "limit" => "5"];
		
		$filas = $adivina->buscarTodos($condiciones);

       if (!$filas) return false;

       foreach ($filas as $clave=>$fila) {

			$iconoBorrar = "borrar";
            $fila["fecha"] = CGeneral::fechaMysqlANormal($fila["fecha"]);
            $fila["creado_fecha"] = CGeneral::fechahoraMysqlANormal($fila["creado_fecha"]);
            if (!is_null($fila["borrado_fecha"])) {
                $fila["borrado"] = "SI";
                $fila["borrado_fecha"] = CGeneral::fechahoraMysqlANormal($fila["borrado_fecha"]);
				$iconoBorrar = "recuperar";
            } 
            else $fila["borrado"] = "NO";

            $fila["oper"] = CHTML::link(CHTML::imagen("/imagenes/24x24/ver.png", "", ["class" => "icon-tabla"]),
                                       Sistema::app()->generaURL(["adivina","consultar"],
                                       ["id" => $fila["cod_adivina"]]))." ".
                            CHTML::link(CHTML::imagen("/imagenes/24x24/modificar.png", "", ["class" => "icon-tabla"]),
                                       Sistema::app()->generaURL(["adivina","modificar"],
                                       ["id" => $fila["cod_adivina"]]))." ".
                            CHTML::link(CHTML::imagen("/imagenes/24x24/$iconoBorrar.png", "", ["class" => "icon-tabla"]),
                                       Sistema::app()->generaURL(["adivina","borrar"],
                                       ["id" => $fila["cod_adivina"]]));
           $filas[$clave] = $fila;
       }

        $cabecera = [
			["ETIQUETA" => "FECHA JUEGO", "CAMPO" => "fecha", "ALINEA" => "cen"],
			["ETIQUETA" => "TÍTULO", "CAMPO" => "titulo", "ALINEA" => "cen"],
			["ETIQUETA" => "DIFICULTAD", "CAMPO" => "dificultad", "ALINEA" => "cen"],
			["ETIQUETA" => "PALABRAS", "CAMPO" => "num_palabras", "ALINEA" => "cen"],
			["ETIQUETA" => "BORRADO", "CAMPO" => "borrado", "ALINEA" => "cen"],
			["ETIQUETA" => "OPERACIONES", "CAMPO" => "oper", "ALINEA" => "cen"],
		];

		return [
			"cab" => $cabecera,
			"fil" => $filas
		];
	}


	/**
	 * Crea la tabla Usuarios en el menú principal
	 */
	public function tablaUsuarios () : mixed  {

		$usuarios = new Usuarios();

		$condiciones = ["select" => "t.*", "where" => " t.borrado = 0 ", 
			"order" => " t.fecha_registrado desc", "limit" => "5"];
		
		$filas = $usuarios->buscarTodos($condiciones);

       	if (!$filas) return false;

        foreach ($filas as $clave=>$fila) {

			$iconoBorrar = "borrar";
            if ($fila["borrado"]==0) $fila["borrado"] = "NO";
            else {
				$fila["borrado"] = "SI";
				$iconoBorrar = "recuperar";
			}

			if (is_null($fila["verificado"])) $fila["verificado"] = "NO";
            else $fila["verificado"] = "SI";

            $fila["foto"] = CHTML::imagen(RUTA_IMAGEN.$fila["foto"],
                                            "Foto ".$fila["nombre"],
                                        ["style" => "width: 50px; height: 50px;"]);

			$fila["oper"] = CHTML::link(CHTML::imagen("/imagenes/24x24/ver.png", "", ["class" => "icon-tabla"]),
				                        Sistema::app()->generaURL(["usuarios","consultar"],
										["id" => $fila["cod_usuario"]]))." ".
                            CHTML::link(CHTML::imagen("/imagenes/24x24/modificar.png", "", ["class" => "icon-tabla"]),
				                        Sistema::app()->generaURL(["usuarios","modificar"],
										["id" => $fila["cod_usuario"]]))." ".
                            CHTML::link(CHTML::imagen("/imagenes/24x24/$iconoBorrar.png", "", ["class" => "icon-tabla"]),
				                        Sistema::app()->generaURL(["usuarios","borrar"],
										["id" => $fila["cod_usuario"]]));
			$filas[$clave] = $fila;
		}

        $cabecera = [
			["ETIQUETA" => "NOMBRE", "CAMPO" => "nombre", "ALINEA" => "cen"],
			["ETIQUETA" => "NICK", "CAMPO" => "nick", "NICK" => "cen"],
			["ETIQUETA" => "FOTO", "CAMPO" => "foto", "ALINEA" => "cen"],
			["ETIQUETA" => "MAIL", "CAMPO" => "mail", "ALINEA" => "cen"],
            ["ETIQUETA" => "ROL", "CAMPO" => "nombre_rol", "ALINEA" => "cen"],
			["ETIQUETA" => "VERIFICADO", "CAMPO" => "verificado", "ALINEA" => "cen"],
            ["ETIQUETA" => "BORRADO", "CAMPO" => "borrado", "ALINEA" => "cen"],
			["ETIQUETA" => "OPERACIONES", "CAMPO" => "oper", "ALINEA" => "cen"],
		];

		return [
			"cab" => $cabecera,
			"fil" => $filas
		];
    }

}



