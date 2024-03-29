var enlacesSvg = document.querySelectorAll(".country");

enlacesSvg.forEach(function (enlaceSvg) {
    enlaceSvg.addEventListener("click", function (event) {
        event.preventDefault();
        var titulo = enlaceSvg.getAttribute("xlink:title");
        console.log(titulo);

        var form = document.createElement('form');
        form.style.display = 'none';
        form.method = 'POST';
        //form.action = 'apiconsumer.php';

        // Crear un campo de entrada para enviar el título
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'titulo';
        input.value = titulo;

        // Agregar el campo de entrada al formulario y agregar el formulario al documento
        form.appendChild(input);
        document.body.appendChild(form);

        // Enviar el formulario
        form.submit();



    });
});
