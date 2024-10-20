<?php

	$config=array("CONTROLADOR"=> array("index"),
				  "RUTAS_INCLUDE"=>array("aplicacion/modelos"),
				  "URL_AMIGABLES"=>true,
				  "VARIABLES"=>array("autor"=>"Cleo Navarro Molina",
				  					"direccion"=>"C/ Cuevas de Jesús, 1 - Antequera (Málaga)",
									"contacto"=>"latitacleo@gmail.com",
									"grupo" => "2º DAW"
								),
				  "BD"=>array("hay"=>true,
								"servidor"=>"localhost",
								"usuario"=>"2daw01",
								"contra"=>"2daw",
								"basedatos"=>"safeplace"),		
				  "SESION"=>array("controlAutomatico"=>true),
				  "ACL"=>array("controlAutomatico"=>true)			
				  );

