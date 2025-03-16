
// function Enter (e) {
//    if (e.keyCode === 13) {
//        e.preventDefault();
//        buscar.click();
//    }
//}
desafioDiario()

function desafioDiario () {

    //let fecha= new Date().getDate() + "/" + new Date().getMonth() + "/" + new Date().getFullYear()

    let fecha= "18/02/2025"

    let loc = location.href + "api/test"

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
                        let test = resp["datos"]
                        testDiario(test)
                    } else {
                        noHaytest ()
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
    pIntrod.setAttribute("style", "font-size:3em");
    let textIntrod = document.createTextNode("El título del test de hoy es: ")
    pIntrod.appendChild(textIntrod);

    let pTitulo = document.createElement("p")
    pTitulo.setAttribute("style", "font-size:4em; color:rgb(255, 221, 28); margin-top:0.5em; margin-bottom:5px");
    let textTitulo = document.createTextNode(test["titulo"])
    pTitulo.appendChild(textTitulo);

    let pPreg = document.createElement("p")
    pPreg.setAttribute("style", "font-size:1em; margin-top:5px; margin-bottom: 70px")
    let textPreg = document.createTextNode(test["num_preguntas"] + " preguntas - " + test["dificultad"])
    pPreg.appendChild(textPreg);

    let botonJugar = document.createElement("a")
    botonJugar.setAttribute("class", "boton")
    botonJugar.setAttribute("href", "/index/jugar?cod_test=" + test["cod_test"])
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