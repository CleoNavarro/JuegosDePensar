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

      echo CHTML::dibujaEtiquetaCierre("div");
    echo CHTML::dibujaEtiquetaCierre("div");
    echo CHTML::dibujaEtiqueta("div", ["id" => "tab2", "class" => "tab"], null, false);
      echo CHTML::link("Recientes", "#tab2");
      echo CHTML::dibujaEtiqueta("div", ["id"=>"tab2-content", "class" => "tab-content"], null, false);

      echo CHTML::dibujaEtiquetaCierre("div");
    echo CHTML::dibujaEtiquetaCierre("div");
    echo CHTML::dibujaEtiqueta("div", ["id" => "tab1", "class" => "tab"], null, false);
      echo CHTML::link("Estadísticas", "#tab1");
      echo CHTML::dibujaEtiqueta("div", ["id"=>"tab1-content", "class" => "tab-content"], null, false);

      echo CHTML::dibujaEtiquetaCierre("div");
    echo CHTML::dibujaEtiquetaCierre("div");
  echo CHTML::dibujaEtiquetaCierre("div");
echo CHTML::dibujaEtiquetaCierre("div");

?>



<!-- <div class="tabs">
  <div class="tab-container">
    <div id="tab3" class="tab"> 
      <a href="#tab3">Ranking</a>
      <div class="tab-content">
        <h2>Titulo 3</h2>
        <p>Lorem ipsum ...</p>
      </div>
    </div>
    <div id="tab2" class="tab">
      <a href="#tab2">Últimos Juegos</a>
      <div class="tab-content">
        <h2>Titulo 2</h2>
        <p>Lorem ipsum ...</p>
      </div>
    </div> 
    <div id="tab1" class="tab">
      <a href="#tab1">Datos</a>
      <div class="tab-content">
        <h2>Titulo 1</h2>
        <p>Lorem ipsum ...</p>
      </div> 
    </div> 
  </div>
</div> -->