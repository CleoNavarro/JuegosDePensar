<?php 

$this->textoHead= "<script src='/js/ranking.js' defer></script>";

echo CHTML::dibujaEtiqueta("div", ["class" => "tabs"], null, false);
  echo CHTML::dibujaEtiqueta("div", ["class" => "tab-container"], null, false);
    
    echo CHTML::dibujaEtiqueta("div", ["id" => "tab2", "class" => "tab"], null, false);
      echo CHTML::link("Adivina", "#tab2");
      echo CHTML::dibujaEtiqueta("div", ["id"=>"tab2-content", "class" => "tab-content"], null, false);
        echo CHTML::dibujaEtiqueta("div", ["class" => "contRanking"], null, false);
          echo CHTML::dibujaEtiqueta("div", ["id" => "adivDia"], null, false);
          echo CHTML::dibujaEtiquetaCierre("div");
          echo CHTML::dibujaEtiqueta("div", ["id" => "adivMes"], null, false);
          echo CHTML::dibujaEtiquetaCierre("div");
        echo CHTML::dibujaEtiquetaCierre("div");
      echo CHTML::dibujaEtiquetaCierre("div");
    echo CHTML::dibujaEtiquetaCierre("div");
    echo CHTML::dibujaEtiqueta("div", ["id" => "tab1", "class" => "tab"], null, false);
      echo CHTML::link("Calculadora", "#tab1");
      echo CHTML::dibujaEtiqueta("div", ["id"=>"tab1-content", "class" => "tab-content"], null, false);
        echo CHTML::dibujaEtiqueta("div", ["class" => "contRanking"], null, false);
          echo CHTML::dibujaEtiqueta("div", ["id" => "calcDia"], null, false);
          echo CHTML::dibujaEtiquetaCierre("div");
          echo CHTML::dibujaEtiqueta("div", ["id" => "calcMes"], null, false);
          echo CHTML::dibujaEtiquetaCierre("div");
        echo CHTML::dibujaEtiquetaCierre("div");
      echo CHTML::dibujaEtiquetaCierre("div");
    echo CHTML::dibujaEtiquetaCierre("div");
  echo CHTML::dibujaEtiquetaCierre("div");
echo CHTML::dibujaEtiquetaCierre("div");
