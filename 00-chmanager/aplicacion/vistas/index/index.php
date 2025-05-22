<?php

echo CHTML::dibujaEtiqueta("h1", [] , "PANEL DE CONTROL", true);

if ($calculadora) {
    echo CHTML::dibujaEtiqueta("h2", [] , "Nuevos juegos de Calculadora Humana", true);
    $tablaCalc = new CGrid ($calculadora["cab"], $calculadora["fil"], ["class" => "tabla1"]);
    echo $tablaCalc->dibujate();
}

if ($adivina) {
    echo CHTML::dibujaEtiqueta("h2", [] , "Nuevos juegos de Adivina la Palabra", true);
    $tablaAdivina = new CGrid ($adivina["cab"], $adivina["fil"], ["class" => "tabla1"]);
    echo $tablaAdivina->dibujate();
}

if ($usuarios) {
    echo CHTML::dibujaEtiqueta("h2", [] , "Nuevos usuarios", true);
    $tablaUsuarios = new CGrid ($usuarios["cab"], $usuarios["fil"], ["class" => "tabla1"]);
    echo $tablaUsuarios->dibujate();
}






