var datos = [];

obtenerDatos()

function obtenerDatos () {

    let loc = "http://www.juegosdepensar.com/api/datos"

    let cod_usuario = document.getElementById("cod_usuario").value

    let busqueda = new Request(loc, {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "cod_usuario=" + cod_usuario
    })

    fetch(busqueda).then(function (resp) {
        if (resp.ok) {
            let res = resp.json();

            res.then( function (resp) {
                if (resp["correcto"]) {
                    datos = resp["datos"]
                    cargarDatos()
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

function cargarDatos () {

    // Apartado Datos

    let contDatos = document.getElementById("datosInfo");

    let foto = document.createElement("img");
    foto.setAttribute("class", "imagenInfo");
    foto.setAttribute("src", datos["datos"]["foto"]);
    foto.setAttribute("alt", "Foto "+datos["datos"]["nick"]);

    let lista = document.createElement("ul");

    let lineaNick = document.createElement("li");
    lineaNick.setAttribute("style", "font-weight: bold; font-size: 1.5em; color: rgb(255, 221, 28)")
    lineaNick.innerHTML = datos["datos"]["nick"];

    let lineaNombre = document.createElement("li");
    lineaNombre.innerHTML = datos["datos"]["nombre"];

    let lineaReg = document.createElement("li");
    lineaReg.innerHTML = "Fecha de Registro: " + datos["datos"]["fecha_registrado"];

    lista.appendChild(lineaNick);
    lista.appendChild(lineaNombre);
    lista.appendChild(lineaReg);

    contDatos.appendChild(foto);
    contDatos.appendChild(lista);

    // Apartado Estadísticas

    let contStatsCalc = document.getElementById("calcStats");

    let statsCalc = datos["calc_estadisticas"];

    let logoCalc = document.createElement("img");
    logoCalc.setAttribute("class", "logo");
    logoCalc.setAttribute("src", "/imagenes/logocalculadora.png");
    logoCalc.setAttribute("alt", "Logo Calculadora Humana");

    let pJuegosCalc = document.createElement("p");
    pJuegosCalc.innerHTML = "Partidas a Calculadora Humana: " + statsCalc["total"];

    let listaCalc = document.createElement("ul");
    let lineaCalcFacil = document.createElement("li");
    lineaCalcFacil.innerHTML = "Partidas en Fácil: " + statsCalc["facil"];
    let lineaCalcNormal = document.createElement("li");
    lineaCalcNormal.innerHTML = "Partidas en Normal: " + statsCalc["normal"];
    let lineaCalcDificil = document.createElement("li");
    lineaCalcDificil.innerHTML = "Partidas en Difícil: " + statsCalc["dificil"];
    listaCalc.appendChild(lineaCalcFacil);
    listaCalc.appendChild(lineaCalcNormal);
    listaCalc.appendChild(lineaCalcDificil);

    let pPuntosCalc = document.createElement("p");
    pPuntosCalc.innerHTML = "Puntos totales en Calculadora Humana: " + statsCalc["puntuacion_total"];

    contStatsCalc.appendChild(logoCalc);
    contStatsCalc.appendChild(pJuegosCalc);
    contStatsCalc.appendChild(listaCalc);
    contStatsCalc.appendChild(pPuntosCalc);

    let contStatsAdiv = document.getElementById("adivStats");

    let statsAdiv = datos["adiv_estadisticas"];

    let logoAdiv = document.createElement("img");
    logoAdiv.setAttribute("class", "logo");
    logoAdiv.setAttribute("src", "/imagenes/logoadivina.png");
    logoAdiv.setAttribute("alt", "Logo Adivina la Palabra");

    let pJuegosAdiv = document.createElement("p");
    pJuegosAdiv.innerHTML = "Partidas a Adivina la Palabra: " + statsAdiv["total"];

    let listaAdiv = document.createElement("ul");
    let lineaAdivFacil = document.createElement("li");
    lineaAdivFacil.innerHTML = "Partidas en Fácil: " + statsAdiv["facil"];
    let lineaAdivNormal = document.createElement("li");
    lineaAdivNormal.innerHTML = "Partidas en Normal: " + statsAdiv["normal"];
    let lineaAdivDificil = document.createElement("li");
    lineaAdivDificil.innerHTML = "Partidas en Difícil: " + statsAdiv["dificil"];
    listaAdiv.appendChild(lineaAdivFacil);
    listaAdiv.appendChild(lineaAdivNormal);
    listaAdiv.appendChild(lineaAdivDificil);

    let pPuntosAdiv = document.createElement("p");
    pPuntosAdiv.innerHTML = "Puntos totales en Adivina la Palabra: " + statsAdiv["puntuacion_total"];

    contStatsAdiv.appendChild(logoAdiv);
    contStatsAdiv.appendChild(pJuegosAdiv);
    contStatsAdiv.appendChild(listaAdiv);
    contStatsAdiv.appendChild(pPuntosAdiv);

    // Apartado Recientes

    let contRecientes = document.getElementById("tab2-content");

    let tablaJuegos = document.createElement("table");
    tablaJuegos.setAttribute("class", "tablaPuntuacion");
    tablaJuegos.setAttribute("id", "tablaRecientes");

    let trhead = document.createElement("tr");
    let th1= document.createElement("th");
    th1.innerText = "Juego";
    let th2= document.createElement("th");
    th2.innerText = "Fecha";
    let th3= document.createElement("th");
    th3.innerText = "Título";
    let th4= document.createElement("th");
    th4.innerText = "Dificultad";
    let th5= document.createElement("th");
    th5.innerText = "Puntos";
    trhead.appendChild(th1);
    trhead.appendChild(th2);
    trhead.appendChild(th3);
    trhead.appendChild(th4);
    trhead.appendChild(th5);
    tablaJuegos.appendChild(trhead);

    let recientes = datos["recientes"];

    if (recientes) {
        for (let i = 0; i < recientes.length; i++) {
            let trlinea = document.createElement("tr");
            let td1= document.createElement("td");
            td1.innerText = recientes[i]["juego"];
            let td2= document.createElement("td");
            td2.innerText = recientes[i]["fecha_realizado"];
            let td3= document.createElement("td");
            td3.innerText = recientes[i]["titulo"];
            let td4= document.createElement("td");
            td4.innerText = recientes[i]["dificultad"];
            let td5= document.createElement("td");
            td5.innerText = recientes[i]["puntos"];
            trlinea.appendChild(td1);
            trlinea.appendChild(td2);
            trlinea.appendChild(td3);
            trlinea.appendChild(td4);
            trlinea.appendChild(td5);
            tablaJuegos.appendChild(trlinea);
        }
    }

    contRecientes.appendChild(tablaJuegos);
    

    // Apartado Ranking

    let contRakingCalc = document.getElementById("calcRank");

    let rankingCalc = datos["calc_ranking"];

    let logoCalc2 = document.createElement("img");
    logoCalc2.setAttribute("class", "logo");
    logoCalc2.setAttribute("src", "/imagenes/logocalculadora.png");
    logoCalc2.setAttribute("alt", "Logo Calculadora Humana");

    let pRankingHoyCalc = document.createElement("p");
    pRankingHoyCalc.innerHTML = "Posición en el desafio de hoy: " + rankingCalc["posicion_hoy"];

    let pPuntosHoyCalc = document.createElement("p");
    pPuntosHoyCalc.innerHTML = "Puntos en el desafio de hoy: " + rankingCalc["puntos_hoy"];

    let pRankingMesCalc = document.createElement("p");
    pRankingMesCalc.innerHTML = "Posición en el ranking mensual: " + rankingCalc["posicion_mes"];

    let pPuntosMesCalc = document.createElement("p");
    pPuntosMesCalc.innerHTML = "Puntos en el ranking mensual: " + rankingCalc["puntos_mes"];

    contRakingCalc.appendChild(logoCalc2);
    contRakingCalc.appendChild(pRankingHoyCalc);
    contRakingCalc.appendChild(pPuntosHoyCalc);
    contRakingCalc.appendChild(pRankingMesCalc);
    contRakingCalc.appendChild(pPuntosMesCalc);

    let contRakingAdiv = document.getElementById("adivRank");

    let rankingAdiv = datos["adiv_ranking"];

    let logoAdiv2 = document.createElement("img");
    logoAdiv2.setAttribute("class", "logo");
    logoAdiv2.setAttribute("src", "/imagenes/logoadivina.png");
    logoAdiv2.setAttribute("alt", "Logo Adivina la palabra");

    let pRankingHoyAdiv = document.createElement("p");
    pRankingHoyAdiv.innerHTML = "Posición en el desafio de hoy: " + rankingAdiv["posicion_hoy"];

    let pPuntosHoyAdiv = document.createElement("p");
    pPuntosHoyAdiv.innerHTML = "Puntos en el desafio de hoy: " + rankingAdiv["puntos_hoy"];

    let pRankingMesAdiv = document.createElement("p");
    pRankingMesAdiv.innerHTML = "Posición en el ranking mensual: " + rankingAdiv["posicion_mes"];

    let pPuntosMesAdiv = document.createElement("p");
    pPuntosMesAdiv.innerHTML = "Puntos en el ranking mensual: " + rankingAdiv["puntos_mes"];

    contRakingAdiv.appendChild(logoAdiv2);
    contRakingAdiv.appendChild(pRankingHoyAdiv);
    contRakingAdiv.appendChild(pPuntosHoyAdiv);
    contRakingAdiv.appendChild(pRankingMesAdiv);
    contRakingAdiv.appendChild(pPuntosMesAdiv);

}