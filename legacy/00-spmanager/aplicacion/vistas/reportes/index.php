<?php

$this->textoHead=CCaja::requisitos();
$this->textoHead.=CPager::requisitos();

echo CHTML::dibujaEtiqueta("div", ["class" => "formulario"],null, false);

$cajaFiltrado=new CCaja("Buscar reportes por parámetros");

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
        echo CHTML::modeloLabel($modelo, "nick_reportador");
        echo CHTML::modeloText($modelo, "nick_reportador",
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

$cadenaLink = "nombre_sitio=".$filtrado["nombre_sitio"]."&nick_reportador=".$filtrado["nick_reportador"];

$paginado = new CPager($pag);
echo $paginado->dibujate();

$tabla = new CGrid ($cab, $fil, ["class" => "tabla1"]);
echo $tabla->dibujate();

echo $paginado->dibujate();

