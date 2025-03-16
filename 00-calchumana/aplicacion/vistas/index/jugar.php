<?php

$this->textoHead= "<script src='/js/preguntas.js' defer></script>";

echo CHTML::dibujaEtiqueta("input", ["type" => "hidden", "id" => "cod_test", "value" => $cod_test]);

echo CHTML::dibujaEtiqueta("div", ["id" => "preguntas"]);


// echo "Si ves esto, funciona";



