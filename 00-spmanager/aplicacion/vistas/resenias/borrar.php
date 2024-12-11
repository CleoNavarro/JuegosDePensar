<?php

echo CHTML::dibujaEtiqueta("div", ["class" => "contenedorForm"], null, false);
    echo CHTML::dibujaEtiqueta("h2", [], "Anular Reseña:");

    echo CHTML::iniciarForm();

        echo CHTML::dibujaEtiqueta("div", [], null, false);
            echo CHTML::modeloLabel($resenia, "borrado");
            echo CHTML::modeloListaRadioButton($resenia, "borrado", [1 => "SI", 0 => "NO"], "&nbsp");
            
        echo CHTML::dibujaEtiquetaCierre("div");

        echo CHTML::campoBotonSubmit("Guardar cambios");
    echo CHTML::finalizarForm();

echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiqueta("div", ["class" => "contenedorInfo"], null, false);

echo CHTML::dibujaEtiqueta("h2", [], "Datos de la reseña:");

    echo CHTML::dibujaEtiqueta("div", ["class" => "datosInfo"], null, false);

    echo CHTML::dibujaEtiqueta("ul", [], null, false);
        echo CHTML::dibujaEtiqueta("li", [], "<b>Fecha de la reseña:</b> ".
            CGeneral::fechahoraMysqlANormal($resenia->fecha));
        echo CHTML::dibujaEtiqueta("li", [], "<b>Reseñador:</b> ".$resenia->nick_reseniador);
        echo CHTML::dibujaEtiqueta("li", [], "<b>Nombre sitio:</b> ".$resenia->nombre_sitio);
        echo CHTML::dibujaEtiqueta("li", [], "<b>Puntuación:</b> ".$resenia->puntuacion." sobre 5");
        echo CHTML::dibujaEtiqueta("li", [], "<b>Título:</b> ".$resenia->titulo);
        echo CHTML::dibujaEtiqueta("li", [], "<b>Descripción:</b> ".$resenia->descripcion);
        echo CHTML::dibujaEtiqueta("li", [], "<b>Borrado:</b> ".$resenia->borrado);
    echo CHTML::dibujaEtiquetaCierre("ul");

    echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiquetaCierre("div");