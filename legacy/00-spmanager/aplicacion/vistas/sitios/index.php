<?php

$this->textoHead=CCaja::requisitos();
$this->textoHead.=CPager::requisitos();

echo CHTML::dibujaEtiqueta("div", ["class" => "formulario"],null, false);

$cajaFiltrado=new CCaja("Buscar sitios por parámetros");

//dibuja el html correspondiente a apertura de caja
echo $cajaFiltrado->dibujaApertura();
    echo CHTML::iniciarForm();
        echo CHTML::modeloLabel($modelo, "nombre_sitio");
        echo CHTML::modeloText($modelo, "nombre_sitio", 
            array(
                "size"=>40
            )
        );
        echo "<br>".PHP_EOL;
        echo CHTML::modeloLabel($modelo, "poblacion");
        echo CHTML::modeloText($modelo, "poblacion",
            array(
                "size"=>20
            )
        );
        echo "<br>".PHP_EOL;
        echo CHTML::campoBotonSubmit("Buscar");
    echo CHTML::finalizarForm();
echo $cajaFiltrado->dibujaFin();

echo CHTML::dibujaEtiquetaCierre("div");
echo "<br>".PHP_EOL;

$cadenaLink = "nombre_sitio=".$filtrado["nombre_sitio"]."&poblacion=".$filtrado["poblacion"];

$paginado = new CPager($pag);
echo $paginado->dibujate();

$tabla = new CGrid ($cab, $fil, ["class" => "tabla1"]);
echo $tabla->dibujate();

echo $paginado->dibujate();

