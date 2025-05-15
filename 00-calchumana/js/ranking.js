var datos = [];

obtenerDatos()

function obtenerDatos () {

    let loc = "http://www.calculadorahumana.com/api/ranking"

    let busqueda = new Request(loc, {
        method: "GET",
        headers: { "Content-Type": "application/x-www-form-urlencoded" }
    })

    fetch(busqueda).then(function (resp) {
        if (resp.ok) {
            let res = resp.json();

            res.then( function (resp) {
                if (resp["correcto"]) {
                    datos = resp["datos"]
                    cargarRanking()
                } else {
                    // TO DO
                }            
            })
        }
    }
    ).catch(function (error) {
        console.log(error)
    })

}


function cargarRanking () {

    let tituloDia = document.createElement("h3");
        tituloDia.innerHTML = "Reto diario";

    let tituloMes = document.createElement("h3");
        tituloMes.innerHTML = "Ranking Mensual";

    // Apartado Calculadora Humana Dia

    let contCalcDia = document.getElementById("calcDia");

    let tablaCalcDia = document.createElement("table");
        tablaCalcDia.setAttribute("class", "tablaPuntuacion");

    let trheadCD = document.createElement("tr");
    let th1CD= document.createElement("th");
        th1CD.innerText = "Posición";
    let th2CD= document.createElement("th");
        th2CD.innerText = "Jugador";
    let th3CD= document.createElement("th");
        th3CD.innerText = "Puntos";

    trheadCD.appendChild(th1CD);
    trheadCD.appendChild(th2CD);
    trheadCD.appendChild(th3CD);
    tablaCalcDia.appendChild(trheadCD);

    let datosCalDia = datos["calc_diario"];

    if (datosCalDia) {
        for (let i = 1; i <= Object.keys(datosCalDia).length && i <= 10; i++) {
            let trlinea = document.createElement("tr");
            let td1= document.createElement("td");
            td1.innerText = datosCalDia[i]["posicion"];
            let td2= document.createElement("td");
            td2.innerText = datosCalDia[i]["nick"];
            let td3= document.createElement("td");
            td3.innerText = datosCalDia[i]["puntos"];
            trlinea.appendChild(td1);
            trlinea.appendChild(td2);
            trlinea.appendChild(td3);
            tablaCalcDia.appendChild(trlinea);
        }
    }

    contCalcDia.appendChild(tituloDia);
    contCalcDia.appendChild(tablaCalcDia);

    // Apartado Calculadora Humana Mes
    let contCalcMes = document.getElementById("calcDia");

    let tablaCalcMes = document.createElement("table");
        tablaCalcMes.setAttribute("class", "tablaPuntuacion");

    let trheadCM = document.createElement("tr");
    let th1CM= document.createElement("th");
        th1CM.innerText = "Posición";
    let th2CM= document.createElement("th");
        th2CM.innerText = "Jugador";
    let th3CM= document.createElement("th");
        th3CM.innerText = "Puntos";

    trheadCM.appendChild(th1CM);
    trheadCM.appendChild(th2CM);
    trheadCM.appendChild(th3CM);
    tablaCalcMes.appendChild(trheadCM);

    let datosCalMes = datos["calc_mes"];

    if (datosCalMes) {
        for (let i = 1; i <= Object.keys(datosCalMes).length && i <= 10; i++) {
            let trlinea = document.createElement("tr");
            let td1= document.createElement("td");
            td1.innerText = datosCalMes[i]["posicion"];
            let td2= document.createElement("td");
            td2.innerText = datosCalMes[i]["nick"];
            let td3= document.createElement("td");
            td3.innerText = datosCalMes[i]["puntos"];
            trlinea.appendChild(td1);
            trlinea.appendChild(td2);
            trlinea.appendChild(td3);
            tablaCalcMes.appendChild(trlinea);
        }
    }

    contCalcMes.appendChild(tituloMes);
    contCalcMes.appendChild(tablaCalcMes);

    // Apartado Adivina la Palabra Dia

    // Apartado Adivina la Palabra Mes

}