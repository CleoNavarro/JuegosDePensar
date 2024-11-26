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

		$tabSugerencias = false;
		$tabReportes = false;
		$tabResenias = false;

		if ($acceso->puedePermiso(4)) 
			$tabSugerencias = $this->tablaSugerencias();
		

		if ($acceso->puedePermiso(5)) 
			$tabReportes = $this->tablaReportes();
		

		if ($acceso->puedePermiso(6)) 
			$tabResenias = $this->tablaResenias();
		

		$this->dibujaVista("index",
		["acceso" => $acceso, "sugerencias" => $tabSugerencias, "reportes" => $tabReportes, "resenias" => $tabResenias],
		"Inicio - SafePlace Manager");
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

			if ($acceso->puedePermiso(2)) {
				Sistema::app()->paginaError(502, "No tienes permiso para aceder aquí");
			}

            Sistema::app()->irAPagina(["index", "index"]);
            exit;
        }  

        $this->dibujaVista("login", array("modelo" => $login), "Login");
			
	}

	
	/**
	 * Función que genera los links del menú para el header
	 */
	public function crearMenu (CAcceso $acceso) : array {

		$arrayMenu = [];

		$perm3 = false;  $perm4 = false; $perm5 = false; $perm6 = false; $perm7 = false; 

		if ($acceso->puedePermiso(1)) {
			$perm3 = true;  $perm4 = true; $perm5 = true; $perm6 = true; $perm7 = true; 
		} else {
			$perm3 = $acceso->puedePermiso(3);
			$perm4 = $acceso->puedePermiso(4);
			$perm5 = $acceso->puedePermiso(5);
			$perm6 = $acceso->puedePermiso(6);
			$perm7 = $acceso->puedePermiso(7);
		}

		if ($perm3) array_push($arrayMenu, ["texto" => "Sitios", "enlace" => ["sitios"]]);
		if ($perm4) array_push($arrayMenu, ["texto" => "Sugerencias", "enlace" => ["sugerencias"]]);
		if ($perm5) array_push($arrayMenu, ["texto" => "Reportes", "enlace" => ["reportes"]]);
		if ($perm6) array_push($arrayMenu, ["texto" => "Reseñas", "enlace" => ["resenias"]]);
		if ($perm7) array_push($arrayMenu, ["texto" => "Administración", "enlace" => ["admin"]]);

		return $arrayMenu;
	}

	public function tablaSugerencias () : mixed  {

		$sugerencias = new Sugerencias();

		$condiciones = ["select" => "t.*", "where" => " t.leido = 0 ", "order" => " t.fecha desc"];
		
		$filas = $sugerencias->buscarTodos($condiciones);

		if (!$filas) return false;

		foreach ($filas as $clave=>$fila) {

			$fila["fecha"] = CGeneral::fechahoraMysqlANormal($fila["fecha"]);

			$fila["oper"] = CHTML::link(CHTML::imagen("/imagenes/24x24/ver.png"),
						Sistema::app()->generaURL(["sugerencia","consultar"],
									["id" => $fila["cod_sugerencia"]]))."  ".
						CHTML::link(CHTML::imagen("/imagenes/24x24/borrar.png"),
									Sistema::app()->generaURL(["sugerencia","anular"],
									["id" => $fila["cod_sugerencia"]]));
			$filas[$clave] = $fila;
		}

        $cabecera = [
			["ETIQUETA" => "FECHA", "CAMPO" => "fecha", "ALINEA" => "cen"],
			["ETIQUETA" => "NOMBRE SITIO", "CAMPO" => "nombre_sitio", "ALINEA" => "cen"],
			["ETIQUETA" => "DIRECCION", "CAMPO" => "direccion", "ALINEA" => "cen"],
			["ETIQUETA" => "OPERACIONES", "CAMPO" => "oper", "ALINEA" => "cen"],
		];

		return [
			"cab" => $cabecera,
			"fil" => $filas
		];
    }

	public function tablaReportes () : mixed  {

		$reportes = new Reportes();

		$condiciones = ["select" => "t.*", "where" => " t.nuevo IS NULL ", "order" => " t.leido = 0 "];
		
		$filas = $reportes->buscarTodos($condiciones);

		if (!$filas) return false;

		foreach ($filas as $clave=>$fila) {

			$fila["fecha"] = CGeneral::fechahoraMysqlANormal($fila["fecha"]);

			$fila["oper"] = CHTML::link(CHTML::imagen("/imagenes/24x24/ver.png"),
									Sistema::app()->generaURL(["reportes","consultar"],
									["id" => $fila["cod_reporte"]]))."  ".
						CHTML::link(CHTML::imagen("/imagenes/24x24/borrar.png"),
									Sistema::app()->generaURL(["reportes","borrar"],
									["id" => $fila["cod_reporte"]]));
			$filas[$clave] = $fila;
		}

        $cabecera = [
			["ETIQUETA" => "FECHA", "CAMPO" => "fecha", "ALINEA" => "cen"],
			["ETIQUETA" => "REPORTADOR", "CAMPO" => "nick_reportador", "ALINEA" => "cen"],
			["ETIQUETA" => "SITIO REPORTADO", "CAMPO" => "nombre_sitio", "ALINEA" => "cen"],
			["ETIQUETA" => "USUARIO REPORTADO", "CAMPO" => "nick_reseniador", "ALINEA" => "cen"],
			["ETIQUETA" => "OPERACIONES", "CAMPO" => "oper", "ALINEA" => "cen"],
		];

		return [
			"cab" => $cabecera,
			"fil" => $filas
		];
    }

	public function tablaResenias () : mixed  {

		$resenias = new Resenias();

		$condiciones = ["select" => "t.*", "where" => " t.nuevo IS NULL ", "order" => " t.fecha desc"];
		
		$filas = $resenias->buscarTodos($condiciones);

		if (!$filas) return false;

		foreach ($filas as $clave=>$fila) {

			$fila["fecha"] = CGeneral::fechahoraMysqlANormal($fila["fecha"]);

			$fila["puntuacion"] = $fila["puntuacion"] ."/5";

			$fila["oper"] = CHTML::link(CHTML::imagen("/imagenes/24x24/ver.png"),
						Sistema::app()->generaURL(["resenia","consultar"],
									["id" => $fila["cod_resenia"]]))."  ".
						CHTML::link(CHTML::imagen("/imagenes/24x24/borrar.png"),
									Sistema::app()->generaURL(["resenia","borrar"],
									["id" => $fila["cod_resenia"]]));
			$filas[$clave] = $fila;
		}

        $cabecera = [
			["ETIQUETA" => "FECHA", "CAMPO" => "fecha", "ALINEA" => "cen"],
			["ETIQUETA" => "NOMBRE SITIO", "CAMPO" => "nombre_sitio", "ALINEA" => "cen"],
			["ETIQUETA" => "RESEÑADOR", "CAMPO" => "nick_reseniador", "ALINEA" => "cen"],
			["ETIQUETA" => "PUNTUACIÓN", "CAMPO" => "puntuacion", "ALINEA" => "cen"],
			["ETIQUETA" => "OPERACIONES", "CAMPO" => "oper", "ALINEA" => "cen"],
		];

		return [
			"cab" => $cabecera,
			"fil" => $filas
		];
    }
	




}



