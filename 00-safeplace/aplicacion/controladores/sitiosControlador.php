<?php
	 
class sitiosControlador extends CControlador {

    public function accionIndex() {

        if ($_SERVER["REQUEST_METHOD"]=="POST") {

            //petición por GET-> es una consulta
            if (isset($_POST["coor_x"]) && isset($_POST["coor_y"])) {
                //se ha indicado un elemento se consulta
                $coor_x = $_POST["coor_x"];
                $coor_y = $_POST["coor_y"];
            
                $sitios = new Sitios();
        
                // Si no existe el sitio
                if (!$sitios->buscarPor([" coor_x = $coor_x and coor_y = $coor_y "])) {
                    $resultado=[
                        "datos"=>"Sitio no encontrado",
                        "correcto"=>false
                    ]; //error,
                    
                    $res=json_encode($resultado, JSON_PRETTY_PRINT);
                    echo $res;
                    exit;
                }
        
                // si existe
                $resultado=[
                    "datos"=> Sitios::dameSitioPorCoordenadas($coor_x, $coor_y),
                    "correcto"=>true
                ]; 
            }
               
            } else {
                $resultado=[
                    "datos"=>"Sitio no encontrado",
                    "correcto"=>false
                ]; //error,
        
            }
        
            $res=json_encode($resultado, JSON_PRETTY_PRINT);
            echo $res;
            exit;
        
    }

}
