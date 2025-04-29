<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $titulo; ?></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width; initial-scale=1.0;">
	<!--<link rel="stylesheet" id="mapa" type="text/css" href="/estilos/mapa.css" /> -->
	<link rel="stylesheet" type="text/css" href="/estilos/main.css" />
	<!-- <link rel="stylesheet" type="text/css" href="/estilos/accesibilidad.css" /> -->
	<link rel="icon" type="image/png" href="/imagenes/favicon.png" />
	<?php
	if (isset($this->textoHead))
		echo $this->textoHead;
	?>
</head>
<body>

		<header>
			<div class="iniciarSesion">
			<?php

				if (Sistema::app()->Acceso()->hayUsuario()) {
					$usuario = new Usuarios();
					$foto = $usuario::dameFoto(Sistema::app()->Acceso()->getCodUsuario());
					if (!$foto) $foto = "fotoUsuarioPorDefecto.png";
					echo CHTML::imagen("/imagenes/web/usuarios/".$foto, "", ["class" => "fotouser"]);
					echo CHTML::dibujaEtiqueta("span", ["class" => "nick"], 
							Sistema::app()->Acceso()->getNick());
					echo CHTML::link("Cerrar Sesión", ["index", "cerrarSesion"]);
				} else {
					echo CHTML::link("Regístrate", ["index", "registrate"]);
					echo CHTML::link("Iniciar sesión", ["index", "login"]);
				}

			?>
			</div>
			 <div class="logocontainer">
				<div class="logo">
				<a href="/"><img id="logo" src="/imagenes/logo.png" height="100px" /></a>
				</div>
			</div>

			<nav class="barraNav">
			<ul>
				<?php
					if (isset($this->menu)) {
						foreach ($this->menu as $opcion) {
							echo CHTML::dibujaEtiqueta(
								"li",
								array(),
								"",
								false
							);
							echo CHTML::link(
								$opcion["texto"],
								$opcion["enlace"]
							);
							echo CHTML::dibujaEtiquetaCierre("li");
							echo CHTML::dibujaEtiqueta("br") . "\r\n";
						}
					}

					?>
				</ul>
			</nav>
		</header>

		

		

		<?php echo $contenido; ?><!-- #content -->


		

		

	</div><!-- #wrapper -->
</body>

</html>