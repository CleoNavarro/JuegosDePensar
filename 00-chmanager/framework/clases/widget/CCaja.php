<?php

class CCaja extends CWidget {

    private $_titulo;
    private $_contenido = "";
    private $_atributos = array("class" => "caja");

    public function __construct( $titulo, $contenido="", $atributosHTML=array("class" => "caja")) {
        $this->_titulo = $titulo;
        $this->_contenido = $contenido;
        $this->_atributos = $atributosHTML;
    }

    public function dibujaApertura(): string {

        $id1 = CHTML::generaID();
        $id2 = CHTML::generaID();

        $cadena = CHTML::dibujaEtiqueta("table", $this->_atributos, null, false);
        $cadena .= CHTML::dibujaEtiqueta("tr", array("class" => "titulo"), null, false);
        $cadena .= CHTML::dibujaEtiqueta("th", [], $this->_titulo, false);
        $cadena .= "&emsp;";
        $cadena .= CHTML::dibujaEtiqueta("button", ["id" => $id1 , "onclick" => "ocultar('$id1','$id2')"], "Ocultar");
        $cadena .= CHTML::dibujaEtiquetaCierre("th");
        $cadena .= CHTML::dibujaEtiquetaCierre("tr");
        $cadena .= CHTML::dibujaEtiqueta("tr", array("class" => "cuerpo", "id" => $id2), null, false);
        $cadena .= CHTML::dibujaEtiqueta("td", [], null, false);

        return $cadena;

    }

    public function dibujate(): string {
        return $this->dibujaApertura().$this->_contenido.$this->dibujaFin();
    }

    public function dibujaFin(): string {
        $cadena = CHTML::dibujaEtiquetaCierre("td");
        $cadena .= CHTML::dibujaEtiquetaCierre("tr");
        $cadena .= CHTML::dibujaEtiquetaCierre("table");

        return $cadena;
    }

    public static function requisitos():string {

			$codigo=<<<EOF
			function ocultar (idBoton, idCaja) {
				let formulario = document.getElementById(idCaja);
                let boton = document.getElementById(idBoton);
                if(formulario.style.display==='none') {
                    formulario.style.display = 'block';
                    boton.innerHTML = "Ocultar";
                } else {
                    formulario.style.display = 'none';
                    boton.innerHTML = "Mostrar";
                }
			}
EOF;
			return CHTML::script($codigo);

    }

}