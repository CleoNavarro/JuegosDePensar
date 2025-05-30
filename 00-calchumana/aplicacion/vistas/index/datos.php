<?php 

$this->textoHead= "<script src='/js/datos.js' defer></script>";

echo CHTML::dibujaEtiqueta("input", ["type" => "hidden", "id" => "cod_usuario", "value" => $cod_usuario]);


echo CHTML::dibujaEtiqueta("div", ["id" =>"datosInfo", "class" => "datosInfo"], null, false);
echo CHTML::dibujaEtiquetaCierre("div");

echo CHTML::dibujaEtiqueta("div", ["class" => "tabs"], null, false);
  echo CHTML::dibujaEtiqueta("div", ["class" => "tab-container"], null, false);
    echo CHTML::dibujaEtiqueta("div", ["id" => "tab3", "class" => "tab"], null, false);
      echo CHTML::link("Ranking", "#tab3");
      echo CHTML::dibujaEtiqueta("div", ["id"=>"tab3-content", "class" => "tab-content"], null, false);
        echo CHTML::dibujaEtiqueta("div", ["class" => "contRanking"], null, false);
          echo CHTML::dibujaEtiqueta("div", ["id" => "calcRank"], null, false);

          echo CHTML::dibujaEtiquetaCierre("div");
          echo CHTML::dibujaEtiqueta("div", ["id" => "adivRank"], null, false);

          echo CHTML::dibujaEtiquetaCierre("div");
        echo CHTML::dibujaEtiquetaCierre("div");
      echo CHTML::dibujaEtiquetaCierre("div");
    echo CHTML::dibujaEtiquetaCierre("div");
    echo CHTML::dibujaEtiqueta("div", ["id" => "tab2", "class" => "tab"], null, false);
      echo CHTML::link("Recientes", "#tab2");
      echo CHTML::dibujaEtiqueta("div", ["id"=>"tab2-content", "class" => "tab-content"], null, false);

      echo CHTML::dibujaEtiquetaCierre("div");
    echo CHTML::dibujaEtiquetaCierre("div");
    echo CHTML::dibujaEtiqueta("div", ["id" => "tab1", "class" => "tab"], null, false);
      echo CHTML::link("Stats", "#tab1");
      echo CHTML::dibujaEtiqueta("div", ["id"=>"tab1-content", "class" => "tab-content"], null, false);
        echo CHTML::dibujaEtiqueta("div", ["class" => "contRanking"], null, false);
          echo CHTML::dibujaEtiqueta("div", ["id" => "calcStats"], null, false);

          echo CHTML::dibujaEtiquetaCierre("div");
          echo CHTML::dibujaEtiqueta("div", ["id" => "adivStats"], null, false);

          echo CHTML::dibujaEtiquetaCierre("div");
        echo CHTML::dibujaEtiquetaCierre("div");
      echo CHTML::dibujaEtiquetaCierre("div");
    echo CHTML::dibujaEtiquetaCierre("div");
  echo CHTML::dibujaEtiquetaCierre("div");
echo CHTML::dibujaEtiquetaCierre("div");

?>

