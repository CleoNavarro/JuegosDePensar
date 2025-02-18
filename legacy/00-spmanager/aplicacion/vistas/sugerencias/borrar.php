<?php

echo CHTML::dibujaEtiqueta("div", ["class" => "contenedorForm"], null, false);
    echo CHTML::dibujaEtiqueta("h2", [], "Anular Sugerencia:");

    echo CHTML::iniciarForm();

        echo CHTML::dibujaEtiqueta("div", [], null, false);
            echo CHTML::modeloLabel($sugerencia, "anulado");
            echo CHTML::modeloListaRadioButton($sugerencia, "anulado", [1 => "SI", 0 => "NO"], "&nbsp");
            
        echo CHTML::dibujaEtiquetaCierre("div");

        echo CHTML::campoBotonSubmit("Guardar cambios");
    echo CHTML::finalizarForm();

echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiqueta("div", ["class" => "contenedorInfo"], null, false);

echo CHTML::dibujaEtiqueta("h2", [], "Datos de la sugerencia:");

    echo CHTML::dibujaEtiqueta("div", ["class" => "datosInfo"], null, false);

    if ($sugerencia->foto!="") {
        echo CHTML::imagen("/imagenes/sugerencias/".$sugerencia->foto, "Foto ".$sugerencia->nombre_sitio, 
                        ["class" => "imagenInfo"] );
    }
    echo CHTML::dibujaEtiqueta("ul", [], null, false);
        echo CHTML::dibujaEtiqueta("li", [], "<b>Fecha y hora de la sugerencia:</b> ".$sugerencia->fecha);
        echo CHTML::dibujaEtiqueta("li", [], "<b>Nombre sitio:</b> ".$sugerencia->nombre_sitio);
        echo CHTML::dibujaEtiqueta("li", [], "<b>Dirección:</b> ".$sugerencia->direccion.", ".$sugerencia->poblacion);
        echo CHTML::dibujaEtiqueta("li", [], "<b>Comentario:</b> ".$sugerencia->comentario);
        echo CHTML::dibujaEtiqueta("li", [], "<b>Mail de quien lo ha solicitado:</b> ".$sugerencia->mail_contacto);
        echo CHTML::dibujaEtiqueta("li", [], "<b>Anulada:</b> ".$sugerencia->anulado);
    echo CHTML::dibujaEtiquetaCierre("ul");

    echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiquetaCierre("div");