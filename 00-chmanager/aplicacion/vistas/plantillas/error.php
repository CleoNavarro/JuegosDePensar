<?php
	header("HTTP/1.1 $numError $mensaje");
	header("Status: $numError $mensaje");
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>ERROR</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width; initial-scale=1.0">
	<link rel="stylesheet" id="estilo" type="text/css" href="/estilos/intra.css" />
	<link rel="icon" type="image/png" href="/imagenes/favicon.png" />
</head>

<body>
	<div id="todo">
		<header>
			<div class="logocontainer">
				<div class="logo">
				<a href="/index.php"><img src="/imagenes/logo.png" /></a>
				</div>
				<div class="titulo">
				</div>
			</div>

			<div class="container-boton-menu">
				<label for="boton-menu"><img class="icon-menu" src="/imagenes/icon-menu.png" /></label>
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
		

		</header><!-- #header -->


		<input type="checkbox" id="boton-menu">

		<div class="container-menu">
			<div class="cont-menu">
				<nav class="barraLat">
					<?php
						if (isset($this->menu)) {
							foreach ($this->menu as $opcion) {
								echo CHTML::link(
									$opcion["texto"],
									$opcion["enlace"]
								);
							}
						}
						?>
				</nav>
				<label for="boton-menu" class="icon-x">X</label>
			</div>
		</div>

		<div class="contenido">
			
			<aside id="barraUbicacion" class="ubicacion">
				<?php
				if (isset($this->barra_ubi)) {
					$next = false;
					foreach ($this->barra_ubi as $opcion) {
						if ($next) 
							echo CHTML::dibujaEtiqueta("span",[]," >> ");

						echo CHTML::link(
							mb_strtoupper($opcion["texto"]), 
							$opcion["enlace"]
						);
						$next = true;
					}
				}
				?>
			</aside>

			<div class="contenido">
	        	
				<article	article class="pantallaError">
					<br />
					<br />
					<img id="logo_pag_error" src="/imagenes/error_320x320.png" alt="">
					<br />
					<h1><?php echo "Error: ".$numError;?></h1>
					<h1 id="mensaje_pag_error"><?php echo $mensaje;?></h1>
					<br />
					<p >Lo siento D:</p>
					<br />
					<br />
					<a href="/"><input type="button" value="Vuelve a la web :C"></a>
				</article><!-- #content -->
			</div>

		</div>
		<footer>
	
			<!-- <button id="modoOscuro">Modo oscuro</button> -->

			<div>
			<?php

				if (Sistema::app()->Acceso()->hayUsuario()) {
					echo CHTML::dibujaEtiqueta("span", ["class" => "nombre"], 
							"Conectado como ".Sistema::app()->Acceso()->getNombre()." | ");
					echo CHTML::link("Cerrar Sesión", ["index", "cerrarSesion"]);
				} else {
					echo CHTML::link("Acceso a personal", ["index", "login"]);
				}
				echo " / ";
				echo CHTML::link("Ir a Juegos de Pensar", "http://www.juegosdepensar.com");
					
				?>

			</div>
			
			<div>
			<p> <?php echo date("Y") . " © - " . Sistema::app()->autor ?> <br> Todos los Derechos Reservados</p>
			</div>
		</footer><!-- #footer -->

	</div><!-- #wrapper -->
</body>

</html>