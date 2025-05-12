<?php

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
            echo CHTML::dibujaEtiqueta("li", [], "Borrado: ".$borr);
        echo CHTML::dibujaEtiquetaCierre("ul");

    echo CHTML::dibujaEtiquetaCierre("div");

    echo CHTML::dibujaEtiqueta("div", ["class" => "botonesInfo"], null, false);

        $boton1 = CHTML::boton("Modificar usuario");
        echo CHTML::link($boton1, 
            Sistema::app()->generaURL(["usuarios","modificar"],
            ["id" => $usuario->cod_usuario]));

        $boton2 = CHTML::boton("Borrar Usuario");
        echo CHTML::link($boton2, 
            Sistema::app()->generaURL(["usuarios","borrar"],
            ["id" => $usuario->cod_usuario]));

    echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiquetaCierre("div");