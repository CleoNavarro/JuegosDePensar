
var map = L.map('map');

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
attribution: '&copy; Cleo Navarro Molina | Todos los Derechos Reservados'
}).addTo(map);

buscarSitio("37.01894", "-4.55572")


function buscarSitio (coor_x, coor_y) {
    
    let loc = location.href + "sitios/index"

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


	