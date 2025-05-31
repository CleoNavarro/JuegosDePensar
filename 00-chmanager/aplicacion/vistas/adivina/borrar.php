<?php

echo CHTML::dibujaEtiqueta("div", ["class" => "contenedorForm"], null, false);

if ($borr==1) 
    echo CHTML::dibujaEtiqueta("h2", [], "Recuperar Juego de Adivina:");
else
    echo CHTML::dibujaEtiqueta("h2", [], "Borrar Juego de Adivina:");

echo CHTML::iniciarForm();
    if ($borr==1) {
        echo CHTML::dibujaEtiqueta("label", ["for" => "recuperar"], 
        "<b>¿Quieres recuperar los datos de este juego?</b><br>");

        echo CHTML::dibujaEtiqueta("div", [], null, false);
            echo CHTML::campoCheckBox("recuperar",
                false, ["id" => "recuperar", "value" => "si"]);
            echo "Quiero recuperar los datos de este juego";
        echo CHTML::dibujaEtiquetaCierre("div");

        echo CHTML::campoBotonSubmit("Recuperar");
    } else {
        echo CHTML::dibujaEtiqueta("label", ["for" => "borrar"], 
        "<b>¿Quieres borrar los datos de este juego?</b><br>");
        echo CHTML::dibujaEtiqueta("div", [], null, false);
            echo CHTML::campoCheckBox("borrar",
                false, ["id" => "borrar", "value" => "si"]);
            echo "Entiendo las consecuencias y quiero borrar estos datos";
        echo CHTML::dibujaEtiquetaCierre("div");

        echo CHTML::campoBotonSubmit("Borrar");
    }
echo CHTML::finalizarForm();

echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiqueta("div", ["class" => "contenedorInfo"], null, false);

echo CHTML::dibujaEtiqueta("h2", [], "Datos del juego de Adivina:");

    echo CHTML::dibujaEtiqueta("div", ["class" => "datosInfo"], null, false);

        echo CHTML::dibujaEtiqueta("ul", [], null, false);
            echo CHTML::dibujaEtiqueta("li", [], "Fecha del test: ".$adivina->fecha);
            echo CHTML::dibujaEtiqueta("li", [], "Título: ".$adivina->titulo);
            echo CHTML::dibujaEtiqueta("li", [], "Dificultad: ".$adivina->dificultad);
            echo CHTML::dibujaEtiqueta("li", [], "Cantidad de palabras: ".$adivina->num_palabras);
            echo CHTML::dibujaEtiqueta("li", [], "Puntuación Máxima: ".$adivina->puntuacion_base);
            echo CHTML::dibujaEtiqueta("li", [], "Fecha de creación: ".$adivina->creado_fecha);
            echo CHTML::dibujaEtiqueta("li", [], "Autor: ".$adivina->autor);
        echo CHTML::dibujaEtiquetaCierre("ul");

    echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiqueta("div", ["class" => "contenedorInfo"], null, false);

echo CHTML::dibujaEtiqueta("h2", [], "Palabras");

    echo CHTML::dibujaEtiqueta("div", ["class" => "datosInfo2"], null, false);

        foreach ($palabras as $palabra) {
            echo CHTML::dibujaEtiqueta("ul", [], null, false);
                echo CHTML::dibujaEtiqueta("li", [], "Palabra Nº".$palabra["orden"]);
                echo CHTML::dibujaEtiqueta("li", [], "Enunciado: ".$palabra["enunciado"]);
                echo CHTML::dibujaEtiqueta("li", [], "Siglas: ".$palabra["siglas"]);
                echo CHTML::dibujaEtiqueta("li", [], "Respuesta: ".$palabra["respuesta"]);
            echo CHTML::dibujaEtiquetaCierre("ul");
        }

    echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiquetaCierre("div");