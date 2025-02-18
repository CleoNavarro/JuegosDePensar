<?php

class CSesion {

    public function __construct() {
     
    }

    public function crearSesion () {
        if (!$this->haySesion())
        @session_start();
    }

    public function haySesion () {
        return isset($_SESSION);
    }

    public function destruirSesion () {
        if ($this->haySesion())
        session_destroy();
    }
    
}