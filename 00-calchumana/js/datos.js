var datos = [];

obtenerDatos()

function obtenerDatos () {

    let loc = "http://www.calculadorahumana.com/api/datos"

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
    foto.setAttribute("src", "/imagenes/web/usuarios/"+datos["datos"]["foto"]);
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

    let contEstadisticas = document.getElementById("tab1-content");

    let stats = datos["estadisticas"];

    let tituloCalc = document.createElement("h3");
    tituloCalc.innerHTML = "Calculadora Humana";

    let pJuegosCalc = document.createElement("p");
    pJuegosCalc.innerHTML = "Partidas a Calculadora Humana: " + stats["total"];

    let listaCalc = document.createElement("ul");
    let lineaCalcFacil = document.createElement("li");
    lineaCalcFacil.innerHTML = "Partidas en Fácil: " + stats["facil"];
    let lineaCalcNormal = document.createElement("li");
    lineaCalcNormal.innerHTML = "Partidas en Normal: " + stats["normal"];
    let lineaCalcDificil = document.createElement("li");
    lineaCalcDificil.innerHTML = "Partidas en Difícil: " + stats["dificil"];
    listaCalc.appendChild(lineaCalcFacil);
    listaCalc.appendChild(lineaCalcNormal);
    listaCalc.appendChild(lineaCalcDificil);

    let pPuntosCalc = document.createElement("p");
    pPuntosCalc.innerHTML = "Puntos totales en Calculadora Humana: " + stats["puntuacion_total"];

    contEstadisticas.appendChild(tituloCalc);
    contEstadisticas.appendChild(pJuegosCalc);
    contEstadisticas.appendChild(listaCalc);
    contEstadisticas.appendChild(pPuntosCalc);

    // Apartado Recientes

    let contRecientes = document.getElementById("tab2-content");

    let tablaJuegos = document.createElement("table");
    tablaJuegos.setAttribute("class", "tablaPuntuacion");

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
            td1.innerText = "Calculadora Humana";
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
    

    // TODO: Apartado Ranking

    let contRaking = document.getElementById("tab3-content");

    let ranking = datos["ranking"];

    let tituloCalc2 = document.createElement("h3");
    tituloCalc2.innerHTML = "Calculadora Humana";

    let pRankingHoy = document.createElement("p");
    pRankingHoy.innerHTML = "Posición en el desafio de hoy: " + ranking["posicion_hoy"];

    let pPuntosHoy = document.createElement("p");
    pPuntosHoy.innerHTML = "Puntos en el desafio de hoy: " + ranking["puntos_hoy"];

    let pRankingMes = document.createElement("p");
    pRankingMes.innerHTML = "Posición en el ranking mensual: " + ranking["posicion_mes"];

    let pPuntosMes = document.createElement("p");
    pPuntosMes.innerHTML = "Puntos en el ranking mensual: " + ranking["puntos_mes"];

    contRaking.appendChild(tituloCalc2);
    contRaking.appendChild(pRankingHoy);
    contRaking.appendChild(pPuntosHoy);
    contRaking.appendChild(pRankingMes);
    contRaking.appendChild(pPuntosMes);

}