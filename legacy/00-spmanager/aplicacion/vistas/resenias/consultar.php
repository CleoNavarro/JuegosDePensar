<?php

echo CHTML::dibujaEtiqueta("div", ["class" => "contenedorInfo"], null, false);

echo CHTML::dibujaEtiqueta("h2", [], "Reseña:");

    echo CHTML::dibujaEtiqueta("div", ["class" => "datosInfo"], null, false);

        echo CHTML::dibujaEtiqueta("ul", [], null, false);
            echo CHTML::dibujaEtiqueta("li", [], "<b>Fecha de la reseña:</b> ".
                CGeneral::fechahoraMysqlANormal($resenia->fecha));
            echo CHTML::dibujaEtiqueta("li", [], "<b>Reseñador:</b> ".$resenia->nick_reseniador);
            echo CHTML::dibujaEtiqueta("li", [], "<b>Nombre sitio:</b> ".$resenia->nombre_sitio);
            echo CHTML::dibujaEtiqueta("li", [], "<b>Puntuación:</b> ".$resenia->puntuacion." sobre 5");
            echo CHTML::dibujaEtiqueta("li", [], "<b>Título:</b> ".$resenia->titulo);
            echo CHTML::dibujaEtiqueta("li", [], "<b>Descripción:</b> ".$resenia->descripcion);
            echo CHTML::dibujaEtiqueta("li", [], "<b>Borrado:</b> ".$resenia->borrado);
        echo CHTML::dibujaEtiquetaCierre("ul");

    echo CHTML::dibujaEtiquetaCierre("div");

    echo CHTML::dibujaEtiqueta("div", ["class" => "botonesInfo"], null, false);

        $boton1 = CHTML::boton("Ver Sitio");
        echo CHTML::link($boton1, 
            Sistema::app()->generaURL(["sitios","consultar"],
            ["id" => $resenia->cod_sitio]));

        $boton2 = CHTML::boton("Ver Usuario");
        echo CHTML::link($boton2, 
            Sistema::app()->generaURL(["usuarios","consultar"],
            ["id" => $resenia->cod_usuario]));

        $boton3 = CHTML::boton("Borrar Reseña");
        echo CHTML::link($boton3, 
            Sistema::app()->generaURL(["resenias","borrar"],
            ["id" => $resenia->cod_resenia]));

    echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiquetaCierre("div");

