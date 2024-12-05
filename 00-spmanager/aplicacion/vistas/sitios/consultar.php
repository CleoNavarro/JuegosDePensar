<?php

echo CHTML::dibujaEtiqueta("div", ["class" => "contenedorInfo"], null, false);

echo CHTML::dibujaEtiqueta("h2", [], "Datos del sitio:");

    echo CHTML::dibujaEtiqueta("div", ["class" => "datosInfo"], null, false);

        echo CHTML::imagen("/imagenes/sitios/".$sitio->foto, "Foto ".$sitio->nombre_sitio, 
                            ["class" => "imagenInfo"] );

        echo CHTML::dibujaEtiqueta("ul", [], null, false);
            echo CHTML::dibujaEtiqueta("li", [], "Nombre sitio: ".$sitio->nombre_sitio);
            echo CHTML::dibujaEtiqueta("li", [], "Coordenadas: X ".$sitio->coor_x." Y ".$sitio->coor_y);
            echo CHTML::dibujaEtiqueta("li", [], "Dirección: ".$sitio->direccion.", ".
                $sitio->poblacion." (".$sitio->cp."), ".$sitio->provincia.", ".$sitio->pais);
            echo CHTML::dibujaEtiqueta("li", [], "Descripcion: ".$sitio->descripcion);
            echo CHTML::dibujaEtiqueta("li", [], "Contacto: ".$sitio->contacto);
            echo CHTML::dibujaEtiqueta("li", [], "Borrado: ".$sitio->borrado);
        echo CHTML::dibujaEtiquetaCierre("ul");

    echo CHTML::dibujaEtiquetaCierre("div");

    echo CHTML::dibujaEtiqueta("div", ["class" => "botonesInfo"], null, false);

        $boton1 = CHTML::boton("Modificar sitio");
        echo CHTML::link($boton1, 
            Sistema::app()->generaURL(["sitios","modificar"],
            ["id" => $sitio->cod_sitio]));

        $boton2 = CHTML::boton("Borrar sitio");
        echo CHTML::link($boton2, 
            Sistema::app()->generaURL(["sitios","borrar"],
            ["id" => $sitio->cod_sitio]));

    echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiquetaCierre("div");

