<?php

class controller{

    //Get name of the cpountry when click on it
    function clickCountries(){
        if(isset($_POST["titulo"])) {
            // Obtener el título enviado desde JavaScript
            $titulo = $_POST["titulo"];
            
            // Realizar cualquier procesamiento necesario con el título
            
            // Devolver el título de manera normal
            return $titulo;
        } else {
            // Si no se recibió el título, devolver un mensaje de error
            return "";
        }


    }

}

?>