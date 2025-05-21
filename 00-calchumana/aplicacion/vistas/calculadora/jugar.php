<?php

$this->textoHead= "<script src='/js/preguntas.js' defer></script>";

echo CHTML::dibujaEtiqueta("input", ["type" => "hidden", "id" => "cod_test", "value" => $cod_test]);

echo CHTML::dibujaEtiqueta("div", ["class" => "contJuego"], null, false);

    echo CHTML::dibujaEtiqueta("div", ["id" => "marcador"], null, false);
        echo CHTML::dibujaEtiqueta("p", ["id" => "tiempo"], "Tiempo: 0:00");
        echo CHTML::dibujaEtiqueta("p", ["id" => "fallos"], "Fallos: 0");
    echo CHTML::dibujaEtiquetaCierre("div");

    echo CHTML::dibujaEtiqueta("section", ["id" => "contenedorTest"], null, false);

        echo CHTML::dibujaEtiqueta("div", ["id" => "sumatorio"], "-");
        echo CHTML::dibujaEtiqueta("div", ["id" => "preguntas"]);

    echo CHTML::dibujaEtiquetaCierre("section");

echo CHTML::dibujaEtiquetaCierre("div");




