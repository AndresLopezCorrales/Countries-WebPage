<?php

class GetNameController{

    //Obtener nombre del país cuando se clickee en él
    function clickCountries(){
        if(isset($_POST["titulo"])) { //si existe?
            // Obtener el título enviado desde JavaScript
            $titulo = $_POST["titulo"];
            return $titulo;
        } else {
            return "";
        }
    }
}
?>