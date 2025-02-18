<?php

echo CHTML::dibujaEtiqueta("div", ["class" => "contenedorForm"], null, false);
    echo CHTML::dibujaEtiqueta("h2", [], "Anular Sitio:");

    echo CHTML::iniciarForm();

        echo CHTML::dibujaEtiqueta("div", [], null, false);
            echo CHTML::modeloLabel($sitio, "borrado");
            echo CHTML::modeloListaRadioButton($sitio, "borrado", [1 => "SI", 0 => "NO"], "&nbsp");
            
        echo CHTML::dibujaEtiquetaCierre("div");

        echo CHTML::campoBotonSubmit("Guardar cambios");
    echo CHTML::finalizarForm();

echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiqueta("div", ["class" => "contenedorInfo"], null, false);

echo CHTML::dibujaEtiqueta("h2", [], "Datos del sitio:");

    echo CHTML::dibujaEtiqueta("div", ["class" => "datosInfo"], null, false);

        echo CHTML::imagen("/imagenes/sitios/".$sitio->foto, "Foto ".$sitio->nombre_sitio, 
                            ["class" => "imagenInfo"] );

        echo CHTML::dibujaEtiqueta("ul", [], null, false);
            echo CHTML::dibujaEtiqueta("li", [], "<b>Nombre sitio:</b> ".$sitio->nombre_sitio);
            $stringCat = "";
            if ($cat) {foreach ($cat as $categoria) {$stringCat .= $categoria["nombre_cat"] . " ";}}
            echo CHTML::dibujaEtiqueta("li", [], "<b>Categorias:</b> ".$stringCat);
            echo CHTML::dibujaEtiqueta("li", [], "<b>Coordenadas:</b> X ".$sitio->coor_x." Y ".$sitio->coor_y);
            echo CHTML::dibujaEtiqueta("li", [], "<b>Dirección:</b> ".$sitio->direccion.", ".
                $sitio->poblacion." (".$sitio->cp."), ".$sitio->provincia.", ".$sitio->pais);
            echo CHTML::dibujaEtiqueta("li", [], "<b>Descripcion:</b> ".$sitio->descripcion);
            echo CHTML::dibujaEtiqueta("li", [], "<b>Contacto:</b> ".$sitio->contacto);
            echo CHTML::dibujaEtiqueta("li", [], "<b>Borrado:</b> ".$sitio->borrado);
            if ($caract){
                echo CHTML::dibujaEtiqueta("li", ["style" => "font-weight: bold;"], "Características: ");
                echo CHTML::dibujaEtiqueta("ul", [], null, false);
                foreach ($caract as $caracteristica) {
                    echo CHTML::dibujaEtiqueta("li", [], $caracteristica["nombre_caract"]);
                }
                echo CHTML::dibujaEtiquetaCierre("ul");
            }
            if ($comu){
                echo CHTML::dibujaEtiqueta("li", ["style" => "font-weight: bold;"], "Comunidades: ");
                echo CHTML::dibujaEtiqueta("ul", [], null, false);
                foreach ($comu as $comunidad) {
                    echo CHTML::dibujaEtiqueta("li", [], $comunidad["nombre_comu"]);
                }
                echo CHTML::dibujaEtiquetaCierre("ul");
            }
        echo CHTML::dibujaEtiquetaCierre("ul");

    echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiquetaCierre("div");