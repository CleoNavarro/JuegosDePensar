<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $titulo; ?></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width; initial-scale=1.0">
	<link rel="stylesheet" id="estilo" type="text/css" href="/estilos/intra.css" />
	<!-- <link rel="stylesheet" type="text/css" href="/estilos/accesibilidad.css" /> -->
	<!-- <script src="/js/main.js" defer></script> -->
	<link rel="icon" type="image/png" href="/imagenes/favicon.png" />
	<?php
	if (isset($this->textoHead))
		echo $this->textoHead;
	?>
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

			<article>
				<?php echo $contenido; ?>
			</article><!-- #content -->

		</div>
		<footer>
	
			<button id="modoOscuro">Modo oscuro</button>

			<div>
			<?php

				if (Sistema::app()->Acceso()->hayUsuario()) {
					echo CHTML::dibujaEtiqueta("span", ["class" => "nombre"], 
							"Conectado como ".Sistema::app()->Acceso()->getNombre()." | ");
					echo CHTML::link("Ir a Panel de Control", ["index"]);
					echo " / ";
					echo CHTML::link("Cerrar Sesión", ["index", "cerrarSesion"]);
				} else {
					echo CHTML::link("Acceso a personal", ["index", "login"]);
				}
				
				?>

			</div>
			
			<div>
			<p>2024 © - <?php echo Sistema::app()->autor ?> <br> Todos los Derechos Reservados</p>
			</div>
		</footer><!-- #footer -->

	</div><!-- #wrapper -->
</body>

</html>