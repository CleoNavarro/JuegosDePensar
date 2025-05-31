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
	<meta name="viewport" content="width=device-width; initial-scale=1.0;">
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
			<div class="container-boton-menu">
				<label for="boton-menu"><img class="icon-menu" src="/imagenes/icon-menu.png" /></label>
			</div>
			 <div class="logocontainer">
				<div class="logo">
				<a href="/"><img class="logo" id="logoPrincipal" src="/imagenes/logo.png" /></a>
				</div>
			</div>
		</header>

		<div class="contenido">
				
	        <article class="pantallaError">
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
				<a class="boton" href="/">Vuelve a la web :C</a>
	 		</article><!-- #content -->
			
		</div>
		
	<input type="checkbox" id="boton-menu">

	<div class="container-menu">
		<div class="cont-menu">
			<nav class="barraNav">
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
			<a href="http://www.chmanager.com" id="enlaceMNG">Acceso a personal</a>
		</div>
	</div>
	
	</div><!-- #wrapper -->
</body>

</html>