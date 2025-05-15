<?php

$this->textoHead= "<script src='/js/test.js' defer></script>";

echo CHTML::dibujaEtiqueta("div", ["class" => "contSelect"], null, false);
    echo CHTML::dibujaEtiqueta("div", ["id" => "test", "class" => "selectJuego"], null, false);
        echo CHTML::imagen("/imagenes/logocalculadora.png", "", ["class" => "logo"]);
    echo CHTML::dibujaEtiquetaCierre("div");
    echo CHTML::dibujaEtiqueta("div", ["id" => "adivina", "class" => "selectJuego"], null, false);
        echo CHTML::imagen("/imagenes/logoadivina.png", "", ["class" => "logo"]);
    echo CHTML::dibujaEtiquetaCierre("div");
echo CHTML::dibujaEtiquetaCierre("div");



