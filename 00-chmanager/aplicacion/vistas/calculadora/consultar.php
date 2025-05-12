<?php

echo CHTML::dibujaEtiqueta("div", ["class" => "contenedorInfo"], null, false);

echo CHTML::dibujaEtiqueta("h2", [], "Datos del test:");

    echo CHTML::dibujaEtiqueta("div", ["class" => "datosInfo"], null, false);

        echo CHTML::dibujaEtiqueta("ul", [], null, false);
            echo CHTML::dibujaEtiqueta("li", [], "Fecha del test: ".$test->fecha);
            echo CHTML::dibujaEtiqueta("li", [], "Título: ".$test->titulo);
            echo CHTML::dibujaEtiqueta("li", [], "Dificultad: ".$test->dificultad);
            echo CHTML::dibujaEtiqueta("li", [], "Cantidad de preguntas: ".$test->num_preguntas);
            echo CHTML::dibujaEtiqueta("li", [], "Puntuación Máxima: ".$test->puntuacion_base);
            echo CHTML::dibujaEtiqueta("li", [], "Fecha de creación: ".$test->creado_fecha);
            echo CHTML::dibujaEtiqueta("li", [], "Autor: ".$test->autor);
            echo CHTML::dibujaEtiqueta("li", [], "Borrado: ".$borr);
        echo CHTML::dibujaEtiquetaCierre("ul");

    echo CHTML::dibujaEtiquetaCierre("div");

    echo CHTML::dibujaEtiqueta("div", ["class" => "botonesInfo"], null, false);

        $boton1 = CHTML::boton("Modificar test");
        echo CHTML::link($boton1, 
            Sistema::app()->generaURL(["usuarios","modificar"],
            ["id" => $test->cod_test]));

        $boton2 = CHTML::boton("Borrar test");
        echo CHTML::link($boton2, 
            Sistema::app()->generaURL(["usuarios","borrar"],
            ["id" => $test->cod_test]));

    echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiqueta("div", ["class" => "contenedorInfo"], null, false);

echo CHTML::dibujaEtiqueta("h2", [], "Preguntas");

    echo CHTML::dibujaEtiqueta("div", ["class" => "datosInfo2"], null, false);

        foreach ($preguntas as $pregunta) {
            echo CHTML::dibujaEtiqueta("ul", [], null, false);
                echo CHTML::dibujaEtiqueta("li", [], "Pregunta Nº".$pregunta["orden"]);
                echo CHTML::dibujaEtiqueta("li", [], "Enunciado: ".$pregunta["enunciado"]);
                echo CHTML::dibujaEtiqueta("li", [], "Tipo: ".$pregunta["tipo"]);
                echo CHTML::dibujaEtiqueta("li", [], "Resultado: ".$pregunta["cantidad"]);
            echo CHTML::dibujaEtiquetaCierre("ul");
        }

    echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiquetaCierre("div");