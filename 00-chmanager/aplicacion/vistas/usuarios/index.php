<?php

$this->textoHead=CCaja::requisitos();

$this->textoHead.=CPager::requisitos();

echo CHTML::dibujaEtiqueta("div", ["class" => "formulario"],null, false);

$cajaFiltrado=new CCaja("Buscar usuarios");

//dibuja el html correspondiente a apertura de caja
echo $cajaFiltrado->dibujaApertura();

    echo CHTML::iniciarForm();

        echo CHTML::modeloLabel($modelo, "nombre");
        echo CHTML::modeloText($modelo, "nombre",
            array(
                "size"=>10
            )
        );

        echo "<br>".PHP_EOL;
        echo CHTML::modeloLabel($modelo, "nick");
        echo CHTML::modeloText($modelo, "nick",
            array(
                "size"=>10
            )
        );

        echo "<br>".PHP_EOL;
        echo CHTML::modeloLabel($modelo, "mail");
        echo CHTML::modeloText($modelo, "mail",
            array(
                "size"=>20
            )
        );
        echo "<br>".PHP_EOL;
    
        echo CHTML::campoLabel("Registrado desde", "fecha_desde");
        echo CHTML::campoDate("fecha_desde");
        echo "&nbsp";
        echo CHTML::campoLabel("Hasta", "fecha_hasta");
        echo CHTML::campoDate("fecha_hasta");
        echo "<br>".PHP_EOL;

        
        echo CHTML::modeloLabel($modelo, "borrado");
        echo CHTML::modeloListaDropDown($modelo, "borrado", 
            [-1 => "", 0 => "NO", 1 => "SÍ"]
        );
        echo "<br>".PHP_EOL;

        echo CHTML::campoBotonSubmit("Buscar");

    echo CHTML::finalizarForm();

//cierro la caja
echo $cajaFiltrado->dibujaFin();

echo CHTML::dibujaEtiquetaCierre("div");
echo "<br>".PHP_EOL;

$cadenaLink = "nombre=".$filtrado["nombre"]."&nick=".$filtrado["nick"].
                "&mail=".$filtrado["mail"]."&fecha_desde=".$filtrado["fecha_desde"].
                "&fecha_hasta=".$filtrado["fecha_hasta"]."&borrado=".$filtrado["borrado"];

$paginado = new CPager($pag);
echo $paginado->dibujate();

$tabla = new CGrid ($cab, $fil, ["class" => "tabla1"]);
echo $tabla->dibujate();

echo $paginado->dibujate();

