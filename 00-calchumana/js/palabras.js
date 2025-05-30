var test = []
var ordenPreg = 1
var totalPreg = 1;
var puntuacionBase = 0;
var bonificador = 0;
var segundos = 0;
var fallos = 0;
var apiResp = [];
var tiempoMax = 900;

// Intervalo para cronómetro
var intervalo = setInterval(function() {

    segundos++
    let minutos = Math.floor(segundos / 60);
    let secs = Math.floor(segundos % 60);
    let tiempoString = "Tiempo: " + minutos + ":" + (secs < 10 ? "0" : "") + secs
      
    document.getElementById("tiempo").innerHTML = tiempoString

    if (segundos > tiempoMax) {
      clearInterval(intervalo);
    }
}, 1000);


cargarPalabras()

// Función que busca las palabras del juego y las carga
function cargarPalabras () {

    let cod_adivina = document.getElementById("cod_adivina").value

    let loc = "http://www.juegosdepensar.com/api/adivina"

        let busqueda = new Request(loc, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "cod_adivina=" + cod_adivina
        })
    
        fetch(busqueda).then(function (resp) {
            if (resp.ok) {
                let res = resp.json();
    
                res.then( function (resp) {
                    if (resp["correcto"]) {
                        test = resp["datos"]
                        ordenPreg = 1
                        totalPreg = Object.keys(test).length
                        bonificador = parseFloat(test[1]["bonificador"])
                        realizarPregunta()
                    } else {
                        noHaytest()
                    }            
                })
            }
        }
        ).catch(function (error) {
            console.log(error)
        })
    
}

// Aparece una pregunta en pantalla
function realizarPregunta () {

    let divPreg = document.getElementById('preguntas')

    puntuacionBase += parseInt(test[ordenPreg]["puntuacion_base"])

    let artPregunta = document.createElement("article")
    artPregunta.setAttribute("class", "pregunta")
    artPregunta.setAttribute("id", "preg" + test[ordenPreg]["orden"])

    document.getElementById("letras").innerHTML = test[ordenPreg]["siglas"]

    let pPreg = document.createElement("p")
    let textPreg = document.createTextNode(test[ordenPreg]["orden"] + ". " + test[ordenPreg]["enunciado"])
    pPreg.appendChild(textPreg);

    let inputResp = document.createElement("input")
    inputResp.setAttribute("type", "text")
    inputResp.setAttribute("id", "respuesta" + test[ordenPreg]["orden"])
    inputResp.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {responder()}
    })
    
    let inputBoton = document.createElement("input")
    inputBoton.setAttribute("id" , "botonResponder")
    inputBoton.setAttribute("class" , "boton")
    inputBoton.setAttribute("type", "button")
    inputBoton.setAttribute("value", "Check")
    inputBoton.addEventListener("click", responder);

    let separador = document.createElement("br");


    artPregunta.appendChild(pPreg)
    artPregunta.appendChild(inputResp)
    artPregunta.appendChild(separador)
    artPregunta.appendChild(inputBoton)

    divPreg.appendChild(artPregunta)
    inputResp.focus();

}

// Si no hay un juego con ese código, sale pantalla de error
function noHaytest () {

    clearInterval(intervalo);
    let divTest = document.getElementById('preguntas')

    let pIntrod = document.createElement("p")
    pIntrod.setAttribute("style", "font-size:2.5em");
    let textIntrod = document.createTextNode("Hoy no hay un juego programado.")
    pIntrod.appendChild(textIntrod);

    let pTitulo = document.createElement("p")
    pTitulo.setAttribute("style", "font-size:4em; color:rgb(255, 221, 28); margin-top:0.5em; margin-bottom:70px");
    let textTitulo = document.createTextNode("¡Vuelve mañana!")
    pTitulo.appendChild(textTitulo);

    let botonCalendar = document.createElement("a")
    botonCalendar.setAttribute("class", "boton")
    botonCalendar.setAttribute("href", "/ranking")
    let textBoton = document.createTextNode("Ir al ranking")
    botonCalendar.appendChild(textBoton)

    divTest.appendChild(pIntrod)
    divTest.appendChild(pTitulo)
    divTest.appendChild(botonCalendar)
}


/**
 * Responder a la pregunta
 * - Si es correcta, pasa a la siguiente
 * - Si es la última pregunta, carga los resultados
 * - Si es incorrecta, acumulas un fallo
 */
function responder () {

    let respuesta = document.getElementById("respuesta" + test[ordenPreg]["orden"]).value
    respuesta = respuesta.trim().toUpperCase()
    let correcta = test[ordenPreg]["respuesta"]
    correcta = correcta.toUpperCase()

    if (respuesta === correcta) {
        ordenPreg += 1

        if (ordenPreg > totalPreg) {
            terminar()
        } else {
            document.getElementById("preguntas").innerHTML = ""
            realizarPregunta()
        }
    
    } else {
        fallido()
    }

}

// Cuando fallas
function fallido () {
    fallos ++
    document.getElementById("fallos").innerHTML = "Fallos: " + fallos
    document.getElementById("respuesta" + test[ordenPreg]["orden"]).value = null
}

// 
/**
 * Cuando se ha terminado el test, calcula la puntuación.
 * Esta puntuación se registra en la base de datos mediante la API.
 * Luego carga la pantalla final
 */
function terminar () {

    clearInterval(intervalo)

    let puntuacionTotal = Math.floor(puntuacionBase * bonificador)
    let puntosPorSegundo = Math.floor(puntuacionTotal/tiempoMax)
    puntuacionTotal -= (puntosPorSegundo * fallos * 10)
    puntuacionTotal -= (segundos * puntosPorSegundo)
    if (puntuacionTotal <= 10) puntuacionTotal = 10

    document.getElementById("preguntas").innerHTML = ""

    let cod_adivina = document.getElementById("cod_adivina").value

    let loc = "http://www.juegosdepensar.com/api/adivResultado"

        let busqueda = new Request(loc, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "cod_adivina=" + cod_adivina + "&puntos=" + puntuacionTotal
        })
        
        fetch(busqueda).then(function (resp) {
            if (resp.ok) {
                let res = resp.json();
    
                res.then( function (resp) {
                        apiResp = resp["datos"]
                    if (resp["correcto"]) {
                        pantallaFinal(puntuacionTotal)
                    } else {
                        errorPuntuacion()
                    }            
                })
            }
        }
        ).catch(function (error) {
            console.log(error)
        })
}

/**
 * Carga la pantalla final con el resultado obtenido y un mensaje distinto en cada ocasión
 * @param {*} puntuacionTotal Puntuación que se muestra
 */
function pantallaFinal (puntuacionTotal) {

    let container = document.getElementById("contenedorTest")
    container.innerHTML = "";

    let pIntrod = document.createElement("p")
    pIntrod.setAttribute("style", "font-size:2em; margin-top:0.5em; margin-bottom:5px");
    let textIntrod = document.createTextNode("Tu puntuación: ")
    pIntrod.appendChild(textIntrod);

    let pPuntos = document.createElement("p")
    pPuntos.setAttribute("style", "font-size:3em; color:rgb(255, 221, 28); margin-top:0.5em; margin-bottom:5px");
    let textPuntos = document.createTextNode(puntuacionTotal + " puntos")
    pPuntos.appendChild(textPuntos);

    let pMensaje = document.createElement("p")
    pMensaje.setAttribute("style", "font-size:1em; margin-top:5px; margin-bottom: 50px")
    let textMensaje = document.createTextNode(apiResp["mensaje"])
    pMensaje.appendChild(textMensaje);

    let botonSalir = document.createElement("a")
    botonSalir.setAttribute("class", "boton")
    let textSalir

    if (!apiResp["codigo"]) {
        botonSalir.setAttribute("href", "/index/registrate")
        textSalir = document.createTextNode("¡Regístrate!")
    } else {
        botonSalir.setAttribute("href", "/")
        textSalir = document.createTextNode("Salir")
    }
    
    botonSalir.appendChild(textSalir)

    container.appendChild(pIntrod)
    container.appendChild(pPuntos)
    container.appendChild(pMensaje)
    container.appendChild(botonSalir)

}

// En caso de que haya surgido algun error al registrar la puntuación
function errorPuntuacion () {

    let container = document.getElementById("contenedorTest")
    container.innerHTML = "";

    let pIntrod = document.createElement("p")
    pIntrod.setAttribute("style", "font-size:3em");
    let textIntrod = document.createTextNode("Error")
    pIntrod.appendChild(textIntrod);

    let pError = document.createElement("p")
    pError.setAttribute("style", "font-size:1.5em");
    let textError = document.createTextNode(apiResp["mensaje"])
    pError.appendChild(textError);

}

