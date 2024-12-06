<?php 

echo CHTML::dibujaEtiqueta("div", ["class" => "contenedorForm"], null, false);
echo CHTML::dibujaEtiqueta("h2", ["style" => "text-align: center"], "Nuevo Sitio");

echo CHTML::iniciarForm("", "post", ["enctype"=>"multipart/form-data"]);

echo CHTML::modeloLabel($modelo, "nombre_sitio");
echo CHTML::modeloText($modelo, "nombre_sitio");
echo CHTML::modeloError($modelo, "nombre_sitio");

echo CHTML::modeloLabel($modelo, "coor_x"); 
echo CHTML::modeloNumber($modelo, "coor_x");
echo CHTML::modeloError($modelo, "coor_x");

echo CHTML::modeloLabel($modelo, "coor_y"); 
echo CHTML::modeloNumber($modelo, "coor_y");
echo CHTML::modeloError($modelo, "coor_y");

echo CHTML::modeloLabel($modelo, "direccion");
echo CHTML::modeloText($modelo, "direccion");
echo CHTML::modeloError($modelo, "direccion");

echo CHTML::modeloLabel($modelo, "poblacion");
echo CHTML::modeloText($modelo, "poblacion");
echo CHTML::modeloError($modelo, "poblacion");

echo CHTML::modeloLabel($modelo, "cp");
echo CHTML::modeloText($modelo, "cp");
echo CHTML::modeloError($modelo, "cp");

echo CHTML::modeloLabel($modelo, "pais");
echo CHTML::modeloText($modelo, "pais");
echo CHTML::modeloError($modelo, "pais");

echo CHTML::modeloLabel($modelo, "descripcion");
echo CHTML::modeloTextArea($modelo, "descripcion");
echo CHTML::modeloError($modelo, "descripcion");

echo CHTML::modeloLabel($modelo, "contacto");
echo CHTML::modeloText($modelo, "contacto");
echo CHTML::modeloError($modelo, "contacto");

echo CHTML::modeloLabel($modelo, "foto");
echo CHTML::modeloFile($modelo, "foto");
echo CHTML::modeloError($modelo, "foto");

// echo CHTML::dibujaEtiqueta("div", [], null, false);
// echo CHTML::modeloLabel($modelo, "corriente_electrica");
// echo CHTML::modeloListaRadioButton($modelo, "corriente_electrica", [0 => "NO", 1 => "SÍ"], "&nbsp");
// echo CHTML::modeloError($modelo, "corriente_electrica");
// echo CHTML::dibujaEtiquetaCierre("div");

// echo CHTML::modeloListaCheckBox();

echo CHTML::campoBotonSubmit("Crear");
echo CHTML::finalizarForm();

echo CHTML::dibujaEtiquetaCierre("div");
echo "<br>".PHP_EOL;