<?php

echo CHTML::dibujaEtiqueta("div", ["class" => "contenedorInfo"], null, false);

echo CHTML::dibujaEtiqueta("h2", [], "Datos del juego de Adivina:");

    echo CHTML::dibujaEtiqueta("div", ["class" => "datosInfo"], null, false);

        echo CHTML::dibujaEtiqueta("ul", [], null, false);
            echo CHTML::dibujaEtiqueta("li", [], "Fecha del test: ".$adivina->fecha);
            echo CHTML::dibujaEtiqueta("li", [], "Título: ".$adivina->titulo);
            echo CHTML::dibujaEtiqueta("li", [], "Dificultad: ".$adivina->dificultad);
            echo CHTML::dibujaEtiqueta("li", [], "Cantidad de palabras: ".$adivina->num_palabras);
            echo CHTML::dibujaEtiqueta("li", [], "Puntuación Máxima: ".$adivina->puntuacion_base);
            echo CHTML::dibujaEtiqueta("li", [], "Fecha de creación: ".$adivina->creado_fecha);
            echo CHTML::dibujaEtiqueta("li", [], "Autor: ".$adivina->autor);
            echo CHTML::dibujaEtiqueta("li", [], "Borrado: ".$borr);
        echo CHTML::dibujaEtiquetaCierre("ul");

    echo CHTML::dibujaEtiquetaCierre("div");

    echo CHTML::dibujaEtiqueta("div", ["class" => "botonesInfo"], null, false);

        $boton1 = CHTML::boton("Modificar juego");
        echo CHTML::link($boton1, 
            Sistema::app()->generaURL(["adivina","modificar"],
            ["id" => $adivina->cod_adivina]));

        $boton2 = CHTML::boton("Borrar juego");
        echo CHTML::link($boton2, 
            Sistema::app()->generaURL(["adivina","borrar"],
            ["id" => $adivina->cod_adivina]));

    echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiqueta("div", ["class" => "contenedorInfo"], null, false);

echo CHTML::dibujaEtiqueta("h2", [], "Palabras");

    echo CHTML::dibujaEtiqueta("div", ["class" => "datosInfo2"], null, false);

        foreach ($palabras as $palabra) {
            echo CHTML::dibujaEtiqueta("ul", [], null, false);
                echo CHTML::dibujaEtiqueta("li", [], "Palabra Nº".$palabra["orden"]);
                echo CHTML::dibujaEtiqueta("li", [], "Enunciado: ".$palabra["enunciado"]);
                echo CHTML::dibujaEtiqueta("li", [], "Siglas: ".$palabra["siglas"]);
                echo CHTML::dibujaEtiqueta("li", [], "Respuesta: ".$palabra["respuesta"]);
            echo CHTML::dibujaEtiquetaCierre("ul");
        }

    echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiquetaCierre("div");