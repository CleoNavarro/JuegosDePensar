<?php

echo CHTML::dibujaEtiqueta("div", ["class" => "contenedorForm"], null, false);
echo CHTML::dibujaEtiqueta("h2", [], "Borrar Usuario:");

echo CHTML::iniciarForm();
    if ($usuario->borrado==1) {
        echo CHTML::dibujaEtiqueta("label", ["for" => "recuperar"], 
        "<b>¿Quieres recuperar los datos de este usuario?</b><br>");

        echo CHTML::dibujaEtiqueta("div", [], null, false);
            echo CHTML::campoCheckBox("recuperar",
                false, ["id" => "recuperar", "value" => "si"]);
            echo "Quiero recuperar los datos de este usuario";
        echo CHTML::dibujaEtiquetaCierre("div");

        echo CHTML::campoBotonSubmit("Recuperar");
    } else {
        echo CHTML::dibujaEtiqueta("label", ["for" => "borrar"], 
        "<b>¿Quieres borrar los datos de este usuario?</b><br>");
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

echo CHTML::dibujaEtiqueta("h2", [], "Datos del usuario:");

    echo CHTML::dibujaEtiqueta("div", ["class" => "datosInfo"], null, false);

        echo CHTML::imagen("/imagenes/usuarios/".$usuario->foto, "Foto ".$usuario->nick, 
                            ["class" => "imagenInfo"] );

        echo CHTML::dibujaEtiqueta("ul", [], null, false);
            echo CHTML::dibujaEtiqueta("li", [], "Nombre: ".$usuario->nombre);
            echo CHTML::dibujaEtiqueta("li", [], "Nick: ".$usuario->nick);
            echo CHTML::dibujaEtiqueta("li", [], "Rol: ".$usuario->nombre_rol);
            echo CHTML::dibujaEtiqueta("li", [], "E-mail: ".$usuario->mail);
            echo CHTML::dibujaEtiqueta("li", [], "Teléfono: ".$usuario->telefono);
            echo CHTML::dibujaEtiqueta("li", [], "Fecha registro: ".$usuario->fecha_registrado);
            echo CHTML::dibujaEtiqueta("li", [], "Verificado: ".$verificado);
        echo CHTML::dibujaEtiquetaCierre("ul");

    echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiquetaCierre("div");