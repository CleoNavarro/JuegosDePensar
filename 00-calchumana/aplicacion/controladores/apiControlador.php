<?php
	 
class apiControlador extends CControlador {

    public function accionTest() {

        if ($_SERVER["REQUEST_METHOD"]=="POST") {

            if (isset($_POST["cod_test"])) {
                //se ha indicado un elemento se consulta
                $cod_test = $_POST["cod_test"];
               
                $test = new Test();
        
                // Si no existe el test
                if (!$test->buscarPor([" cod_test = $cod_test and borrado_fecha IS NULL "])) {
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
                $datosCalc = Test::dameTestPorFecha($fecha);
                if ($datosCalc && !is_null($datosCalc["borrado_fecha"])) $datosCalc = false;

                $datosAdiv = Adivina::dameAdivinaPorFecha($fecha);
                if ($datosAdiv && !is_null($datosAdiv["borrado_fecha"])) $datosAdiv = false;

                if (!$datosCalc && !$datosAdiv) {
                    $resultado=[
                        "datos"=>"Juegos no encontrados",
                        "correcto"=>false
                    ]; //error,
                    
                    $res=json_encode($resultado, JSON_PRETTY_PRINT);
                    echo $res;
                    exit;
                }

                $resultado=[
                    "datos"=> [
                        "calculadora" => $datosCalc,
                        "adivina" => $datosAdiv
                    ],
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

    public function accionAdivina () {

        $resultado=[
            "datos"=>"Juego no encontrado",
            "correcto"=>false
        ]; //error,

        if ($_SERVER["REQUEST_METHOD"]=="POST") {

            if (isset($_POST["cod_adivina"])) {
                //se ha indicado un elemento se consulta
                $cod_adivina = $_POST["cod_adivina"];
               
                $adivina = new Adivina();
        
                // Si no existe el test
                if (!$adivina->buscarPor([" cod_adivina = $cod_adivina and borrado_fecha IS NULL "])) {
                    $resultado=[
                        "datos"=>"Juego no encontrado",
                        "correcto"=>false
                    ]; //error,
                    
                    $res=json_encode($resultado, JSON_PRETTY_PRINT);
                    echo $res;
                    exit;
                }
        
                // si existe
                $resultado=[
                    "datos"=> Adivina::damePalabras($cod_adivina),
                    "correcto"=>true
                ]; 
            } 
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
           
            $hayTest = PuntuacionTest::damePuntuacion($cod_test, $cod_usuario);
    
            if ($hayTest) {
                
                $puntosAnterior = $hayTest["puntos"];
                $codPuntTest = $hayTest["cod_punt_test"];

                if ($puntos > $puntosAnterior) { // Hiciste el test antes y mejoraste la puntuación
                    
                    $test = new PuntuacionTest();
                    $test->buscarPorId($codPuntTest);
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

                $test = new PuntuacionTest();
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

    public function accionAdivResultado() {

        $resultado = null;
        $funciona = true;
        $error = "Fallo en algún proceso. ¡Hora de depurar!";

        if (Sistema::app()->Acceso()->hayUsuario()) {

            $cod_usuario = Sistema::app()->Acceso()->getCodUsuario();

            if (!$cod_usuario) {
                $funciona = false;
                $error = "Fallo al extraer el código de usuario";
            }
            $cod_adivina = intval($_POST["cod_adivina"]);
            $puntos = intval($_POST["puntos"]);

            $arrPuntAdiv = [
                "cod_usuario" => $cod_usuario,
                "cod_adivina" => $cod_adivina,
                "puntos" => $puntos
            ];
           
            $hayAdiv = PuntuacionAdivina::damePuntuacion($cod_adivina, $cod_usuario);
    
            if ($hayAdiv) {
                
                $puntosAnterior = $hayAdiv["puntos"];
                $codPuntAdiv = $hayAdiv["cod_punt_adivina"];

                if ($puntos > $puntosAnterior) { // Hiciste el test antes y mejoraste la puntuación
                    
                    $adivina = new PuntuacionAdivina();
                    $adivina->buscarPorId($codPuntAdiv);
                    $adivina->setValores($arrPuntAdiv);

                    if (!$adivina->guardar()) {
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
                            "mensaje" => "Tu puntuación en este juego ha sido menor que la anterior vez. ".
                                "¡Inténtalo de nuevo!"
                        ],
                        "correcto"=>true
                    ]; 
                }
                
            } else  { // Es tu primera vez haciendo el test

                $adivina = new PuntuacionAdivina();
                $adivina->setValores($arrPuntAdiv);
                
                if (!$adivina->guardar()) {
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



    public function accionDatos() {

        $resultado = [
            "datos"=>[
                "codigo" => -1,
                "mensaje" => "No se llamó al método correcto"
            ],
            "correcto"=>false
        ]; 

        if ($_SERVER["REQUEST_METHOD"]=="POST") {

            if (isset($_POST["cod_usuario"])) {

                $cod_usuario = $_POST["cod_usuario"];
               
                $usuario = new Usuarios();
        
                if (!$usuario->buscarPor([" cod_usuario = $cod_usuario "])) {
                    $resultado=[
                        "datos"=>"Usuario no encontrado",
                        "correcto"=>false
                    ]; 
                    
                } else {

                    $datosUsuario = Usuarios::dameUsuarios($cod_usuario);
                    $datosUsuario["foto"] = RUTA_IMAGEN.$datosUsuario["foto"];

                    $recientes = Usuarios::dameJuegosRecientes($cod_usuario);
                    $estadisticasCalc = PuntuacionTest::estadisticas($cod_usuario);
                    $rdiarioCalc = PuntuacionTest::rankingDiario(date("d/m/Y"), $cod_usuario);
                    $rmensualCalc = PuntuacionTest::rankingMensual(date("m"), date("Y"), $cod_usuario);
                    $rankingCalc = [
                        "puntos_hoy" => !$rdiarioCalc ? "0" : $rdiarioCalc["puntos"],
                        "posicion_hoy" => !$rdiarioCalc ?  "-" : $rdiarioCalc["posicion"],
                        "puntos_mes" => !$rmensualCalc ?  "0" : $rmensualCalc["puntos"],
                        "posicion_mes" => !$rmensualCalc ?  "-" : $rmensualCalc["posicion"],
                    ]; 
                    $estadisticasAdiv = PuntuacionAdivina::estadisticas($cod_usuario);
                    $rdiarioAdiv = PuntuacionAdivina::rankingDiario(date("d/m/Y"), $cod_usuario);
                    $rmensualAdiv = PuntuacionAdivina::rankingMensual(date("m"), date("Y"), $cod_usuario);
                    $rankingAdiv = [
                        "puntos_hoy" => !$rdiarioAdiv ? "0" : $rdiarioAdiv["puntos"],
                        "posicion_hoy" => !$rdiarioAdiv ?  "-" : $rdiarioAdiv["posicion"],
                        "puntos_mes" => !$rmensualAdiv ?  "0" : $rmensualAdiv["puntos"],
                        "posicion_mes" => !$rmensualAdiv ?  "-" : $rmensualAdiv["posicion"],
                    ]; 

                    $resultado=[
                        "datos"=> [
                            "datos" => $datosUsuario,
                            "recientes" => $recientes,
                            "calc_estadisticas" => $estadisticasCalc, 
                            "calc_ranking" => $rankingCalc,
                            "adiv_estadisticas" => $estadisticasAdiv, 
                            "adiv_ranking" => $rankingAdiv 
                        ],
                        "correcto"=>true
                    ]; 
                }
            }
        }

        $res=json_encode($resultado, JSON_PRETTY_PRINT);
        echo $res;
        exit;
    }

    public function accionRanking() {

        $resultado = [
            "datos"=>[
                "codigo" => -1,
                "mensaje" => "No se llamó al método correcto"
            ],
            "correcto"=>false
        ]; 

        if ($_SERVER["REQUEST_METHOD"]=="GET") {

            $rankingVacio = [
                1 => [
                    "cod_usuario" => 0,
                    "posicion" => "-",
                    "nick"=> "-",
                    "puntos"=> "-"
                ]
            ];

            $rdiarioCalc = PuntuacionTest::rankingDiario(date("d/m/Y"));
            $rmensualCalc = PuntuacionTest::rankingMensual(date("m"), date("Y"));
            $rdiarioAdiv = PuntuacionAdivina::rankingDiario(date("d/m/Y"));
            $rmensualAdiv = PuntuacionAdivina::rankingMensual(date("m"), date("Y"));
                
            $resultado=[
                "datos"=> [
                    "calc_diario" => !$rdiarioCalc ? $rankingVacio : $rdiarioCalc,
                    "calc_mes" => !$rmensualCalc ? $rankingVacio : $rmensualCalc, 
                    "adiv_diario" => !$rdiarioAdiv ? $rankingVacio : $rdiarioAdiv,
                    "adiv_mes" => !$rmensualAdiv ? $rankingVacio : $rmensualAdiv
                ],
                "correcto"=>true
            ]; 
        }
            
        $res=json_encode($resultado, JSON_PRETTY_PRINT);
        echo $res;
        exit;
    }


}
