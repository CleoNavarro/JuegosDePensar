desafioDiario()

function desafioDiario () {

    let fecha = new Date().getDate() + "/" + (new Date().getMonth()+1) + "/" + new Date().getFullYear()

    //let fecha= "18/05/2025"

    let loc = "http://www.juegosdepensar.com/api/test"

        let busqueda = new Request(loc, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "fecha=" + fecha
        })
    
        fetch(busqueda).then(function (resp) {
            if (resp.ok) {
                let res = resp.json();
    
                res.then( function (resp) {
                    if (resp["correcto"]) {
                        let datos = resp["datos"]
                        if (datos["calculadora"]) 
                            testDiario(datos["calculadora"]) 
                        else noHaytest()

                        if (datos["adivina"]) 
                            adivinaDiario(datos["adivina"]) 
                        else noHayAdivina ()
                     
                    } else {
                        noHaytest ()
                        noHayAdivina ()
                    }            
                })
            }
        }
        ).catch(function (error) {
            console.log(error)
        })
    
}

function testDiario (test) {
    let divTest = document.getElementById('test')

    let pIntrod = document.createElement("p")
    pIntrod.setAttribute("style", "font-size:2em");
    let textIntrod = document.createTextNode("El título del test de hoy es: ")
    pIntrod.appendChild(textIntrod);

    let pTitulo = document.createElement("p")
    pTitulo.setAttribute("style", "font-size:3em; color:rgb(255, 221, 28); margin-top:0.5em; margin-bottom:5px");
    let textTitulo = document.createTextNode(test["titulo"])
    pTitulo.appendChild(textTitulo);

    let pPreg = document.createElement("p")
    pPreg.setAttribute("style", "font-size:1em; margin-top:5px; margin-bottom: 70px")
    let textPreg = document.createTextNode(test["num_preguntas"] + " preguntas - " + test["dificultad"])
    pPreg.appendChild(textPreg);

    let botonJugar = document.createElement("a")
    botonJugar.setAttribute("class", "boton")
    botonJugar.setAttribute("href", "/calculadora/jugar?cod_test=" + test["cod_test"])
    let textBoton = document.createTextNode("¡A jugar!")
    botonJugar.appendChild(textBoton)

    divTest.appendChild(pIntrod)
    divTest.appendChild(pTitulo)
    divTest.appendChild(pPreg)
    divTest.appendChild(botonJugar)

}

function adivinaDiario (test) {
    let divTest = document.getElementById('adivina')

    let pIntrod = document.createElement("p")
    pIntrod.setAttribute("style", "font-size:2em");
    let textIntrod = document.createTextNode("El título del juego de hoy es: ")
    pIntrod.appendChild(textIntrod);

    let pTitulo = document.createElement("p")
    pTitulo.setAttribute("style", "font-size:3em; color:rgb(255, 221, 28); margin-top:0.5em; margin-bottom:5px");
    let textTitulo = document.createTextNode(test["titulo"])
    pTitulo.appendChild(textTitulo);

    let pPreg = document.createElement("p")
    pPreg.setAttribute("style", "font-size:1em; margin-top:5px; margin-bottom: 70px")
    let textPreg = document.createTextNode(test["num_palabras"] + " palabras - " + test["dificultad"])
    pPreg.appendChild(textPreg);

    let botonJugar = document.createElement("a")
    botonJugar.setAttribute("class", "boton")
    botonJugar.setAttribute("href", "/adivina/jugar?cod_adivina=" + test["cod_adivina"])
    let textBoton = document.createTextNode("¡A jugar!")
    botonJugar.appendChild(textBoton)

    divTest.appendChild(pIntrod)
    divTest.appendChild(pTitulo)
    divTest.appendChild(pPreg)
    divTest.appendChild(botonJugar)

}

function noHaytest () {
    let divTest = document.getElementById('test')

    let pIntrod = document.createElement("p")
    pIntrod.setAttribute("style", "font-size:2em");
    let textIntrod = document.createTextNode("Hoy no hay un test programado.")
    pIntrod.appendChild(textIntrod);

    let pTitulo = document.createElement("p")
    pTitulo.setAttribute("style", "font-size:3em; color:rgb(255, 221, 28); margin-top:0.5em; margin-bottom:70px");
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

function noHayAdivina () {
    let divTest = document.getElementById('adivina')

    let pIntrod = document.createElement("p")
    pIntrod.setAttribute("style", "font-size:2em");
    let textIntrod = document.createTextNode("Hoy no hay un juego programado.")
    pIntrod.appendChild(textIntrod);

    let pTitulo = document.createElement("p")
    pTitulo.setAttribute("style", "font-size:3em; color:rgb(255, 221, 28); margin-top:0.5em; margin-bottom:70px");
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