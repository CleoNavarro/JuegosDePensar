
document.getElementById("preguntamas").onclick = preguntaMas;
document.getElementById("preguntamenos").onclick = preguntaMenos;

function preguntaMas () {
    let input = document.getElementById("num_preguntas");
    let valor = parseInt(input.value);

    if (valor >= 12) {
        window.alert("No puedes añadir más preguntas. El máximo es 12");
        return;
    }

    valor++; 
    input.value = valor;

    let separador = document.createElement("hr");
    separador.setAttribute("id" , "separador" + valor);
    separador.setAttribute("class", "separador");

    let labelenunciado = document.createElement("label");
    labelenunciado.setAttribute("for", "preguntas["+valor+"][enunciado]");
    labelenunciado.setAttribute("id", "labelenunciado"+valor);
    labelenunciado.innerHTML = "Pregunta " + valor;

    let textenunciado = document.createElement("input");
    textenunciado.setAttribute("type", "text");
    textenunciado.setAttribute("name", "preguntas["+valor+"][enunciado]");
    textenunciado.setAttribute("id", "textenunciado"+valor);

    let labeltipo = document.createElement("label");
    labeltipo.setAttribute("for", "preguntas["+valor+"][cod_tipo]");
    labeltipo.setAttribute("id", "labeltipo"+valor);
    labeltipo.innerHTML = "Tipo Pregunta";

    let listtipo = document.createElement("select");
    listtipo.setAttribute("id", "listtipo"+valor);
    listtipo.setAttribute("name", "preguntas["+valor+"][cod_tipo]");
    let option0 = document.createElement("option");
    option0.innerHTML = "Seleccione una opción";
    let option1 = document.createElement("option");
    option1.setAttribute("selected", "selected");
    option1.setAttribute("value", "1");
    option1.innerHTML = "Operación";
    let option2 = document.createElement("option");
    option2.setAttribute("value", "2");
    option2.innerHTML = "Pregunta";
    listtipo.appendChild(option0);
    listtipo.appendChild(option1);
    listtipo.appendChild(option2);

    let labelrespuesta = document.createElement("label");
    labelrespuesta.setAttribute("for", "preguntas["+valor+"][cantidad]");
    labelrespuesta.setAttribute("id", "labelrespuesta"+valor);
    labelrespuesta.innerHTML = "Respuesta (hasta este punto)";

    let textrespuesta = document.createElement("input");
    textrespuesta.setAttribute("type", "number");
    textrespuesta.setAttribute("name", "preguntas["+valor+"][cantidad]");
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
    form.appendChild(labeltipo);
    form.appendChild(listtipo);
    form.appendChild(labelrespuesta);
    form.appendChild(textrespuesta);
    form.appendChild(botonSubmit);

}

function preguntaMenos () {
    let input = document.getElementById("num_preguntas");
    let valor = parseInt(input.value);

    if (valor <= 5) {
        window.alert("No puedes quitar más preguntas. El mínimo es 5");
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
