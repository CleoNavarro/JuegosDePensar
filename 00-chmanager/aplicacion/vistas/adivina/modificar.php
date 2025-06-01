<?php

$this->textoHead= "<script src='/js/nuevaAdivina.js' defer></script>";

$num_preg = count($palabras);

echo CHTML::dibujaEtiqueta("div", ["class" => "contenedorForm"], null, false);
echo CHTML::dibujaEtiqueta("h2", ["style" => "text-align: center"], "Modificar Juego de Adivina");

echo CHTML::iniciarForm("", "post", ["enctype"=>"multipart/form-data", "id" => "formulario"]);

echo CHTML::modeloLabel($modelo, "titulo");
echo CHTML::modeloText($modelo, "titulo");
echo CHTML::modeloError($modelo, "titulo");

echo CHTML::modeloLabel($modelo, "fecha");
echo CHTML::modeloDate($modelo, "fecha");
echo CHTML::modeloError($modelo, "fecha");

echo CHTML::modeloLabel($modelo, "cod_dificultad");
echo CHTML::modeloListaDropDown($modelo, "cod_dificultad", 
    Test::dameDificultadDrop()  
);

echo CHTML::campoLabel("Palabras: ", "num_palabras");
echo CHTML::campoNumber("num_palabras", $num_preg, ["id" => "num_palabras", "disabled" => true]);

echo CHTML::boton("+", ["id" => "palabramas", "class" => "botonmas"]);
echo CHTML::boton("-", ["id" => "palabramenos", "class" => "botonmas"]);

for ($i = 1; $i <= $num_preg; $i++){
    echo CHTML::dibujaEtiqueta("hr", ["class" => "separador", "id" => "separador".$i], null. false);

    echo CHTML::campoLabel("Enunciado ".$i.": ", "palabras[".$i."][enunciado]", ["id" => "labelenunciado".$i]);
    echo CHTML::campoText("palabras[".$i."][enunciado]", $palabras[$i]["enunciado"], ["id" => "textenunciado".$i]);
    
    echo CHTML::campoLabel("Siglas", "preguntas[".$i."][siglas]", ["id" => "labelsiglas".$i]);
    echo CHTML::campoText("palabras[".$i."][siglas]", $palabras[$i]["siglas"], ["id" => "textsiglas".$i]);
    
    echo CHTML::campoLabel("Respuesta", "palabras[".$i."][respuesta]", ["id" => "labelrespuesta".$i]);
    echo CHTML::campoText("palabras[".$i."][respuesta]", $palabras[$i]["respuesta"], ["id" => "textrespuesta".$i]);
}


echo CHTML::campoBotonSubmit("Guardar");
echo CHTML::finalizarForm();

echo CHTML::dibujaEtiquetaCierre("div");