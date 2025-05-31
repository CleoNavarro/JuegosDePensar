
document.getElementById("palabramas").onclick = palabraMas;
document.getElementById("palabramenos").onclick = palabraMenos;

function palabraMas () {
    let input = document.getElementById("num_palabras");
    let valor = parseInt(input.value);

    if (valor >= 12) {
        window.alert("No puedes añadir más palabras. El máximo es 12");
        return;
    }

    valor++; 
    input.value = valor;

    let separador = document.createElement("hr");
    separador.setAttribute("id" , "separador" + valor);
    separador.setAttribute("class", "separador");

    let labelenunciado = document.createElement("label");
    labelenunciado.setAttribute("for", "palabras["+valor+"][enunciado]");
    labelenunciado.setAttribute("id", "labelenunciado"+valor);
    labelenunciado.innerHTML = "Enunciado " + valor;

    let textenunciado = document.createElement("input");
    textenunciado.setAttribute("type", "text");
    textenunciado.setAttribute("name", "palabras["+valor+"][enunciado]");
    textenunciado.setAttribute("id", "textenunciado"+valor);

    let labelsiglas = document.createElement("label");
    labelsiglas.setAttribute("for", "palabras["+valor+"][siglas]");
    labelsiglas.setAttribute("id", "labelsiglas"+valor);
    labelsiglas.innerHTML = "Siglas";

    let textsiglas = document.createElement("input");
    textsiglas.setAttribute("type", "text");
    textsiglas.setAttribute("name", "palabras["+valor+"][siglas]");
    textsiglas.setAttribute("id", "textsiglas"+valor);

    let labelrespuesta = document.createElement("label");
    labelrespuesta.setAttribute("for", "palabras["+valor+"][respuesta]");
    labelrespuesta.setAttribute("id", "labelrespuesta"+valor);
    labelrespuesta.innerHTML = "Respuesta";

    let textrespuesta = document.createElement("input");
    textrespuesta.setAttribute("type", "text");
    textrespuesta.setAttribute("name", "palabras["+valor+"][respuesta]");
    textrespuesta.setAttribute("id", "textrespuesta"+valor);

    let botonSubmit = document.createElement("input");
    botonSubmit.setAttribute("type", "submit");
    botonSubmit.setAttribute("name", "id_2");
    botonSubmit.setAttribute("value", "Crear");

    let form = document.getElementById("formulario");

    form.removeChild(form.lastChild);

    form.appendChild(separador);
    form.appendChild(labelenunciado);
    form.appendChild(textenunciado);
    form.appendChild(labelsiglas);
    form.appendChild(textsiglas);
    form.appendChild(labelrespuesta);
    form.appendChild(textrespuesta);
    form.appendChild(botonSubmit);

}

function palabraMenos () {
    let input = document.getElementById("num_palabras");
    let valor = parseInt(input.value);

    if (valor <= 5) {
        window.alert("No puedes quitar más palabras. El mínimo es 5");
        return;
    }

    valor--; 
    input.value = valor;

    let form = document.getElementById("formulario");

    for (let i = 0; i < 8; i++) {
        form.removeChild(form.lastChild);
    }

    let botonSubmit = document.createElement("input");
    botonSubmit.setAttribute("type", "submit");
    botonSubmit.setAttribute("name", "id_2");
    botonSubmit.setAttribute("value", "Crear");

    form.appendChild(botonSubmit);
}
