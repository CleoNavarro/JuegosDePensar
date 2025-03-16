var test = []
var ordenPreg = 1
var totalPreg = 1;

cargarPreguntas()

function cargarPreguntas () {

    let cod_test= document.getElementById("cod_test").value

    let loc = "http://www.calculadorahumana.com/api/test"

        let busqueda = new Request(loc, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "cod_test=" + cod_test
        })
    
        fetch(busqueda).then(function (resp) {
            if (resp.ok) {
                let res = resp.json();
    
                res.then( function (resp) {
                    if (resp["correcto"]) {
                        test = resp["datos"]
                        ordenPreg = 1
                        totalPreg = Object.keys(test).length
                        console.log("Total Preguntas " + totalPreg)
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

function realizarPregunta () {

    let divPreg = document.getElementById('preguntas')

    let artPregunta = document.createElement("article")
    artPregunta.setAttribute("class", "pregunta")
    artPregunta.setAttribute("id", "preg" + test[ordenPreg]["orden"])

    let pPreg = document.createElement("p")
    let textPreg = document.createTextNode(test[ordenPreg]["orden"] + ". " + test[ordenPreg]["enunciado"])
    pPreg.appendChild(textPreg);

    let inputResp = document.createElement("input")
    inputResp.setAttribute("type", "number")
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


    artPregunta.appendChild(pPreg)
    artPregunta.appendChild(inputResp)
    artPregunta.appendChild(inputBoton)

    divPreg.appendChild(artPregunta)

    console.log("Pregunta " + test[ordenPreg]["orden"])

}

function noHaytest () {
    let divTest = document.getElementById('preguntas')

    let pIntrod = document.createElement("p")
    pIntrod.setAttribute("style", "font-size:2.5em");
    let textIntrod = document.createTextNode("Hoy no hay un test programado.")
    pIntrod.appendChild(textIntrod);

    let pTitulo = document.createElement("p")
    pTitulo.setAttribute("style", "font-size:4em; color:rgb(255, 221, 28); margin-top:0.5em; margin-bottom:70px");
    let textTitulo = document.createTextNode("¡Vuelve mañana!")
    pTitulo.appendChild(textTitulo);

    let botonCalendar = document.createElement("a")
    botonCalendar.setAttribute("class", "boton")
    botonCalendar.setAttribute("href", "/index/calendario")
    let textBoton = document.createTextNode("Ir al calendario")
    botonCalendar.appendChild(textBoton)

    divTest.appendChild(pIntrod)
    divTest.appendChild(pTitulo)
    divTest.appendChild(botonCalendar)
}



function responder () {

    let respuesta = parseInt(document.getElementById("respuesta" + test[ordenPreg]["orden"]).value)
    let correcta = parseInt(test[ordenPreg]["cantidad"])

    if (respuesta === correcta) {
        ordenPreg += 1

        if (ordenPreg > totalPreg) {
            window.location.href = "https://www.google.com/search?client=opera-gx&q=Victoria&sourceid=opera&ie=UTF-8&oe=UTF-8"
        } else {
            document.getElementById("preguntas").innerHTML = ""
            realizarPregunta()
        }
    
    } else {
        console.log("Has fallado, la respuesta es " + correcta)
    }


}


