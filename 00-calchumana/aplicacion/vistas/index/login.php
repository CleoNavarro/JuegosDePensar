<?php 
 echo "<br>";
echo CHTML::dibujaEtiqueta("div", ["class" => "contenedorForm"], null, false);

echo CHTML::dibujaEtiqueta("h2", ["style" => "text-align:center;"] , 
    "Introduzca sus credenciales");
echo "<br>".PHP_EOL;


echo CHTML::iniciarForm();

echo CHTML::modeloLabel($modelo, "nick");
echo "<br>".PHP_EOL;
echo CHTML::modeloText($modelo, "nick", 
    array(
        "maxlength"=>20,
        "size"=> 21
    )
);
echo CHTML::modeloError($modelo, "nick");
echo "<br>".PHP_EOL;
echo "<br>".PHP_EOL;


echo CHTML::modeloLabel($modelo, "contrasenia"); 
echo "<br>".PHP_EOL;
echo CHTML::modeloPassword($modelo, "contrasenia", 
    array(
        "maxlength"=>20,
        "size"=>21
    )
);
echo CHTML::modeloError($modelo, "contrasenia");
echo "<br>".PHP_EOL;
echo "<br>".PHP_EOL;

echo CHTML::campoBotonSubmit("Acceder", ["class" => "boton"]);
echo CHTML::finalizarForm();

echo CHTML::dibujaEtiquetaCierre("div");