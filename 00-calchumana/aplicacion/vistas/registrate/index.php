<?php

echo CHTML::dibujaEtiqueta("div", ["class" => "contenedorForm"], null, false);

echo CHTML::dibujaEtiqueta("h2", ["style" => "text-align:center;"] , 
    "¡Regístrate en un minuto!");
echo "<br>".PHP_EOL;

echo CHTML::iniciarForm();

echo CHTML::modeloLabel($modelo, "nick");
echo "<br>".PHP_EOL;
echo CHTML::modeloText($modelo, "nick", 
    array(
        "maxlength"=>40,
        "size"=>41
    )
);
echo "<br>".PHP_EOL;
echo CHTML::modeloError($modelo, "nick");
echo "<br>".PHP_EOL;


echo CHTML::modeloLabel($modelo, "nombre"); 
echo "<br>".PHP_EOL;
echo CHTML::modeloText($modelo, "nombre", 
    array(
        "size"=>40
    )
);
echo "<br>".PHP_EOL;
echo CHTML::modeloError($modelo, "nombre");
echo "<br>".PHP_EOL;

echo CHTML::modeloLabel($modelo, "mail"); 
echo "<br>".PHP_EOL;
echo CHTML::modelotext($modelo, "mail", 
        array(
            "size"=>40
        )
);
echo "<br>".PHP_EOL;
echo CHTML::modeloError($modelo, "mail");
echo "<br>".PHP_EOL;


echo CHTML::modeloLabel($modelo, "telefono"); 
echo "<br>".PHP_EOL;
echo CHTML::modeloNumber($modelo, "telefono", 
    array(
        "maxlength"=>15,
        "size"=>16
    )
);
echo "<br>".PHP_EOL;
echo CHTML::modeloError($modelo, "telefono");
echo "<br>".PHP_EOL;

echo CHTML::modeloLabel($modelo, "contrasenia"); 
echo "<br>".PHP_EOL;
echo CHTML::modeloPassword($modelo, "contrasenia", 
    array(
        "maxlength"=>30,
        "size"=>31
    )
);
echo "<br>".PHP_EOL;
echo CHTML::modeloError($modelo, "contrasenia");
echo "<br>".PHP_EOL;

echo CHTML::modeloLabel($modelo, "repite_contrasenia"); 
echo "<br>".PHP_EOL;
echo CHTML::modeloPassword($modelo, "repite_contrasenia", 
    array(
        "maxlength"=>30,
        "size"=>31
    )
);
echo "<br>".PHP_EOL;
echo CHTML::modeloError($modelo, "repite_contrasenia");
echo "<br>".PHP_EOL;

echo CHTML::modeloLabel($modelo, "foto");
echo "<br>".PHP_EOL;
echo CHTML::modeloFile($modelo, "foto");
echo "<br>".PHP_EOL;
echo CHTML::modeloError($modelo, "foto");
echo "<br>".PHP_EOL;

echo CHTML::campoBotonSubmit("¡Regístrate!", ["class" => "boton"]);
echo CHTML::finalizarForm();

echo CHTML::dibujaEtiquetaCierre("div");