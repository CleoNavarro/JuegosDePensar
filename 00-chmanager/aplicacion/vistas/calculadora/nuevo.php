<?php

$this->textoHead= "<script src='/js/nuevaCalculadora.js' defer></script>";

echo CHTML::dibujaEtiqueta("div", ["class" => "contenedorForm"], null, false);
echo CHTML::dibujaEtiqueta("h2", ["style" => "text-align: center"], "Nuevo Sitio");

echo CHTML::iniciarForm("", "post", ["enctype"=>"multipart/form-data"]);

echo CHTML::modeloLabel($modelo, "titulo");
echo CHTML::modeloText($modelo, "titulo");
echo CHTML::modeloError($modelo, "titulo");





echo CHTML::campoBotonSubmit("Crear");
echo CHTML::finalizarForm();

echo CHTML::dibujaEtiquetaCierre("div");