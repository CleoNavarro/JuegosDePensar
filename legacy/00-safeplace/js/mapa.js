
var map = L.map('map');

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
attribution: '&copy; Cleo Navarro Molina | Todos los Derechos Reservados'
}).addTo(map);

var buscar = document.getElementById("btnbuscar")

buscar.onclick = buscarSitioNombre

function Enter (e) {
    if (e.keyCode === 13) {
        e.preventDefault();
        buscar.click();
    }
}

function buscarSitioNombre () {

    let nom = document.getElementById("txtbuscador").value

    if (nom != "")  {
        let loc = location.href + "api/sitios"

        let busqueda = new Request(loc, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "nombre=" + nom 
        })
    
        fetch(busqueda).then(function (resp) {
            if (resp.ok) {
                let res = resp.json();
    
                res.then( function (resp) {
                    if (resp["correcto"]) {
                        let sitio = resp["datos"]
                       
                        nom_sitio = sitio["nombre_sitio"]
                        coor_x = parseFloat(sitio["coor_x"])
                        coor_y = parseFloat(sitio["coor_y"])
    
                        map.setView([coor_x, coor_y], 16)
    
                        L.marker([coor_x, coor_y]).addTo(map)
                        .bindPopup(nom_sitio)
                        .openPopup();
    
                    } else {
                        console.log("Algo habrá pasao, tú sabrás")
                    }            
                })
            }
        }
        ).catch(function (error) {
            console.log(error)
        })
    }
}


function buscarSitioCoor (coor_x, coor_y) {
    
    let loc = location.href + "api/sitios"

    let busqueda = new Request(loc, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "coor_x=" + coor_x + "&coor_y=" + coor_y
        }
    )

    let nom_sitio = "Aquí no hay nada"

    fetch(busqueda).then(function (resp) {
        if (resp.ok) {
            let res = resp.json();

            res.then( function (resp) {
                if (resp["correcto"]) {
                    let sitio = resp["datos"]
                    nom_sitio = sitio["nombre_sitio"]

                    map.setView([coor_x, coor_y], 16)


                    L.marker([coor_x, coor_y]).addTo(map)
                    .bindPopup(nom_sitio)
                    .openPopup();

                }             
            })
        }
    }
    ).catch(function (error) {
        // datos = error;
    });


    

}


	