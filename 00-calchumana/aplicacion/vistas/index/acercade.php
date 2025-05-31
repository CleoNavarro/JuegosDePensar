<?php 

echo CHTML::dibujaEtiqueta("div", ["class" => "contAcerca"], null, false);

    echo CHTML::dibujaEtiqueta("h1", [], "¡PON A PRUEBA TU CEREBRO!");

    echo CHTML::dibujaEtiqueta("p", [], 
        "En <b>Juegos de Pensar</b> encontraras todo tipo de retos para entrenar y poner ".
        "a prueba tus habilidades, conocimiento y dominio del cálculo, en variados juegos ".
        "inspirados en 'Saber y Ganar', 'Wordle' y 'Cifras y Letras'."
    );

    echo CHTML::dibujaEtiqueta("p", [], 
        "Demuestra que eres el más hábil comparando tus resultados con otros jugadores, y ".
        "mejora cada día con nuestro Reto Diario. ¡Juega desde tu ordenador, movil o tablet!"
    );

    echo CHTML::dibujaEtiqueta("div", ["class" => "acercaJuegos"], null, false);
        echo CHTML::dibujaEtiqueta("div", [], null, false);
            echo CHTML::imagen("/imagenes/logocalculadora.png", "", ["class" => "logo"]);
            echo CHTML::dibujaEtiqueta("p", [], 
                "El famoso reto matemático de 'Saber y Ganar', que mezcla cálculo veloz con preguntas ".
                "de cultura. Tómate tu tiempo en completar el desafío, ¡o lucha contra el cronómetro y ".
                "obten la máxima puntuación!"
                );
        echo CHTML::dibujaEtiquetaCierre("div");

        echo CHTML::dibujaEtiqueta("div", [], null, false);
            echo CHTML::imagen("/imagenes/logoadivina.png", "", ["class" => "logo"]);
            echo CHTML::dibujaEtiqueta("p", [], 
                "Uno de los juegos estrella del programa 'Saber y Ganar', el famoso Reto, que coniste en ".
                "adivinar la palabra oculta con solo su definición y sus siglas. Tómate est reto de forma ". 
                "relajada, ¡o compite contra otros jugadores!"
                );
        echo CHTML::dibujaEtiquetaCierre("div");
    echo CHTML::dibujaEtiquetaCierre("div");

    echo CHTML::dibujaEtiqueta("h1", [], "Acerca de nosotros");

    echo CHTML::dibujaEtiqueta("p", [], 
        "'Juegos de Pensar', un juego de ".Sistema::app()->autor."."
    );

    echo CHTML::dibujaEtiqueta("p", [], 
        date("Y") . " © - Todos los Derechos Reservados"
    );

    echo CHTML::dibujaEtiqueta("p", [], 
        "'Saber y Ganar', 'Calculadora Humana' y 'Cifras y Letras' son marcas que pertenecen a RTVE."
    );

    echo CHTML::dibujaEtiqueta("p", [], 
        "'Wordle' es una marca que pertenece a The New York Times."
    );

echo CHTML::dibujaEtiquetaCierre("div");
