<?php

echo CHTML::dibujaEtiqueta("div", ["class" => "contenedorInfo"], null, false);

echo CHTML::dibujaEtiqueta("h2", [], "Sugerencia recibida:");

    echo CHTML::dibujaEtiqueta("div", ["class" => "datosInfo"], null, false);

        if ($sugerencia->foto!="") {
            echo CHTML::imagen("/imagenes/sugerencias/".$sugerencia->foto, "Foto ".$sugerencia->nombre_sitio, 
                            ["class" => "imagenInfo"] );
        }
        echo CHTML::dibujaEtiqueta("ul", [], null, false);
            echo CHTML::dibujaEtiqueta("li", [], "<b>Fecha y hora de la sugerencia:</b> ".$sugerencia->fecha);
            echo CHTML::dibujaEtiqueta("li", [], "<b>Nombre sitio:</b> ".$sugerencia->nombre_sitio);
            echo CHTML::dibujaEtiqueta("li", [], "<b>Dirección:</b> ".$sugerencia->direccion.", ".$sugerencia->poblacion);
            echo CHTML::dibujaEtiqueta("li", [], "<b>Comentario:</b> ".$sugerencia->comentario);
            echo CHTML::dibujaEtiqueta("li", [], "<b>Mail de quien lo ha solicitado:</b> ".$sugerencia->mail_contacto);
            echo CHTML::dibujaEtiqueta("li", [], "<b>Anulada:</b> ".$sugerencia->anulado);
        echo CHTML::dibujaEtiquetaCierre("ul");

    echo CHTML::dibujaEtiquetaCierre("div");

    echo CHTML::dibujaEtiqueta("div", ["class" => "botonesInfo"], null, false);

        $boton1 = CHTML::boton("Crear sitio a partir de esta sugerencia");
        echo CHTML::link($boton1, 
            Sistema::app()->generaURL(["sitios","nuevo"],
            ["sugerencia" => $sugerencia->cod_sugerencia]));

        $boton2 = CHTML::boton("Anular sugerencia");
        echo CHTML::link($boton2, 
            Sistema::app()->generaURL(["sugerencias","borrar"],
            ["id" => $sugerencia->cod_sugerencia]));

    echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiquetaCierre("div");

