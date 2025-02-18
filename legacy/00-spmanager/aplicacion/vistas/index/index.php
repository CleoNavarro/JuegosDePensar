<?php

echo CHTML::dibujaEtiqueta("h1", [] , "PANEL DE CONTROL", true);

if ($sugerencias) {
    echo CHTML::dibujaEtiqueta("h2", [] , "Nuevas sugerencias", true);
    $tablaSugerencias = new CGrid ($sugerencias["cab"], $sugerencias["fil"], ["class" => "tabla1"]);
    echo $tablaSugerencias->dibujate();
}

if ($reportes) {
    echo CHTML::dibujaEtiqueta("h2", [] , "Nuevos reportes", true);
    $tablaReportes = new CGrid ($reportes["cab"], $reportes["fil"], ["class" => "tabla1"]);
    echo $tablaReportes->dibujate();
}

if ($resenias) {
    echo CHTML::dibujaEtiqueta("h2", [] , "Nuevas reseñas", true);
    $tablaResenias = new CGrid ($resenias["cab"], $resenias["fil"], ["class" => "tabla1"]);
    echo $tablaResenias->dibujate();
}








