<?php
	 
class apiControlador extends CControlador {

    public function accionTest() {

        if ($_SERVER["REQUEST_METHOD"]=="POST") {

            if (isset($_POST["cod_test"])) {
                //se ha indicado un elemento se consulta
                $cod_test = $_POST["cod_test"];
               
                $test = new Test();
        
                // Si no existe el sitio
                if (!$test->buscarPor([" cod_test = $cod_test "])) {
                    $resultado=[
                        "datos"=>"Test no encontrado",
                        "correcto"=>false
                    ]; //error,
                    
                    $res=json_encode($resultado, JSON_PRETTY_PRINT);
                    echo $res;
                    exit;
                }
        
                // si existe
                $resultado=[
                    "datos"=> Test::damePreguntas($cod_test),
                    "correcto"=>true
                ]; 
            } else if (isset($_POST["fecha"])) {

                $fecha = $_POST["fecha"];
                $test = new Test();
                $datos = $test::dameTestPorFecha($fecha);

                if (!$datos) {
                    $resultado=[
                        "datos"=>"Test no encontrado",
                        "correcto"=>false
                    ]; //error,
                    
                    $res=json_encode($resultado, JSON_PRETTY_PRINT);
                    echo $res;
                    exit;
                }

                $resultado=[
                    "datos"=> $datos,
                    "correcto"=>true
                ]; 

            }
               
        } else {
            $resultado=[
                "datos"=>"Test no encontrado",
                "correcto"=>false
            ]; //error,
        
        }
        
        $res=json_encode($resultado, JSON_PRETTY_PRINT);
        echo $res;
        exit;
        
    }

}
