<?php
	 
class apiControlador extends CControlador {

    public function accionSitios() {

        if ($_SERVER["REQUEST_METHOD"]=="POST") {

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
            } else if (isset($_POST["nombre"])) {

                $nombre = $_POST["nombre"];
                $sitios = new Sitios();

                if (!$sitios->buscarPor([" nombre_sitio = $nombre "])) {
                    $resultado=[
                        "datos"=>"Sitio no encontrado",
                        "correcto"=>false
                    ]; //error,
                    
                    $res=json_encode($resultado, JSON_PRETTY_PRINT);
                    echo $res;
                    exit;
                }

                $resultado=[
                    "datos"=> Sitios::dameSitiosPorNombre($nombre),
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
