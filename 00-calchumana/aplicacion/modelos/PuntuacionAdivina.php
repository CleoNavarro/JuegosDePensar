<?php
class PuntuacionAdivina extends CActiveRecord {

    protected function fijarNombre(): string {
        return 'puntuacion_adivina';
    }

    protected function fijarTabla():string {
        return "vista_puntuacion_adivina";
    }
    
    protected function fijarId():string {
        return "cod_punt_adivina";
    }

    protected function fijarAtributos(): array {
        return array(
            "cod_punt_adivina", "cod_usuario", "cod_adivina", "puntos", 
            "fecha_realizado", "nombre",  "nick", "foto", "fecha", "titulo"
        );
    }

    protected function fijarDescripciones(): array {
        return array(
            "cod_punt_adivina" => "Código Puntuación Adivina", 
            "cod_usuario" => "Código Usuario", 
            "cod_adivina" => "Código Adivina", 
            "puntos" => "Puntuación", 
            "fecha_realizado" => "Fecha en la que se realizó la partida", 
            "nombre" => "Realizado por",  
            "nick" => "Realizado por", 
            "foto" => "Foto", 
            "fecha" => "Fecha del adivina", 
            "titulo" => "Título del adivina"
        );
    }

    protected function fijarRestricciones(): array {
        return
            array(
                array(
                    "ATRI" => "cod_usuario,cod_adivina,puntos",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "cod_punt_adivina", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "cod_usuario", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "cod_adivina", "TIPO" => "ENTERO", "MIN" => 0
                ),
                array(
                    "ATRI" => "puntos", "TIPO" => "ENTERO", "MIN" => 10
                )
            );
    }

    /**
     * Función que devuelve la puntuación de un adivina hecho por un usuario
     * @param integer $cod_adiv Código adivina
     * @param integer $cod_usuario Código usuario
     * @return mixed Devuelve la puntuación del adivina. False si no existe
     */
    public static function damePuntuacion (int $cod_adiv, int $cod_usuario) : mixed {

        $sentencia = "SELECT * from vista_puntuacion_adivina ".
        "where cod_adivina = $cod_adiv and cod_usuario = $cod_usuario";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);

        $filas=$consulta->filas();

        if (is_null($filas) || count($filas)==0) return false;

        $puntuacion = [];

        foreach ($filas as $fila) {$puntuacion = $fila;}

        return $puntuacion;
    }


    /**
     * Función que devuelve todas las puntuaciónes de los adivina hecho por un usuario
     * @param integer $cod_usuario Código usuario
     * @param bool $limit Opcional. Pon true si quieres que solo devuelva las 10 primeras instancias
     * @return mixed Devuelve los adivina hechos. False si no hay ninguno
     */
    public static function damePuntuaciones (int $cod_usuario, bool $limit = false) : mixed {

        $sentencia = "SELECT * from vista_puntuacion_adivina ".
            "where cod_usuario = $cod_usuario ".
            "order by fecha_realizado desc";

        if ($limit) $sentencia .= " LIMIT 10";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);

        $filas=$consulta->filas();

        if (is_null($filas) || count($filas)==0) return false;

        $puntuaciones = [];
        $indexFila = 0;

        foreach ($filas as $fila) {
            $fila["fecha"] = CGeneral::fechaMysqlANormal($fila["fecha"]);
            $fila["fecha_realizado"] = CGeneral::fechahoraMysqlANormal($fila["fecha_realizado"]);
            $puntuaciones[$indexFila] = $fila;
            $indexFila++;
        }

        return $puntuaciones;
    }

    /**
     * Función que devuelve el ranking diario de la fecha introducida. 
     * Puede devolver la puntuación y posición en el ranking de un usuario
     * @param string $fecha Fecha en formato dd/mm/yyyy
     * @param integer $cod_usuario Código usuario
     * @return mixed Devuelve la clasificación diaria, la puntuación del usuario seleccionado
     * o false en caso de que no encuentre nada
     */
    public static function rankingDiario (string $fecha, ?int $cod_usuario = null) : mixed {

        $test = Adivina::dameAdivinaPorFecha($fecha);

        if (!$test) return false;

        $cod_adivina = $test["cod_adivina"];

        $sentencia = "SELECT ROW_NUMBER() OVER(ORDER BY pt.puntos DESC) AS posicion, ".
            "pt.cod_usuario, pt.nick, pt.puntos ".
            "from vista_puntuacion_adivina pt ".
            "WHERE pt.cod_adivina = $cod_adivina ".
            "ORDER BY pt.puntos DESC;";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);

        $filas=$consulta->filas();
        
        if (!$filas || count($filas)==0) return false;

        $ranking = [];
        $usuario = null;

        foreach ($filas as $fila) {
            $ranking[intval($fila["posicion"])] = $fila;
            if (!is_null($cod_usuario) && intval($fila["cod_usuario"]) == $cod_usuario)
                $usuario = $fila;
        }

        if (is_null($cod_usuario))
            return $ranking;
        else {
            if (!is_null($usuario))
                return $usuario;
        }

        return false;
    }

    /**
     * Función que devuelve el ranking mensual de la fecha introducida. 
     * Puede devolver la puntuación y posición en el ranking de un usuario
     * @param integer $mes Mes
     * @param integer $anio Año
     * @param integer $cod_usuario Código usuario
     * @return mixed Devuelve la clasificación mensual, la puntuación del usuario seleccionado
     * o false en caso de que no encuentre nada
     */
    public static function rankingMensual (int $mes, int $anio, ?int $cod_usuario = null) : mixed {

        $sentencia = "With m as (
                            SELECT pt.cod_usuario, pt.nick, COALESCE(SUM(pt.puntos),0) as puntos
                            From vista_puntuacion_adivina pt
                            WHERE MONTH(pt.fecha) = $mes and YEAR(pt.fecha) = $anio
                            group by pt.cod_usuario
                        )
                        SELECT ROW_NUMBER() OVER(ORDER BY m.puntos DESC) AS posicion,
                        m.cod_usuario, m.nick, m.puntos
                        From m
                        ORDER by m.puntos DESC";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);

        $filas=$consulta->filas();
        
        if (!$filas || count($filas)==0) return false;

        $ranking = [];
        $usuario = null;

        foreach ($filas as $fila) {
            $ranking[intval($fila["posicion"])] = $fila;
            if (!is_null($cod_usuario) && intval($fila["cod_usuario"]) == $cod_usuario)
                $usuario = $fila;
        }

        if (is_null($cod_usuario))
            return $ranking;
        else {
            if (!is_null($usuario))
                return $usuario;
        }

        return false;
    }

    /**
     * Función que devuelve las estadísticas de un usuario
     * @param integer $cod_usuario - Código usuario
     * @return mixed Stats con las estadísticas del usuario. False si no existe
     */
    public static function estadisticas (int $cod_usuario) : mixed {
        $sentencia = "SELECT * from vista_estadisticas_adivina where cod_usuario = $cod_usuario";

        $consulta=Sistema::App()->BD()->crearConsulta($sentencia);
    
        $filas=$consulta->filas();

        if (is_null($filas) || count($filas)==0) return false;

        $stats = [];

        foreach ($filas as $fila) {$stats = $fila;}

        return $stats;

    }

    protected function afterBuscar(): void {

        $fechaAux = $this->fecha_realizado;
        $fechaAux = CGeneral::fechahoraMysqlANormal($fechaAux);
        $this->fecha_realizado = $fechaAux;

        $fechaAux = $this->fecha;
        $fechaAux = CGeneral::fechaMysqlANormal($fechaAux);
        $this->fecha = $fechaAux;
   
    }

    function fijarSentenciaInsert(): string {

        $cod_usuario = intval($this->cod_usuario);
        $cod_adivina = intval($this->cod_adivina);
        $puntos = intval($this->puntos);
        
        $sentencia = "INSERT INTO puntuacion_adivina ". 
            "(cod_usuario, cod_adivina, puntos, fecha_realizado)". 
            " VALUES ($cod_usuario, $cod_adivina, $puntos, CURRENT_TIMESTAMP); ";

        return $sentencia;
    }

    function fijarSentenciaUpdate(): string {

        $cod_punt_adivina = intval($this->cod_punt_adivina);
        $cod_usuario = intval($this->cod_usuario);
        $cod_adivina = intval($this->cod_adivina);
        $puntos = intval($this->puntos);

        $sentencia = "UPDATE puntuacion_adivina ".
            "SET cod_usuario = $cod_usuario, cod_adivina = $cod_adivina, ".
            "puntos = $puntos, fecha_realizado = CURRENT_TIMESTAMP ".
            "WHERE cod_punt_adivina = $cod_punt_adivina;";
     
        return $sentencia;
    }

}