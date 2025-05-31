<?php

$this->textoHead=CCaja::requisitos();
$this->textoHead.=CPager::requisitos();

echo CHTML::dibujaEtiqueta("div", ["class" => "formulario"],null, false);

$cajaFiltrado=new CCaja("Buscar juego por parámetros");

//dibuja el html correspondiente a apertura de caja
echo $cajaFiltrado->dibujaApertura();
    echo CHTML::iniciarForm();
        echo CHTML::modeloLabel($modelo, "fecha");
        echo CHTML::modeloDate($modelo, "fecha" );
        echo "<br>".PHP_EOL;

        echo CHTML::modeloLabel($modelo, "titulo");
        echo CHTML::modeloText($modelo, "titulo",
            array(
                "size"=>40
            )
        );
        echo "<br>".PHP_EOL;
        echo CHTML::modeloLabel($modelo, "cod_dificultad");
        echo CHTML::modeloListaDropDown($modelo, "cod_dificultad", 
            Test::dameDificultadDrop()
        );
        echo "<br>".PHP_EOL;

        echo CHTML::campoBotonSubmit("Buscar");
    echo CHTML::finalizarForm();
echo $cajaFiltrado->dibujaFin();

echo CHTML::dibujaEtiquetaCierre("div");
echo "<br>".PHP_EOL;

$cadenaLink = "fecha=".$filtrado["fecha"]."&titulo=".$filtrado["titulo"]."&cod_dificultad=".$filtrado["cod_dificultad"];

$paginado = new CPager($pag);
echo $paginado->dibujate();

$tabla = new CGrid ($cab, $fil, ["class" => "tabla1"]);
echo $tabla->dibujate();

echo $paginado->dibujate();

