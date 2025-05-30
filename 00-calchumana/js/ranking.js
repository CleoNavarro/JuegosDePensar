var datos = [];

obtenerDatos()

function obtenerDatos () {

    let loc = "http://www.juegosdepensar.com/api/ranking"

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

    // Apartado Calculadora Humana Dia

    let tituloCalcDia = document.createElement("h3");
    tituloCalcDia.innerHTML = "Reto diario";

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

    contCalcDia.appendChild(tituloCalcDia);
    contCalcDia.appendChild(tablaCalcDia);

    // Apartado Calculadora Humana Mes

    let tituloCalcMes = document.createElement("h3");
    tituloCalcMes.innerHTML = "Ranking Mensual";

    let contCalcMes = document.getElementById("calcMes");

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

    contCalcMes.appendChild(tituloCalcMes);
    contCalcMes.appendChild(tablaCalcMes);

    // Apartado Adivina la Palabra Dia

    let tituloAdivDia = document.createElement("h3");
    tituloAdivDia.innerHTML = "Reto diario";

    let contAdivDia = document.getElementById("adivDia");

    let tablaAdivDia = document.createElement("table");
        tablaAdivDia.setAttribute("class", "tablaPuntuacion");

    let trheadAD = document.createElement("tr");
    let th1AD= document.createElement("th");
        th1AD.innerText = "Posición";
    let th2AD= document.createElement("th");
        th2AD.innerText = "Jugador";
    let th3AD= document.createElement("th");
        th3AD.innerText = "Puntos";

    trheadAD.appendChild(th1AD);
    trheadAD.appendChild(th2AD);
    trheadAD.appendChild(th3AD);
    tablaAdivDia.appendChild(trheadAD);

    let datosAdivDia = datos["adiv_diario"];

    if (datosAdivDia) {
        for (let i = 1; i <= Object.keys(datosAdivDia).length && i <= 10; i++) {
            let trlinea = document.createElement("tr");
            let td1= document.createElement("td");
            td1.innerText = datosAdivDia[i]["posicion"];
            let td2= document.createElement("td");
            td2.innerText = datosAdivDia[i]["nick"];
            let td3= document.createElement("td");
            td3.innerText = datosAdivDia[i]["puntos"];
            trlinea.appendChild(td1);
            trlinea.appendChild(td2);
            trlinea.appendChild(td3);
            tablaAdivDia.appendChild(trlinea);
        }
    }

    contAdivDia.appendChild(tituloAdivDia);
    contAdivDia.appendChild(tablaAdivDia);

    // Apartado Adivina la Palabra Mes

    let tituloAdivMes = document.createElement("h3");
    tituloAdivMes.innerHTML = "Ranking Mensual";

    let contAdivMes = document.getElementById("adivMes");

    let tablaAdivMes = document.createElement("table");
        tablaAdivMes.setAttribute("class", "tablaPuntuacion");

    let trheadAM = document.createElement("tr");
    let th1AM= document.createElement("th");
        th1AM.innerText = "Posición";
    let th2AM= document.createElement("th");
        th2AM.innerText = "Jugador";
    let th3AM= document.createElement("th");
        th3AM.innerText = "Puntos";

    trheadAM.appendChild(th1AM);
    trheadAM.appendChild(th2AM);
    trheadAM.appendChild(th3AM);
    tablaAdivMes.appendChild(trheadAM);

    let datosAdivMes = datos["adiv_mes"];

    if (datosAdivMes) {
        for (let i = 1; i <= Object.keys(datosAdivMes).length && i <= 10; i++) {
            let trlinea = document.createElement("tr");
            let td1= document.createElement("td");
            td1.innerText = datosAdivMes[i]["posicion"];
            let td2= document.createElement("td");
            td2.innerText = datosAdivMes[i]["nick"];
            let td3= document.createElement("td");
            td3.innerText = datosAdivMes[i]["puntos"];
            trlinea.appendChild(td1);
            trlinea.appendChild(td2);
            trlinea.appendChild(td3);
            tablaAdivMes.appendChild(trlinea);
        }
    }

    contAdivMes.appendChild(tituloAdivMes);
    contAdivMes.appendChild(tablaAdivMes);

}