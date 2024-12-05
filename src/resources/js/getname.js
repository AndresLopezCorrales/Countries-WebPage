
//Selecciona todas las etiquetas country

var enlacesSvg = document.querySelectorAll(".country");

enlacesSvg.forEach(function (enlaceSvg) {
    enlaceSvg.addEventListener("click", function (event) {
        event.preventDefault();

        //Obtener titulo de la etiqueta (Nombre del país)
        var titulo = enlaceSvg.getAttribute("xlink:title");

        //Crear un form dinamicamente para poder mandar el titulo como form POST
        var form = document.createElement("form");
        form.style.display = "none";
        form.method = "POST";

        //Form oculto
        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "titulo";
        input.value = titulo;

        // Agregar el input al form
        form.appendChild(input);
        document.body.appendChild(form);

        // Enviar el forms
        form.submit();

    });
});


