
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
                       
                        console.log("El título del test de hoy es: " + test["titulo"])

                    } else {
                        console.log("No hay un test programado para hoy. ¡Prueba mañana!")
                    }            
                })
            }
        }
        ).catch(function (error) {
            console.log(error)
        })
    
}