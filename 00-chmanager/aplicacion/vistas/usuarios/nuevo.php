<?php

echo CHTML::dibujaEtiqueta("div", ["class" => "contenedorForm"], null, false);
echo CHTML::dibujaEtiqueta("h2", ["style" => "text-align:center;"] , 
    "Nuevo Usuario");
echo "<br>".PHP_EOL;

echo CHTML::iniciarForm("", "post", ["enctype"=>"multipart/form-data"]);

echo CHTML::modeloLabel($modelo, "nick");
echo CHTML::modeloText($modelo, "nick", 
    array(
        "maxlength"=>40,
        "size"=>41
    )
);
echo CHTML::modeloError($modelo, "nick");
echo "<br>".PHP_EOL;


echo CHTML::modeloLabel($modelo, "nombre"); 
echo CHTML::modeloText($modelo, "nombre", 
    array(
        "size"=>40
    )
);
echo CHTML::modeloError($modelo, "nombre");
echo "<br>".PHP_EOL;

echo CHTML::modeloLabel($modelo, "cod_acl_role");
echo CHTML::modeloListaDropDown($modelo, "cod_acl_role", 
    Usuarios::dameRolesDrop()
);
echo CHTML::modeloError($modelo, "cod_acl_role");
echo "<br>".PHP_EOL;

echo CHTML::modeloLabel($modelo, "mail"); 
echo CHTML::modelotext($modelo, "mail", 
        array(
            "size"=>40
        )
);
echo CHTML::modeloError($modelo, "mail");
echo "<br>".PHP_EOL;


echo CHTML::modeloLabel($modelo, "telefono"); 
echo CHTML::modeloNumber($modelo, "telefono", 
    array(
        "maxlength"=>15,
        "size"=>16
    )
);
echo CHTML::modeloError($modelo, "telefono");
echo "<br>".PHP_EOL;

echo CHTML::modeloLabel($modelo, "contrasenia"); 
echo CHTML::modeloPassword($modelo, "contrasenia", 
    array(
        "maxlength"=>30,
        "size"=>31
    )
);
echo CHTML::modeloError($modelo, "contrasenia");
echo "<br>".PHP_EOL;

echo CHTML::modeloLabel($modelo, "repite_contrasenia"); 
echo CHTML::modeloPassword($modelo, "repite_contrasenia", 
    array(
        "maxlength"=>30,
        "size"=>31
    )
);
echo CHTML::modeloError($modelo, "repite_contrasenia");
echo "<br>".PHP_EOL;

echo CHTML::modeloLabel($modelo, "foto");
echo CHTML::modeloFile($modelo, "foto", ["accept" => "image/png, image/jpeg"]);
echo CHTML::modeloError($modelo, "foto");
echo "<br>".PHP_EOL;

echo CHTML::campoBotonSubmit("Crear", ["class" => "boton"]);
echo CHTML::finalizarForm();
echo CHTML::dibujaEtiquetaCierre("div");
