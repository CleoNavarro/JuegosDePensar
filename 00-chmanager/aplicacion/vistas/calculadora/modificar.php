<?php

$this->textoHead= "<script src='/js/nuevaCalculadora.js' defer></script>";

$num_preg = count($preguntas);

echo CHTML::dibujaEtiqueta("div", ["class" => "contenedorForm"], null, false);
echo CHTML::dibujaEtiqueta("h2", ["style" => "text-align: center"], "Nuevo Juego de Calculadora");

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

echo CHTML::campoLabel("Preguntas: ", "num_preguntas");
echo CHTML::campoNumber("num_preguntas", $num_preg, ["id" => "num_preguntas", "disabled" => true]);

echo CHTML::boton("+", ["id" => "preguntamas", "class" => "botonmas"]);
echo CHTML::boton("-", ["id" => "preguntamenos", "class" => "botonmas"]);

for ($i = 1; $i <= $num_preg; $i++){
    echo CHTML::dibujaEtiqueta("hr", ["class" => "separador", "id" => "separador".$i], null. false);

    echo CHTML::campoLabel("Pregunta ".$i.": ", "preguntas[".$i."][enunciado]", ["id" => "labelenunciado".$i]);
    echo CHTML::campoText("preguntas[$i][enunciado]", $preguntas[$i]["enunciado"], ["id" => "textenunciado".$i]);
    
    echo CHTML::campoLabel("Tipo Pregunta", "preguntas[".$i."][cod_tipo]", ["id" => "labeltipo".$i]);
    echo CHTML::campoListaDropDown("preguntas[$i][cod_tipo]", $preguntas[$i]["cod_tipo"], Pregunta::dameTipoDrop(), ["id" => "listtipo".$i]);
    
    echo CHTML::campoLabel("Respuesta (hasta este punto) ", "preguntas[".$i."][cantidad]", ["id" => "labelrespuesta".$i]);
    echo CHTML::campoNumber("preguntas[$i][cantidad]", $preguntas[$i]["cantidad"], ["id" => "textrespuesta".$i]);
}


echo CHTML::campoBotonSubmit("Guardar");
echo CHTML::finalizarForm();

echo CHTML::dibujaEtiquetaCierre("div");