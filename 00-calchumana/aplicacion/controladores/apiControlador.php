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


    public function accionCalcResultado() {

        $resultado = null;
        $funciona = true;
        $error = "Fallo en algún proceso. ¡Hora de depurar!";

        if (Sistema::app()->Acceso()->hayUsuario()) {

            $cod_usuario = Sistema::app()->Acceso()->getCodUsuario();

            if (!$cod_usuario) {
                $funciona = false;
                $error = "Fallo al extraer el código de usuario";
            }
            $cod_test = intval($_POST["cod_test"]);
            $puntos = intval($_POST["puntos"]);

            $arrPuntTest = [
                "cod_usuario" => $cod_usuario,
                "cod_test" => $cod_test,
                "puntos" => $puntos
            ];
           
            $test = new PuntuacionTest();
            $hayTest = $test->buscarPor([" cod_test = $cod_test and cod_usuario = $cod_usuario"]);
    
            if ($hayTest) {
                
                $puntosAnterior = $test::damePuntuacion($cod_test, $cod_usuario);

                if ($puntos > $puntosAnterior) { // Hiciste el test antes y mejoraste la puntuación
                    
                    $test->setValores($arrPuntTest);
                    if (!$test->guardar()) {
                        $funciona = false;
                        $error = "Fallo al actualizar las puntuaciones";
                    }
                    $resultado=[
                        "datos"=>[
                            "codigo" => 2,
                            "mensaje" => "Has mejorado tu anterior puntuación.".
                                "¡Se ha registrado tu puntuación!"
                        ],
                        "correcto"=>true
                    ]; 

                } else { // Hiciste el test antes pero tu puntuación actual es menor
                    $resultado=[
                        "datos"=>[
                            "codigo" => 3,
                            "mensaje" => "Tu puntuación en este test ha sido menor que la anterior vez. ".
                                "¡Inténtalo de nuevo!"
                        ],
                        "correcto"=>true
                    ]; 
                }
                
            } else  { // Es tu primera vez haciendo el test

                $test->setValores($arrPuntTest);
                
                if (!$test->guardar()) {
                    $funciona = false;
                    $error = "Fallo al registrar nuevas puntuaciones";
                }

                $resultado=[
                    "datos"=>[
                        "codigo" => 1,
                        "mensaje" => "¡Se ha registrado tu puntuación!"
                    ],
                    "correcto"=>true
                ]; 
            }
    
        } else { // No hay usuario registrado
            $resultado=[
                "datos"=>[
                    "codigo" => 0,
                    "mensaje" => "¡Regístrate para poder guardar tus puntuaciones!"
                ],
                "correcto"=>true
            ]; 
        }

        if (is_null($resultado) || !$funciona) {
            $resultado=[
                "datos"=>[
                    "codigo" => -1,
                    "mensaje" => $error
                ],
                "correcto"=>false
            ]; 
        }


        $res=json_encode($resultado, JSON_PRETTY_PRINT);
        echo $res;
        exit;
    }

}
